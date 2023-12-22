<?php

namespace Database\Seeders;

use App\Models\Steps;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $steps = [
            ['name' => 'Assistant Sociale'],
            ['name' => 'Medecin'],
            ['name' => 'Psychologue'],
        ];

        Steps::insert($steps);
    }
}
