<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PersonTypesFactory extends Factory
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
            'p_type_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
