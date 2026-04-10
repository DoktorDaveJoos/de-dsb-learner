<?php

namespace Database\Factories;

use App\Models\Module;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Question> */
class QuestionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'module_id' => Module::factory(),
            'text' => fake()->sentence().'?',
            'explanation' => fake()->paragraph(),
            'source' => fake()->sentence(),
        ];
    }
}
