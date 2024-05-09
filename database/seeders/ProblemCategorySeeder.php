<?php

namespace Database\Seeders;

use App\Models\ProblemCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProblemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Network',
                'description' => 'Issues related to network connectivity',
                'is_active' => false,
                'application_id' => 1, // Remplacer par l'ID de l'application liée
                'code_priority' => 212 // Remplacer par le code de priorité correspondant
            ],
            [
                'name' => 'Software',
                'description' => 'Issues related to software applications',
                'is_active' => false,
                'application_id' => 1, // Remplacer par l'ID de l'application liée
                'code_priority' => 111 // Remplacer par le code de priorité correspondant
            ],
<<<<<<< HEAD
            [
                'name' => 'Network',
                'description' => 'Issues related to network connectivity',
                'is_active' => false,
                'application_id' => 1, // Remplacer par l'ID de l'application liée
                'code_priority' => 212 // Remplacer par le code de priorité correspondant
            ],
            [
                'name' => 'Software',
                'description' => 'Issues related to software applications',
                'is_active' => false,
                'application_id' => 1, // Remplacer par l'ID de l'application liée
                'code_priority' => 111 // Remplacer par le code de priorité correspondant
            ],
            [
                'name' => 'Network',
                'description' => 'Issues related to network connectivity',
                'is_active' => false,
                'application_id' => 1, // Remplacer par l'ID de l'application liée
                'code_priority' => 212 // Remplacer par le code de priorité correspondant
            ],
            [
                'name' => 'Software',
                'description' => 'Issues related to software applications',
                'is_active' => false,
                'application_id' => 1, // Remplacer par l'ID de l'application liée
                'code_priority' => 111 // Remplacer par le code de priorité correspondant
            ],
=======
>>>>>>> 7300c5caa7056006324d5c9a26a6f8206b730999
            // Ajoutez d'autres catégories au besoin
        ];

        // Insérer les données de test dans la base de données
        foreach ($categories as $category) {
            ProblemCategory::create($category);
        }
    }
}
