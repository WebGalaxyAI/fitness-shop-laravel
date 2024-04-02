<?php

namespace Database\Factories;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SliderFactory extends Factory
{
    protected $model = Slider::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'text' => $this->faker->text(),
            'image' => $this->faker->word(),
            'type' => 'main',
            'button' => $this->faker->words(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
