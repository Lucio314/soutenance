<?php

namespace Database\Seeders;

use App\Models\ProblemPriority;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProblemPrioritySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProblemPriority::create([
            'code_priority' => 111,
            'name_priority' => 'Priorité plus faible',
        ]);

        ProblemPriority::create([
            'code_priority' => 112,
            'name_priority' => 'Priorité faible',
        ]);

        ProblemPriority::create([
            'code_priority' => 121,
            'name_priority' => 'Priorité moyenne',
        ]);
        ProblemPriority::create([
            'code_priority' => 122,
            'name_priority' => 'Priorité plus que moyenne',
        ]);

        ProblemPriority::create([
            'code_priority' => 211,
            'name_priority' => 'Priorité élevée',
        ]);

        ProblemPriority::create([
            'code_priority' => 212,
            'name_priority' => 'Priorité plus que élevée',
        ]);
        ProblemPriority::create([
            'code_priority' => 221,
            'name_priority' => 'Priorité haute',
        ]);

        ProblemPriority::create([
            'code_priority' => 222,
            'name_priority' => 'Priorité plus que haute',
        ]);
    }
}
