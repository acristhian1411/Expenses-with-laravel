<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'id'=>0,
            'name'=>'Juan Perez',
            'email'=>'juan@perez.com',
            'password'=>bcrypt('123456'),
            'person_id'=>0,
            'created_at'=> now(), 
            'updated_at'=> now()]);
        $user->assignRole('Admin');
    }
}
