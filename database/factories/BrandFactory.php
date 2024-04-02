<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'logo' => $this->faker->imageUrl(200, 200, 'brands', true, $this->faker->word, true),
        ];
    }
}
