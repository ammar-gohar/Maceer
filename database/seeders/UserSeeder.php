<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Roles\Models\Role;

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
        $adminUser->assignRole('admin');

        for ($i = 1; $i <= 50; $i++) {

            User::factory(1)->hasProfessor()->create(['username' => 'professor' . $i]);

            User::factory(1)->hasModerator()->create(['username' => 'moderator' . $i]);

        }

        $professors = User::has('professor')->get()->pluck('id')->toArray();

        for ($i = 1; $i <= 200; $i++) {

            User::factory(1)->hasStudent(['visor_id' => $professors[random_int(0, 20)]])->create(['username' => 'student' . $i]);

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
