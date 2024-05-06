<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Ticket::create([
            'client_email' => 'client1@example.com',
            'application_id' => 1,
            'problem_category_id' => 1,
            'object' => 'Problème de connexion',
            'content' => 'Je ne peux pas me connecter à l\'application.',
            'status' => 'Nouveau',
        ]);

        Ticket::create([
            'client_email' => 'client2@example.com',
            'application_id' => 2,
            'problem_category_id' => 2,
            'object' => 'Erreur lors de la sauvegarde',
            'content' => 'Lorsque je sauvegarde mes données, j\'obtiens une erreur inattendue.',
            'status' => 'Nouveau',
        ]);
    }
}
