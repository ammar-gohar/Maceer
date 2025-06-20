from collections import defaultdict
import random
import zipfile
import sys
import os
import networkx as nx
import pandas as pd
from reportlab.lib.pagesizes import letter
from reportlab.platypus import SimpleDocTemplate, Table, TableStyle, Paragraph, Spacer
from reportlab.lib import colors
from reportlab.lib.styles import getSampleStyleSheet
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont
import arabic_reshaper
from bidi.algorithm import get_display
from datetime import datetime, timedelta
from collections import Counter
import matplotlib.pyplot as plt
from matplotlib.dates import DayLocator, DateFormatter
import argparse
import time

STORAGE_PATH = "/var/www/Maceer/storage/app/private"

OUTPUT_PATH = ""

def parse_args():
    parser = argparse.ArgumentParser(description="Exam Scheduler Tool")

    # Required positional arguments
    parser.add_argument("csv_file", help="Path to the CSV file")
    parser.add_argument("plot", choices=["generate_plots", "no"], help="Plot generation toggle")
    parser.add_argument("start_date", help="Start date (YYYY-MM-DD)")
    parser.add_argument("end_date", help="End date (YYYY-MM-DD)")
    parser.add_argument("output_dir", help="Output directory in storage")

    # Optional flags
    parser.add_argument("--fridays", action="store_true", help="Include Friday exams")
    parser.add_argument(
        "--holidays", 
        default="",      # Default empty list if not provided
        help="List of holiday dates (YYYY-MM-DD)"
    )

    return parser.parse_args()
# تسجيل خط يدعم العربي
pdfmetrics.registerFont(TTFont('Arial', 'Arial.ttf'))  # تأكدي إن Arial.ttf موجود على جهازك

# دالة لتحويل التاريخ من نص إلى كائن datetime
def parse_date(date_str):
    try:
        return datetime.strptime(date_str, '%Y-%m-%d')
    except ValueError:
        raise ValueError("Date format must be YYYY-MM-DD (example: 2025-06-01).")

# دالة للحصول على إدخال المستخدم لتواريخ الامتحانات
def get_exam_period():
    start_date_str = args.start_date
    start_date = parse_date(start_date_str)
    end_date_str = args.end_date
    end_date = parse_date(end_date_str)
    
    if end_date < start_date:
        raise ValueError("The end date must be after the start date.")
    
    try:
        max_exam_days = 1337
    except ValueError:
        raise ValueError("The number of days must be a positive integer.")
    
    # جمع تواريخ الإجازات
    holidays = []
    try:
        if args.holidays != "":
            holidays_args = args.holidays.split(",")
            for holiday_str in holidays_args:
                try:
                    holiday_date = parse_date(holiday_str)
                    if start_date <= holiday_date <= end_date:
                        holidays.append(holiday_date)
                    else:
                        print("The date is outside the exam period, ignored...")
                except ValueError:
                    print("Incorrect date format, try again or press Enter to finish.")
    except IndexError:
        pass
    return start_date, end_date, max_exam_days, holidays

# دالة لإنشاء قائمة بالأيام الصالحة للامتحانات
def get_valid_exam_days(start_date, end_date, holidays):
    if args.fridays:
        valid_days = []
        current_date = start_date
        while current_date <= end_date:
            if current_date not in holidays:
                valid_days.append(current_date)
            current_date += timedelta(days=1)
        return valid_days
    valid_days = []
    current_date = start_date
    while current_date <= end_date:
        # استبعاد أيام الجمعة (weekday() == 4) والإجازات
        if current_date.weekday() != 4 and current_date not in holidays:
            valid_days.append(current_date)
        current_date += timedelta(days=1)
    return valid_days

# دالة لقراءة بيانات الطلاب من ملف CSV
def read_student_courses(file_path):
    df = pd.read_csv(file_path)
    students_data = {}
    
    current_name = None
    for i, row in df.iterrows():
        name = row['Name']
        if pd.notna(name) and name.strip():
            current_name = name.strip()
        df.at[i, 'Name'] = current_name
    
    for name, group in df.groupby('Name'):
        courses = group['Courses'].dropna().apply(lambda x: x.strip()).tolist()
        if courses:
            students_data[name] = {'level': 1, 'courses': courses}
    
    return students_data

# بناء رسم بياني للتعارضات
def build_conflict_graph(students_data):
    G = nx.Graph()
    all_courses = set()
    for student in students_data.values():
        all_courses.update(student['courses'])
    
    G.add_nodes_from(all_courses)
    
    for student in students_data.values():
        courses = student['courses']
        for i in range(len(courses)):
            for j in range(i + 1, len(courses)):
                G.add_edge(courses[i], courses[j])
    
    return G, list(all_courses)

