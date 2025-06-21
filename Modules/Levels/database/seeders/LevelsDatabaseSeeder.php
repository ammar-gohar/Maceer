<?php

namespace Modules\Levels\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Levels\Models\Level;

class LevelsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Level::create([
            'name' => 'freshman',
            'number' => 1,
            'min_credits' => 0,
        ]);
        Level::create([
            'name' => 'sophomore',
            'number' => 2,
            'min_credits' => 32
        ]);
        Level::create([
            'name' => 'junior',
            'number' => 3,
            'min_credits' => 64
        ]);
        Level::create([
            'name' => 'senior-1',
            'number' => 4,
            'min_credits' => 96
        ]);
        Level::create([
            'name' => 'senior-2',
            'number' => 5,
            'min_credits' => 128
        ]);

        $this->call([]);
    }
}
