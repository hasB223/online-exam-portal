<?php

namespace Database\Factories;

use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Question>
 */
class QuestionFactory extends Factory
{
    protected $model = Question::class;

    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['mcq', 'text']),
            'question_text' => fake()->sentence(8),
            'points' => fake()->numberBetween(1, 3),
        ];
    }
}
