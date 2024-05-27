<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Ticket;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(3)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'techmorino',
        //     'email' => 'techmorino@yahoo.fr',
        //     'role'=>'technician'
        // ]);
        // $this->call([CompanySeeder::class,
        //     ApplicationSeeder::class,
        //     ProblemPrioritySeeder::class, ProblemCategorySeeder::class, TechnicianSeeder::class, TicketSeeder::class,
        // ]);
        Ticket::factory()->count(10)->create();
    }
}
