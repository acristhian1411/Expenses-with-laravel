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
        Schema::table('sales_details', function (Blueprint $table) {
            DB::statement('ALTER TABLE sales_details ALTER COLUMN sd_amount TYPE integer USING sd_amount::integer');
            DB::statement('ALTER TABLE sales_details ALTER COLUMN sd_qty TYPE integer USING sd_qty::integer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sales_details', function (Blueprint $table) {
            //
        });
    }
};
