<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->word,
            'name' => $this->faker->word,
            'frontend_type' => $this->faker->randomElement(['checkbox', 'radio', 'text', 'textarea']),
            'is_required' => $this->faker->boolean(),
            'is_filterable' => $this->faker->boolean(),
        ];

    }
}
