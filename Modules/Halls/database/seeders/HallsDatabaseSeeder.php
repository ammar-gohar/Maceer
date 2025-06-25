<?php

namespace Modules\Halls\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Halls\Models\Hall;

class HallsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Hall::factory(50)->create();

        $this->call([]);
    }
}
