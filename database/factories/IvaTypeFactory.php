<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class IvaTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            "iva_type_desc" => $this->faker->sentence(),
            "iva_type_percent" => $this->faker->randomFloat(2, 0, 100)
        ];
    }
}
