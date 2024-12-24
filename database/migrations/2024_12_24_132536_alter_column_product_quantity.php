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
        Schema::table('products', function (Blueprint $table) {
            DB::statement("ALTER TABLE products ALTER COLUMN product_quantity set default 0");
            DB::statement("ALTER TABLE products ALTER COLUMN product_quantity TYPE integer USING (product_quantity::integer)");
            DB::statement("ALTER TABLE products ALTER COLUMN product_selling_price set default 0");
            DB::statement("ALTER TABLE products ALTER COLUMN product_selling_price TYPE integer USING (product_selling_price::integer)");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
