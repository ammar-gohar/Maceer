<?php

namespace Modules\Enrollments\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\Schedule;
use Modules\Enrollments\Models\Enrollment;
use Modules\Grades\Models\Grade;
use Modules\Halls\Models\Hall;
use Modules\Levels\Models\Level;
use Modules\Reports\Models\Receipt;
use Modules\Semesters\Models\Semester;

class EnrollmentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::with(['enrollments'])->has('student')->get();
        $semesters = Semester::factory()->count(5)->create();
        // $semesters = Semester::where('is_current', 0)->get();
        // $currentSemester = Semester::where('is_current', 1)->first();
        $currentSemester = Semester::create([
            'name' => 'First 2025',
            'start_date' => now(),
            'end_date' => now()->addMonths(4),
            'requests_start_date' => now()->addWeeks(2),
            'enrollments_start_date' => now()->addWeeks(3),
            'enrollments_end_date' => now()->addWeeks(5),
            'is_current' => 1,
        ]);
        $professors = User::has('professor')->get();
        $halls = Hall::where('status', 'available')->get();
        $courses = Course::all();

        for ($i=1; $i < 20; $i++) {
            Schedule::factory()->create([
                'semester_id' => $currentSemester->id,
                'professor_id' => $professors->random()->id,
                'hall_id' => $halls->random()->id,
                'course_id' => $courses->random()->id,
            ]);
        }

        $schedules = Schedule::where('semester_id', $currentSemester->id)->get();

        foreach ($students as $student) {
            $currentTotalCreds = 0;
            for ($i = 0; $i < 5; $i++) {
                $courses = Course::whereNotIn('id', $student->enrollments->pluck('course_id')->toArray())->whereIn('id', $schedules->pluck('course_id')->toArray())->get();

                if ($courses->isEmpty()) {
                    break;
                }

                $course = $courses->random();
                $currentTotalCreds += $course->credits;
                $schedule = $schedules->where('course_id', $course->id)->first();
                Enrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'semester_id' => $currentSemester->id,
                    'schedule_id' => $schedule ? $schedule->id : null,
                ]);

            }

            Receipt::create([
                'student_id' => $student->id,
                'semester_id' => $currentSemester->id,
                'number_credits' => $currentTotalCreds,
                'credit_cost' => 400,
                'total_cost' => $currentTotalCreds * 400,
            ]);

            $courses = Course::whereNotIn('id', $student->enrollments->pluck('course_id')->toArray())->get();

            $loop = random_int(1, 20);

            $totalQulaity = 0;
            $totalCredits = 0;
            $ueec = 0;
            $feec = 0;
            $peec = 0;
            $cec = 0;

            for ($i=0; $i < $loop; $i++) {
                if ($courses->isEmpty()) {
                    break;
                }

                $course = $courses->random();
                $midterm = random_int(10, 20);
                $work = random_int(20, 30);
                $final = random_int(0, 50);
                $total = $midterm + $final + $work;
                $percentage = number_format($total / $course->full_mark * 100, 2);
                $grade = Grade::where('max_percentage', '>=', $percentage)
                                ->where('min_percentage', '<=', $percentage)
                                ->first();
                $finalGpa = $grade->gpa;
                $quality = $grade->gpa * $course->credits;

                $totalQulaity += $quality;
                $totalCredits += $course->credits;

                if($course->type == 'core')
                {
                    $cec += $course->credits;
                } else {
                    match ($course->requirement) {
                        'university' => $ueec += $course->credits,
                        'faculty' => $feec += $course->credits,
                        'specialization' => $peec += $course->credits,
                    };
                }

                Enrollment::factory()->create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'semester_id' => $semesters->random()->id,
                    'midterm_exam' => $midterm,
                    'work_mark'    => $work,
                    'final_exam'   => $final,
                    'total_mark'            => $total,
                    'total_mark_percentage' => $percentage,
                    'grade_id'              => $grade->id,
                    'final_gpa'             => $finalGpa,
                    'quality_points'        => $quality,
                ]);
            }

            if($totalCredits > 0){
                $fGpa = $totalQulaity / $totalCredits;

                $level = Level::where('min_credits', '<=', $totalCredits)
                                ->orderBy('number', 'desc')
                                ->first();

                $max = 18;
                switch ($fGpa) {
                    case $fGpa >= 3.0:
                        $max = 21;
                        break;
                    case $fGpa >= 2.0:
                        $max = 18;
                        break;
                    default:
                        $max = 15;
                        break;
                };
            } else {
                dd($totalCredits);
                $fGpa = 0.00;
                $level = Level::where('number', 1)
                                ->first();
                $max = 18;
            }


            $student->student->update([
                'gpa' => number_format($fGpa, 2),
                'quality_points' => number_format($totalQulaity, 2),
                'level_id' => $level->id,
                'unversity_elected_earned_credits' => $ueec,
                'faculty_elected_earned_credits' => $feec,
                'program_elected_earned_credits' => $peec,
                'core_earned_credits' => $cec,
                'total_earned_credits' => $totalCredits,
                'maximum_credits_to_enroll' => $max,
            ]);

        }

        $this->call([]);
    }
}
