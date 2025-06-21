<?php

namespace Modules\Enrollments\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Courses\Models\Course;

class EnrollmentsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $students = User::has('student')->get();
        // $courses = Course::all();
        $this->call([]);
    }
}
