<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('purchases_details', function (Blueprint $table) {
            DB::statement('ALTER TABLE purchases_details ALTER COLUMN pd_amount TYPE integer using pd_amount::integer;');
            DB::statement('ALTER TABLE purchases_details ALTER COLUMN pd_qty TYPE integer using pd_qty::integer;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases_details', function (Blueprint $table) {
            //
        });
    }
};
