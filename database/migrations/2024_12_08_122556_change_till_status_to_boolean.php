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
        Schema::table('tills', function (Blueprint $table) {
            DB::statement("ALTER TABLE tills ALTER COLUMN till_status TYPE boolean USING (till_status::boolean)");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tills', function (Blueprint $table) {
            $table->string('till_status')->change();
        });
    }
};
