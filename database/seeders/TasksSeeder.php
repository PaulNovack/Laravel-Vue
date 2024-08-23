<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TasksSeeder extends Seeder
{
    public function run(): void
    {
        foreach (range(1, 10) as $projectId) {
            foreach (range(1, 10) as $index) {
                DB::table('tasks')->insert([
                    'project_id' => $projectId,
                    'name' => fake()->sentence(6),
                    'priority' => $index,
                ]);
            }
        }
    }
}
