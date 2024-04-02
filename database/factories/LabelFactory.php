<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->word,
            'name' => $this->faker->word,
        ];

    }
}
