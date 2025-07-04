<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Roles\Models\Role;
use Modules\Students\Models\Student;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding admin
        $adminUser =  \App\Models\User::create([
                'first_name' => 'admin',
                'middle_name'=> '',
                'last_name'  => '',
                'username'   => 'superadmin',
                'national_id'=> '12345678910110',
                'email'      => 'superadmin@maceer.com',
                'gender'     => 'm',
                'phone'      => '12345678910',
                'password'   => Hash::make('password')
        ]);
        $adminUser->assignRole('Super Admin');

        for ($i = 1; $i <= 50; $i++) {

            User::factory(1)->hasProfessor()->create(['username' => 'professor' . $i]);

            User::factory(1)->hasModerator()->create(['username' => 'moderator' . $i]);

        }

        $professors = User::has('professor')->get()->pluck('id')->toArray();
        $prefix = now()->format('y');
        $acno = (integer) $prefix . str_pad(Student::whereBetween('academic_number', [$prefix . 0000, (integer) $prefix . '9999'])->count(), 4, '0', STR_PAD_LEFT);
        for ($i = 1; $i <= 200; $i++) {

            User::factory(1)->hasStudent(['guide_id' => $professors[random_int(0, 20)], 'academic_number' => $acno++])->create(['username' => 'student' . $i]);

        }

        $students = User::has('student')->get();
        $professors = User::has('professor')->get();
        $moderators = User::has('moderator')->get();
        for ($i = 0; $i < count($students) ; $i++) {
            $students[$i]->assignRole('student');
            if($i < 50)
            {
                $professors[$i]->assignRole('professor');
                $moderators[$i]->assignRole('staff');
            }
        }

    }
}
