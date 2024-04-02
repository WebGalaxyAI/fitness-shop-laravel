<?php

namespace Database\Factories;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class AttributeValueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'attribute_id' => Attribute::factory(),
            'value' => $this->faker->word,
        ];

    }
}
