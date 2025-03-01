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
        \App\Models\User::create([
            'first_name' => 'This',
            'middle_name'=> 'is',
            'last_name'  => 'Admin',
            'national_id'=> '12345678910112',
            'email'      => 'admin@example.com',
            'gender'     => 'm',
            'phone'      => '12345678910',
            'password'   => Hash::make('password')
        ]);

        $this->call([
            \Modules\Roles\Database\Seeders\RolesDatabaseSeeder::class,
            \Modules\Grades\Database\Seeders\GradesDatabaseSeeder::class,
        ]);
    }
}
