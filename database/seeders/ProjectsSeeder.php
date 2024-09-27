<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 10) as $index) {
            DB::table('projects')->insert([
                'name' => fake()->sentence(2),
            ]);
        }
    }
}
