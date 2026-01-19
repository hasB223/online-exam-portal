<?php

namespace Database\Factories;

use App\Models\ClassRoom;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ClassRoom>
 */
class ClassRoomFactory extends Factory
{
    protected $model = ClassRoom::class;

    public function definition(): array
    {
        return [
            'name' => 'Class '.fake()->randomLetter().fake()->randomDigitNotZero(),
            'code' => strtoupper(Str::random(6)),
        ];
    }
}
