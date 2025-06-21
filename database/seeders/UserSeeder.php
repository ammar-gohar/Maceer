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

        $users = [
            \App\Models\User::create([
                'first_name' => 'Supero',
                'middle_name'=> 'Sir',
                'last_name'  => 'Aadmin',
                'username'   => 'superadmin',
                'national_id'=> '12345678910110',
                'email'      => 'superadmin@maceer.com',
                'gender'     => 'm',
                'phone'      => '12345678910',
                'password'   => Hash::make('password')
            ]),

            \App\Models\User::create([
                'first_name' => 'Admino',
                'middle_name'=> 'Sir',
                'last_name'  => 'Aadmin',
                'national_id'=> '12345678910111',
                'email'      => 'admin@maceer.com',
                'username'   => 'admin',
                'gender'     => 'm',
                'phone'      => '12345678911',
                'password'   => Hash::make('password')
            ]),

            \App\Models\User::create([
                'first_name' => 'This',
                'middle_name'=> 'is',
                'last_name'  => 'professor',
                'username'   => 'professor',
                'national_id'=> '12345678910112',
                'email'      => 'professor@maceer.com',
                'gender'     => 'm',
                'phone'      => '12345678912',
                'password'   => Hash::make('password')
            ]),

            \App\Models\User::create([
                'first_name' => 'This',
                'middle_name'=> 'is',
                'last_name'  => 'student',
                'username'   => 'student',
                'national_id'=> '12345678910113',
                'email'      => 'student@maceer.com',
                'gender'     => 'm',
                'phone'      => '12345678913',
                'password'   => Hash::make('password')
            ]),

            \App\Models\User::create([
                'first_name' => 'This',
                'middle_name'=> 'is',
                'last_name'  => 'staff',
                'username'   => 'staff',
                'national_id'=> '12345678910114',
                'email'      => 'staff@maceer.com',
                'gender'     => 'm',
                'phone'      => '12345678914',
                'password'   => Hash::make('password')
            ]),
        ];
        $roles = Role::orderBy('created_at')->get();

        for($i = 0; $i < count($users); $i ++) {
            $users[$i]->assignRole($roles[$i]->name);
        };

        for ($i = 1; $i <= 50; $i++) {

            User::factory(1)->hasProfessor()->create(['username' => 'professor' . $i]);

            User::factory(1)->hasModerator()->create(['username' => 'moderator' . $i]);

        }

        $professors = User::has('professor')->get()->pluck('id')->toArray();

        for ($i = 1; $i <= 200; $i++) {

            User::factory(1)->hasStudent(['guide_id' => $professors[random_int(0, 20)]])->create(['username' => 'student' . $i]);

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
