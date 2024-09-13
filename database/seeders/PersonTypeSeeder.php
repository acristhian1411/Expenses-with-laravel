<?php

namespace Database\Seeders;

use App\Models\PersonTypes;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PersonTypeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // PersonTypes::factory(10)->create();
        $types = [
            ['p_type_desc'=>'Proveedor', 'created_at'=> now(), 'updated_at'=> now()],
            ['p_type_desc'=>'Cliente', 'created_at'=> now(), 'updated_at'=> now()],
            ['p_type_desc'=>'Funcionario', 'created_at'=> now(), 'updated_at'=> now()],
        ];
        DB::table('person_types')->insert($types);
    }
}
