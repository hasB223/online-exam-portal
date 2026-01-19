<?php

namespace Database\Factories;

use App\Models\Exam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Exam>
 */
class ExamFactory extends Factory
{
    protected $model = Exam::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'description' => fake()->sentence(10),
            'starts_at' => now()->addDay(),
            'ends_at' => now()->addDays(2),
            'duration_minutes' => 60,
            'is_published' => true,
        ];
    }
}
