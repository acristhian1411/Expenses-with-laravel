<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Role::factory(10)->create();
        $types = [
            ['name'=>'Admin', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
            ['name'=>'User', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
        ];
        DB::table('roles')->insert($types);
        // $person = PersonTypes::factory()->count(10)->create();
    }
}