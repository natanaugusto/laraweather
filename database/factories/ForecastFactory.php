<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Forecast>
 */
class ForecastFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_id' => City::factory(),
            'description' => $this->faker->text,
            'min' => $this->faker->randomFloat(nbMaxDecimals: 2, min: -2, max: 50),
            'max' => $this->faker->randomFloat(nbMaxDecimals: 2, min: -2, max: 50),
            'feels' => $this->faker->randomFloat(nbMaxDecimals: 2, min: -2, max: 50),
        ];
    }
}
