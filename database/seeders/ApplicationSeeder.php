<?php

namespace Database\Seeders;

use App\Models\Application;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $applications = [
            [
                'app_name' => 'App 1',
                'description' => 'Description of App 1',
                'is_active' => true,
                'unique_code' => 'APP001',
                'app_email' => 'app1@example.com',
                'app_phone' => '123-456-7890',
                'company_id' => 1,
            ],
            [
                'app_name' => 'App 2',
                'description' => 'Description of App 2',
                'is_active' => true,
                'unique_code' => 'APP002',
                'app_email' => 'app2@example.com',
                'app_phone' => '987-654-3210',
                'company_id' => 2,
            ],
            // Ajoutez d'autres applications au besoin
        ];

        // Insérer les données de test dans la base de données
        foreach ($applications as $application) {
            Application::create($application);
        }
    }
}