# الجدولة الأولية باستخدام تلوين الرسم البياني
def schedule_exams(G, courses):
    coloring = nx.coloring.greedy_color(G, strategy="saturation_largest_first")
    exam_schedule = {}
    for course in courses:
        exam_schedule[course] = coloring[course] + 1
    return exam_schedule

# تقليل الأيام المتتالية لكل طالب
def minimize_consecutive_days(students_data, exam_schedule, valid_days):
    adjusted_schedule = exam_schedule.copy()
    
    for student_id, data in students_data.items():
        courses = data['courses']
        if not courses:
            continue
        exam_days = sorted([(adjusted_schedule[course], course) for course in courses])
        
        for i in range(1, len(exam_days)):
            current_day, current_course = exam_days[i]
            prev_day = exam_days[i-1][0]
            if current_day - prev_day <= 1:
                new_day = prev_day + 2
                conflict = False
                for other_student_id, other_data in students_data.items():
                    if other_student_id == student_id:
                        continue
                    other_courses = other_data['courses']
                    for other_course in other_courses:
                        if other_course == current_course:
                            continue
                        if adjusted_schedule.get(other_course) == new_day:
                            if (current_course, other_course) in G.edges or (other_course, current_course) in G.edges:
                                conflict = True
                                break
                    if conflict:
                        break
                if not conflict and new_day <= len(valid_days):
                    adjusted_schedule[current_course] = new_day
                    exam_days[i] = (new_day, current_course)
    
    return adjusted_schedule

def calculate_consecutive_exam_stats(students_data, exam_schedule, valid_days):
    date_mapping = {i + 1: valid_days[i] for i in range(len(valid_days))}
    result_counter = Counter()

    for student_name, data in students_data.items():
        exam_days = sorted([
            day for course in data['courses']
            if (day := exam_schedule.get(course)) is not None
        ])
        
        # Convert to actual dates for accurate gap counting
        exam_dates = [date_mapping[day].date() for day in exam_days if day in date_mapping]
        if not exam_dates:
            continue

        # Find the longest sequence of consecutive dates
        max_streak = streak = 1
        for i in range(1, len(exam_dates)):
            if (exam_dates[i] - exam_dates[i - 1]).days == 1:
                streak += 1
                max_streak = max(max_streak, streak)
            else:
                streak = 1

        result_counter[max_streak] += 1

    return result_counter

def find_same_day_conflicts(students_data, exam_schedule):
    """
    Return a dict of students who have 2+ exams on the same day:
      { student_name: { day_int: [course1, course2, …], … }, … }
    """
    conflicts = {}
    for stu, info in students_data.items():
        day_map = {}
        for course in info['courses']:
            day = exam_schedule.get(course)
            if day is None:
                continue
            day_map.setdefault(day, []).append(course)
        # keep only days with multiple courses
        bad = {d: courses for d, courses in day_map.items() if len(courses) > 1}
        if bad:
            conflicts[stu] = bad
    return conflicts

def create_zip_from_paths(paths, zip_name="output.zip"):
    with zipfile.ZipFile(zip_name, 'w', zipfile.ZIP_DEFLATED) as zipf:
        for path in paths:
            if os.path.isfile(path):
                arcname = os.path.basename(path)
                zipf.write(path, arcname)
            elif os.path.isdir(path):
                for foldername, _, filenames in os.walk(path):
                    for filename in filenames:
                        file_path = os.path.join(foldername, filename)
                        arcname = os.path.relpath(file_path, os.path.dirname(path))
                        zipf.write(file_path, arcname)
            else:
                print(f"Skipped: {path} (not found)")

