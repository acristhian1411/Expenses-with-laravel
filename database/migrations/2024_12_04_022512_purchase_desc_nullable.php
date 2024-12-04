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
        
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('purchase_desc')->nullable()->change();
            $table->boolean('purchase_status')->nullable()->change();
            $table->string('purchase_type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('purchase_desc')->nullable()->change();
            $table->string('purchase_type')->nullable()->change();
            $table->string('purchase_type')->nullable()->change();
        });        
    }
};
