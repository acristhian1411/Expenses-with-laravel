<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class AddDeletedAtToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            //
            $tables = DB::select("SELECT table_name FROM information_schema.columns WHERE table_schema = 'public' AND column_name = 'created_at'");

            foreach ($tables as $table) {
                $tableName = $table->table_name;
    
                if (!Schema::hasColumn($tableName, 'deleted_at')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->timestamp('deleted_at')->nullable()->default(null);
                    });
                }
            }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tables = DB::select("SELECT table_name FROM information_schema.columns WHERE table_schema = 'public' AND column_name = 'created_at'");

        foreach ($tables as $table) {
            $tableName = $table->table_name;

            Schema::table($tableName, function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
}
