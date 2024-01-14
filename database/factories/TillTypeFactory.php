<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TillTypeFactory extends Factory
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
            'till_type_desc' => $this->faker->word,
        ];
    }
}
