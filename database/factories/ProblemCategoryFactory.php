<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\ProblemCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProblemCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProblemCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'is_active' => $this->faker->boolean,
            'application_id' =>1,
            'code_priority' => $this->faker->randomElement([111, 112, 121, 122, 211, 212, 221, 222])
        ];
    }
}
