<?php

namespace Database\Factories;
use App\Models\States;
use Illuminate\Database\Eloquent\Factories\Factory;

class CitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $states = States::factory()->count(3)->create();
        return [
            //
            'city_name' => $this->faker->city,
            'city_code' => $this->faker->postcode,
            'state_id' => $states->random()->id
        ];
    }
}
