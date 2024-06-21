<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Exemple de création de commentaires
        Comment::create([
            'ticket_id' => 24,
            'body' => 'Premier commentaire du client',
            'is_technician' => false,
            'client_email' => 'client@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Comment::create([
            'ticket_id' => 24,
            'body' => 'Réponse du technicien',
            'is_technician' => true,
            'client_email' => 'client@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Ajoutez d'autres commentaires si nécessaire
    }
}
