<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = $this->faker->name();

        return [
            'brand_id' => Brand::factory(),
            'sku' => $this->faker->unique()->regexify('[A-Z]{3}_\d{3}'),
            'name' => $name,
            'slug' => (string) Str::of($name)->slug(),
            'description' => $this->faker->text(),
            'quantity' => $this->faker->randomDigit(),
            'price' => $this->faker->randomFloat(2),
            'sale_price' => $this->faker->randomFloat(2),
            'status' => $this->faker->randomElement([0,1]),
        ];
    }
}
