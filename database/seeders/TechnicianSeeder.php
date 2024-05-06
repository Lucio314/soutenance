<?php

namespace Database\Seeders;

use App\Models\Technician;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $technicians = [
            [
                'user_id' => 1,
                'company_id' => 1,
                'problem_category_id' => 1,
            ],
            [
                'user_id' => 2,
                'company_id' => 1,
                'problem_category_id' => 2,
            ],
            // Ajoutez d'autres techniciens au besoin
        ];

        // Insérer les données de test dans la base de données
        foreach ($technicians as $technician) {
            Technician::create($technician);
        }
    }
}
