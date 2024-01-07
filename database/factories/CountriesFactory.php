<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CountriesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'country_name' => $this->faker->country,
            'country_code' => $this->faker->countryCode,
        ];
    }
}
