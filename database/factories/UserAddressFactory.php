<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'country_iso' => $this->faker->countryCode,
            'city' => $this->faker->city,
            'street' => $this->faker->streetAddress,
            'house_number' => $this->faker->buildingNumber,
            'zip_code' => $this->faker->postcode,
        ];
    }
}