# ضغط الجدول ليكون في عدد الأيام المحدد
def compress_schedule(students_data, exam_schedule, valid_days, max_days, max_attempts=200):
    """
    Tries to produce a compact exam schedule with no conflicts,
    avoiding same-day exams and long streaks. Falls back to a simple
    greedy schedule if no good one is found.
    """
    global G

    course_to_students = defaultdict(set)
    for stu, info in students_data.items():
        for c in info['courses']:
            course_to_students[c].add(stu)

    original_courses = list(exam_schedule.keys())
    MAX_STREAK = 3  # More realistic for exam stress

    def would_exceed_max_streak(days_set, candidate_day):
        all_days = sorted(days_set | {candidate_day})
        streak = 1
        for i in range(1, len(all_days)):
            if all_days[i] == all_days[i - 1] + 1:
                streak += 1
                if streak > MAX_STREAK:
                    return True
            else:
                streak = 1
        return False

    def try_once(course_order):
        new_schedule = {}
        student_days = {stu: set() for stu in students_data}

        for course in course_order:
            # 1. No conflict with adjacent courses in the graph
            days_ok = [d for d in range(1, max_days + 1)
                       if not any(new_schedule.get(nb) == d for nb in G[course])]

            # 2. No student has two exams on same day
            days_ok = [d for d in days_ok
                       if all(d not in student_days[stu] for stu in course_to_students[course])]

            # 3. No student exceeds max streak
            days_ok = [d for d in days_ok
                       if all(not would_exceed_max_streak(student_days[stu], d)
                              for stu in course_to_students[course])]

            if not days_ok:
                return None

            # 4. Prefer spacing exams apart
            def score(d):
                gaps = []
                for stu in course_to_students[course]:
                    dd = student_days[stu]
                    gaps.append(max_days if not dd else min(abs(d - d0) for d0 in dd))
                return min(gaps)

            best_day = max(days_ok, key=lambda d: (score(d), d))
            new_schedule[course] = best_day
            for stu in course_to_students[course]:
                student_days[stu].add(best_day)

        return new_schedule

    # Attempt with best order first
    base_order = sorted(original_courses, key=lambda c: -len(course_to_students[c]))
    attempt_orders = [base_order]

    # Then try shuffled versions
    for _ in range(max_attempts - 1):
        order = base_order[:]
        random.shuffle(order)
        attempt_orders.append(order)

    for idx, order in enumerate(attempt_orders):
        result = try_once(order)
        if result:
            return result

    # ✅ Greedy fallback
    compressed_schedule = {}
    courses_on_day = defaultdict(list)
    current_day = 1

    for _, course in sorted([(exam_schedule[c], c) for c in exam_schedule]):
        while True:
            conflict = False
            for other in courses_on_day[current_day]:
                if (course, other) in G.edges or (other, course) in G.edges:
                    conflict = True
                    break
            if not conflict and current_day <= max_days:
                compressed_schedule[course] = current_day
                courses_on_day[current_day].append(course)
                break
            else:
                current_day += 1
                if current_day > max_days:
                    print("Conflicts", end="")
                    sys.exit(1)
                    return compressed_schedule
    return compressed_schedule



# تحويل أرقام الأيام إلى تواريخ فعلية
def map_days_to_dates(exam_schedule, valid_days):
    date_schedule = {}
    for course, day in exam_schedule.items():
        if day <= len(valid_days):
            date_schedule[course] = valid_days[day - 1].strftime('%Y-%m-%d')
        else:
            date_schedule[course] = "Not scheduled (insufficient number of days)."
    return date_schedule

# دالة لمعالجة النص العربي
def prepare_arabic_text(text):
    reshaped_text = arabic_reshaper.reshape(text)
    return get_display(reshaped_text)

# إنشاء ملف PDF بالجدول
def create_pdf_schedule(exam_schedule, valid_days, output_file):
    doc = SimpleDocTemplate(output_file, pagesize=letter)
    elements = []
    styles = getSampleStyleSheet()
    
    title_style = styles['Title']
    title_style.fontName = 'Arial'
    title_style.fontSize = 16
    
    title_text = prepare_arabic_text("Final exams schedule")
    title = Paragraph(title_text, title_style)
    elements.append(title)
    elements.append(Spacer(1, 12))
    
    data = [[prepare_arabic_text("The date"), prepare_arabic_text("The subject")]]
    for course, day in sorted(exam_schedule.items(), key=lambda x: x[1]):
        date_str = valid_days[day - 1].strftime('%Y-%m-%d') if day <= len(valid_days) else "Not scheduled"
        data.append([date_str, course])
    
    table = Table(data)
    table.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, 0), colors.grey),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.whitesmoke),
        ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
        ('FONTNAME', (0, 0), (-1, 0), 'Arial'),
        ('FONTSIZE', (0, 0), (-1, 0), 14),
        ('BOTTOMPADDING', (0, 0), (-1, 0), 12),
        ('BACKGROUND', (0, 1), (-1, -1), colors.beige),
        ('TEXTCOLOR', (0, 1), (-1, -1), colors.black),
        ('FONTNAME', (0, 1), (-1, -1), 'Arial'),
        ('FONTSIZE', (0, 1), (-1, -1), 12),
        ('GRID', (0, 0), (-1, -1), 1, colors.black),
    ]))
    
    elements.append(table)
    doc.build(elements)
    print(f"PDF file created: {output_file}")

