<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            // \Modules\Roles\Database\Seeders\RolesDatabaseSeeder::class,
            // \Modules\Grades\Database\Seeders\GradesDatabaseSeeder::class,
            // \Modules\Levels\Database\Seeders\LevelsDatabaseSeeder::class,
            // \Modules\Courses\Database\Seeders\CoursesDatabaseSeeder::class,
            // UserSeeder::class,
            // \Modules\Halls\Database\Seeders\HallsDatabaseSeeder::class,
            \Modules\Enrollments\Database\Seeders\EnrollmentsDatabaseSeeder::class,
        ]);
    }
}
