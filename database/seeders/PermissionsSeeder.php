<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Permission::factory(10)->create();
        // $types = [
        //     ['name'=>'  persontypes.index', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
        //     ['name'=>'  persontypes.show', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
        //     ['name'=>'  persontypes.create', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
        //     ['name'=>'  persontypes.store', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
        //     ['name'=>'  persontypes.edit', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
        //     ['name'=>'  persontypes.update', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
        //     ['name'=>'  persontypes.destroy', 'guard_name'=>'web','created_at'=> now(), 'updated_at'=> now()],
        // ];
        // DB::table('permissions')->insert($types);
        Permission::firstOrCreate(['name'=>'persontypes.index','guard_name'=> 'web']);
        Permission::firstOrCreate(['name'=>'persontypes.show','guard_name'=> 'web']);
        Permission::firstOrCreate(['name'=>'persontypes.create','guard_name'=> 'web']);
        Permission::firstOrCreate(['name'=>'persontypes.update','guard_name'=> 'web']);
        Permission::firstOrCreate(['name'=>'persontypes.destroy','guard_name'=> 'web']);

        // $person = PersonTypes::factory()->count(10)->create();
    }
}