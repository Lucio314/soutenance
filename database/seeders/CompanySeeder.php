<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companies = [
            [
                'code' => 'COMP001',
                'cpn_name' => 'Company A',
                'cpn_email' => 'companya@example.com',
                'company_phone' => '123-456-7890',
                'cpn_address' => '123 Main Street',
                'is_active' => true,
                'user_id' => 1,
            ],
            [
                'code' => 'COMP002',
                'cpn_name' => 'Company B',
                'cpn_email' => 'companyb@example.com',
                'company_phone' => '987-654-3210',
                'cpn_address' => '456 Elm Street',
                'is_active' => true,
                'user_id' => 2,
            ],
            // Ajoutez d'autres entreprises au besoin
        ];

        // Insérer les données de test dans la base de données
        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}
