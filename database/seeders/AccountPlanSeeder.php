<?php

namespace Database\Seeders;

use App\Models\AccountPlan;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountPlanSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        AccountPlan::firstOrCreate([
            'id'=>0,
            'account_desc'=>'Activo',
            'account_code'=>'A',
            'created_at'=> now(),
            'updated_at'=> now()
        ]);
        AccountPlan::firstOrCreate([
            'id'=>1,
            'account_desc'=>'Pasivo',
            'account_code'=>'p',
            'created_at'=> now(),
            'updated_at'=> now()
        ]);
    }
}
