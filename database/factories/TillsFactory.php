<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TillType;
class TillsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $tilltypes = TillType::factory()->count(3)->create();
        return [
            //
            'till_status' => $this->faker->boolean,
            'till_name' => $this->faker->name,
            'till_account_number' => $this->faker->bankAccountNumber,
            't_type_id' => $tilltypes->random()->id
        ];
    }
}
