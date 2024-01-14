<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AccountPlanFactory extends Factory
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
            'account_desc' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            'account_code' => $this->faker->word,
        ];
    }
}
