<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('till_details', function (Blueprint $table) {
            $table->unsignedBigInteger(column: 'ref_id')->nullable()->after('till_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('till_details', function (Blueprint $table) {
            $table->dropColumn('ref_id');
        });
    }
};
