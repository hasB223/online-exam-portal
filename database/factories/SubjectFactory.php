<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    protected $model = Subject::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word().' '.fake()->randomElement(['Basics', 'Fundamentals', 'Intro']),
            'code' => strtoupper(Str::random(6)),
        ];
    }
}
