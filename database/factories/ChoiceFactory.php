<?php

namespace Database\Factories;

use App\Models\Choice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Choice>
 */
class ChoiceFactory extends Factory
{
    protected $model = Choice::class;

    public function definition(): array
    {
        return [
            'text' => fake()->sentence(4),
            'is_correct' => false,
        ];
    }
}
