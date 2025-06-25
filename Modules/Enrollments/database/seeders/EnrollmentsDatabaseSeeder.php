<?php

namespace Modules\Enrollments\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Courses\Models\Course;
use Modules\Courses\Models\Schedule;
use Modules\Enrollments\Models\Enrollment;
use Modules\Halls\Models\Hall;
use Modules\Semesters\Models\Semester;

class EnrollmentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = User::with(['enrollments'])->has('student')->take(50)->get();
        $semesters = Semester::factory()->count(5)->create();
        $currentSemester = Semester::where('is_current', 1)->first();
        // $currentSemester = Semester::create([
        //     'name' => 'Fall 2023',
        //     'start_date' => now(),
        //     'end_date' => now()->addMonths(4),
        //     'is_current' => 1,
        // ]);
        $professors = User::has('professor')->get();
        $halls = Hall::where('status', 'available')->get();
        $courses = Course::all();
        Schedule::factory()->count(50)->create([
            'semester_id' => $currentSemester->id,
            'professor_id' => $professors->random()->id,
            'hall_id' => $halls->random()->id,
            'course_id' => $courses->random()->id,
        ]);

        $schedules = Schedule::where('semester_id', $currentSemester->id)->get();

        foreach ($students as $student) {
            $courses = Course::whereNotIn('id', $student->enrollments->pluck('course_id')->toArray())->get();

            for ($i = 0; $i < 5; $i++) {
                if ($courses->isEmpty()) {
                    break;
                }

                $course = $courses->random();
                $schedule = $schedules->where('course_id', $course->id)->first();
                Enrollment::factory()->create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'semester_id' => $currentSemester->id,
                    'schedule_id' => $schedule ? $schedule->id : null,
                ]);

            }

        }

        $this->call([]);
    }
}
