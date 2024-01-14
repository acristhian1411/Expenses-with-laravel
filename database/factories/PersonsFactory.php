<?php

namespace Database\Factories;
use App\Models\PersonTypes;
use App\Models\Countries;
use App\Models\Cities;
use Illuminate\Database\Eloquent\Factories\Factory;
class PersonsFactory extends Factory
{
    /**
     * Define the models default state.
     *
     * @return array
     */
    public function definition()
    {
        $cities = Cities::factory()->create();
        $countries = Countries::factory()->create();
        $personTypes = PersonTypes::factory()->create();
        return [
            //
            'person_fname' => $this->faker->firstName(),
            'person_lastname' => $this->faker->lastName(),
            'person_corpname' => $this->faker->company(),
            'person_idnumber' => strval($this->faker->randomNumber(6)),
            'person_ruc' => strval($this->faker->randomNumber(6)),
            'person_birtdate' => $this->faker->date(),
            'person_photo' => $this->faker->imageUrl(),
            'person_address' => $this->faker->address(),
            'p_type_id' => $personTypes->id,
            'country_id' => $countries->id,
            'city_id' => $cities->id,
        ];
    }
}