def generate_student_schedules_plot(students_data, exam_schedule, valid_days, output_folder=f"{STORAGE_PATH}/prepare_schedule"):
    if not os.path.exists(output_folder):
        os.makedirs(output_folder)
    
    # Map day numbers to actual dates
    day_to_date = {i + 1: valid_days[i].strftime('%Y-%m-%d') for i in range(len(valid_days))}
    
    for student_name, data in students_data.items():
        courses = data['courses']
        student_exams = []
        
        for course in courses:
            day = exam_schedule.get(course)
            if day and day <= len(valid_days):
                student_exams.append((course, day_to_date[day]))
        
        if not student_exams:
            continue

        student_exams.sort(key=lambda x: x[1])  # Sort by date
        
        fig, ax = plt.subplots(figsize=(14, 1 + len(student_exams)*0.5))
        y_labels = []
        y_pos = []

        for idx, (course, date_str) in enumerate(student_exams):
            date = pd.to_datetime(date_str)
            ax.barh(idx, 1, left=date, height=0.4, align='center',
                    color='skyblue', edgecolor='black')
            y_labels.append(course)
            y_pos.append(idx)

        ax.set_yticks(y_pos)
        ax.set_yticklabels(y_labels, fontsize=10)

        # Set x-axis to tick every 2 days
        ax.xaxis.set_major_locator(DayLocator(interval=1))
        ax.xaxis.set_major_formatter(DateFormatter('%d'))  # Day only

        ax.set_xlabel('Day of Month', fontsize=12)
        arabic_student_name = prepare_arabic_text(student_name)
        ax.set_title(f"Exam Schedule for {arabic_student_name}", fontsize=14)
        ax.grid(axis='x', linestyle='--', alpha=0.6)

        # Optional: make sure labels fit well
        plt.setp(ax.get_xticklabels(), rotation=0, ha='center')
        plt.tight_layout(pad=2)


        # Save the figure
        safe_name = "".join(c if c.isalnum() else "_" for c in student_name)
        plt.savefig(os.path.join(output_folder, f"{safe_name}.png"))
        plt.close()

# الدالة الرئيسية
def create_exam_schedule(csv_file):
    global G
    # الحصول على تواريخ الامتحانات وأيام الإجازة
    start_date, end_date, max_exam_days, holidays = get_exam_period()
    valid_days = get_valid_exam_days(start_date, end_date, holidays)
    if max_exam_days == 1337:
        max_exam_days = len(valid_days)
    
    if len(valid_days) < max_exam_days:
        print(f"Error: The number of valid days ({len(valid_days)}) is less than the required number of exam days ({max_exam_days}).")
        sys.exit(1)
    
    students_data = read_student_courses(csv_file)
    G, courses = build_conflict_graph(students_data)
    exam_schedule = schedule_exams(G, courses)
    exam_schedule = minimize_consecutive_days(students_data, exam_schedule, valid_days)
    exam_schedule = compress_schedule(students_data, exam_schedule, valid_days, max_exam_days)
    conflicts = find_same_day_conflicts(students_data, exam_schedule)
    if conflicts:
        print("Conflicts found")
        sys.exit(1)

    date_schedule = map_days_to_dates(exam_schedule, valid_days)
    consecutive_stats = calculate_consecutive_exam_stats(students_data, exam_schedule, valid_days)

    for days, count in sorted(consecutive_stats.items(), reverse=True):
        open(f"{STORAGE_PATH}/{args.output_dir}/description.txt", "a").write(f"{days} consecutive days: {count} students\n")
        print(f"{days} consecutive days: {count} students")
    
    pdf_output = f"{STORAGE_PATH}/{args.output_dir}/exam_schedule.pdf"
    create_pdf_schedule(exam_schedule, valid_days, pdf_output)

    if args.plot == "generate_plots":
        generate_student_schedules_plot(students_data, exam_schedule, valid_days, f"{OUTPUT_PATH}/plots")

    return date_schedule

# تشغيل البرنامج
if __name__ == "__main__":
    random.seed(time.time_ns())
    args = parse_args()
    os.makedirs(f'{STORAGE_PATH}/final_schedule', exist_ok=True)
    os.makedirs(f'{STORAGE_PATH}/{args.output_dir}', exist_ok=True)
    OUTPUT_PATH = f"{STORAGE_PATH}/{args.output_dir}"

    csv_file =  args.csv_file

    if not os.path.exists(csv_file):
        print(f"خطأ: ملف '{csv_file}' مش موجود في المجلد الحالي.")
        sys.exit(1)
    
    try:
        exam_schedule = create_exam_schedule(csv_file)
    except FileNotFoundError:
        print(f"خطأ: ملف '{csv_file}' مش موجود.")
    except PermissionError as e:
        print(f"خطأ في الصلاحيات: {e}")
    except ValueError as e:
        print(f"خطأ في الإدخال: {e}")
    except Exception as e:
        print(f"حصل خطأ: {e}")