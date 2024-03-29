<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Countries;

class StatesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $countries = Countries::factory()->count(3)->create();
        return [
            //
            'state_name'=>$this->faker->unique()->state(),
            'country_id'=>$countries->random()->id
        ];
    }
}