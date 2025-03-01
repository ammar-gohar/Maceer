<?php

namespace Modules\Grades\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Grades\Models\Grade;

class GradesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Grade::create([
            'grade'          => 'A+',
            'gpa'            => 4.00,
            'max_percentage' => 100,
            'min_percentage' => 97,
        ]);

        Grade::create([
            'grade'          => 'A',
            'gpa'            => 4.00,
            'max_percentage' => 96.99,
            'min_percentage' => 93,
        ]);

        Grade::create([
            'grade'          => 'A-',
            'gpa'            => 3.70,
            'max_percentage' => 92.99,
            'min_percentage' => 89,
        ]);

        Grade::create([
            'grade'          => 'B+',
            'gpa'            => 3.30,
            'max_percentage' => 88.99,
            'min_percentage' => 84,
        ]);

        Grade::create([
            'grade'          => 'B',
            'gpa'            => 3.00,
            'max_percentage' => 83.99,
            'min_percentage' => 80,
        ]);

        Grade::create([
            'grade'          => 'B-',
            'gpa'            => 2.70,
            'max_percentage' => 79.99,
            'min_percentage' => 76,
        ]);

        Grade::create([
            'grade'          => 'C+',
            'gpa'            => 2.30,
            'max_percentage' => 75.99,
            'min_percentage' => 73,
        ]);

        Grade::create([
            'grade'          => 'C',
            'gpa'            => 2.00,
            'max_percentage' => 72.99,
            'min_percentage' => 70,
        ]);

        Grade::create([
            'grade'          => 'C-',
            'gpa'            => 1.70,
            'max_percentage' => 69.99,
            'min_percentage' => 67,
        ]);

        Grade::create([
            'grade'          => 'D+',
            'gpa'            => 1.30,
            'max_percentage' => 66.99,
            'min_percentage' => 64,
        ]);

        Grade::create([
            'grade'          => 'D',
            'gpa'            => 1.00,
            'max_percentage' => 63.99,
            'min_percentage' => 60,
        ]);

        Grade::create([
            'grade'          => 'F',
            'gpa'            => 0.00,
            'max_percentage' => 59.99,
            'min_percentage' => 0,
        ]);

        $this->call([]);
    }
}
