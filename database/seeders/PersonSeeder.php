<?php

namespace Database\Seeders;

use App\Models\Persons;
use App\Models\Cities;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $city = Cities::where('city_name', '=', 'Encarnación')->first();
        Persons::firstOrCreate([
            'id'=>0,
            'person_fname'=>'Juan',
            'person_lastname'=>'Perez',
            'person_corpname'=>'Perez',
            'person_idnumber'=>'123456789',
            'person_ruc'=>'123456789',
            'person_birtdate'=>'1990-01-01',
            'person_photo'=>'',
            'person_address'=>'',
            'p_type_id'=>0,
            'country_id'=>0,
            'city_id'=>$city->id,
            'created_at'=> now(),
            'updated_at'=> now()
        ]);
        
    }
}
