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
        // Commentaires pour le même ticket (ticket_id = 28)
        Comment::create([
            'ticket_id' => 28,
            'body' => 'Bonjour, j\'ai un problème avec mon logiciel.',
            'is_technician' => false,
            'client_email' => 'client@example.com',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Comment::create([
            'ticket_id' => 28,
            'body' => 'Bonjour! Comment puis-je vous aider aujourd\'hui?',
            'is_technician' => true,
            'client_email' => 'client@example.com',
            'created_at' => now()->addMinutes(5),
            'updated_at' => now()->addMinutes(5),
        ]);

        Comment::create([
            'ticket_id' => 28,
            'body' => 'Le problème n\'est toujours pas réglé.',
            'is_technician' => false,
            'client_email' => 'client@example.com',
            'created_at' => now()->addMinutes(10),
            'updated_at' => now()->addMinutes(10),
        ]);

        Comment::create([
            'ticket_id' => 28,
            'body' => 'Je suis désolé pour le dérangement, je vais vérifier à nouveau.',
            'is_technician' => true,
            'client_email' => 'client@example.com',
            'created_at' => now()->addMinutes(15),
            'updated_at' => now()->addMinutes(15),
        ]);

        Comment::create([
            'ticket_id' => 28,
            'body' => 'Merci beaucoup pour votre aide!',
            'is_technician' => false,
            'client_email' => 'client@example.com',
            'created_at' => now()->addMinutes(20),
            'updated_at' => now()->addMinutes(20),
        ]);
    }
}
