<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\ProblemCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_email' => $this->faker->unique()->safeEmail,
            'problem_category_id' => ProblemCategory::factory(),
            'application_id' =>1,
            'object' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),

        ];
    }
}
