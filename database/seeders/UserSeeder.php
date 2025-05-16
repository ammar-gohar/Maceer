<?php

namespace Database\Seeders;

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
                'gender'     => 'm',
                'phone'      => '12345678911',
                'password'   => Hash::make('password')
            ]),

            \App\Models\User::create([
                'first_name' => 'This',
                'middle_name'=> 'is',
                'last_name'  => 'professor',
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
    }
}
