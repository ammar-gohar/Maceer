import sys
import os
import networkx as nx
import pandas as pd
from collections import defaultdict
from reportlab.lib.pagesizes import letter
from reportlab.platypus import SimpleDocTemplate, Table, TableStyle, Paragraph, Spacer
from reportlab.lib import colors
from reportlab.lib.styles import getSampleStyleSheet
from reportlab.pdfbase import pdfmetrics
from reportlab.pdfbase.ttfonts import TTFont
import arabic_reshaper
from bidi.algorithm import get_display
from datetime import datetime, timedelta

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
    print("Enter the start date of the exams (YYYY-MM-DD):")
    start_date_str = input().strip()
    start_date = parse_date(start_date_str)
    
    print("Enter the end date of the exams (YYYY-MM-DD):")
    end_date_str = input().strip()
    end_date = parse_date(end_date_str)
    
    if end_date < start_date:
        raise ValueError("The end date must be after the start date.")
    
    print("Enter the number of required exam days:")
    try:
        max_exam_days = int(input().strip())
        if max_exam_days <= 0:
            raise ValueError
    except ValueError:
        raise ValueError("The number of days must be a positive integer.")
    
    # جمع تواريخ الإجازات
    holidays = []
    print("Enter the holidays (YYYY-MM-DD), one per line, or press Enter to finish:")
    while True:
        holiday_str = input().strip()
        if not holiday_str:
            break
        try:
            holiday_date = parse_date(holiday_str)
            if start_date <= holiday_date <= end_date:
                holidays.append(holiday_date)
            else:
                print("The date is outside the exam period, ignored...")
        except ValueError:
            print("Incorrect date format, try again or press Enter to finish.")
    
    return start_date, end_date, max_exam_days, holidays

# دالة لإنشاء قائمة بالأيام الصالحة للامتحانات
def get_valid_exam_days(start_date, end_date, holidays):
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

# ضغط الجدول ليكون في عدد الأيام المحدد
def compress_schedule(students_data, exam_schedule, valid_days, max_days):
    current_max_day = max(exam_schedule.values())
    if current_max_day <= max_days:
        return exam_schedule
    
    schedule_items = sorted([(day, course) for course, day in exam_schedule.items()])
    
    compressed_schedule = {}
    current_day = 1
    courses_on_day = defaultdict(list)
    
    for _, course in schedule_items:
        while True:
            conflict = False
            for other_course in courses_on_day[current_day]:
                if (course, other_course) in G.edges or (other_course, course) in G.edges:
                    conflict = True
                    break
            
            if not conflict and current_day <= max_days:
                compressed_schedule[course] = current_day
                courses_on_day[current_day].append(course)
                break
            else:
                current_day += 1
                if current_day > max_days:
                    print(f"Warning: It's not possible to schedule all exams in {max_days} days while maintaining the constraints.")
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

# الدالة الرئيسية
def create_exam_schedule(csv_file):
    global G
    # الحصول على تواريخ الامتحانات وأيام الإجازة
    start_date, end_date, max_exam_days, holidays = get_exam_period()
    valid_days = get_valid_exam_days(start_date, end_date, holidays)
    
    if len(valid_days) < max_exam_days:
        print(f"Error: The number of valid days ({len(valid_days)}) is less than the required number of exam days ({max_exam_days}).")
        sys.exit(1)
    
    students_data = read_student_courses(csv_file)
    G, courses = build_conflict_graph(students_data)
    exam_schedule = schedule_exams(G, courses)
    exam_schedule = minimize_consecutive_days(students_data, exam_schedule, valid_days)
    exam_schedule = compress_schedule(students_data, exam_schedule, valid_days, max_exam_days)
    date_schedule = map_days_to_dates(exam_schedule, valid_days)
    
    script_dir = os.path.dirname(os.path.abspath(__file__))
    pdf_output = os.path.join(script_dir, "exam_schedule.pdf")
    create_pdf_schedule(exam_schedule, valid_days, pdf_output)
    
    total_days = max(exam_schedule.values()) if exam_schedule else 0
    print(f"Total number of exam days: {total_days}")
    
    return date_schedule

# تشغيل البرنامج
if __name__ == "__main__":
    if len(sys.argv) != 2:
        print("الاستخدام: python script.py <csv_file>")
        print("مثال: python .\\exam_scheduler.py Test.csv")
        sys.exit(1)
    
    csv_file = sys.argv[1]
    
    if not os.path.exists(csv_file):
        print(f"خطأ: ملف '{csv_file}' مش موجود في المجلد الحالي.")
        sys.exit(1)
    
    try:
        exam_schedule = create_exam_schedule(csv_file)
        print("عينة من جدول الامتحانات:")
        for course, date in list(exam_schedule.items())[:5]:
            print(f"المادة {course} في تاريخ {date}")
    except FileNotFoundError:
        print(f"خطأ: ملف '{csv_file}' مش موجود.")
    except PermissionError as e:
        print(f"خطأ في الصلاحيات: {e}")
    except ValueError as e:
        print(f"خطأ في الإدخال: {e}")
    except Exception as e:
        print(f"حصل خطأ: {e}")