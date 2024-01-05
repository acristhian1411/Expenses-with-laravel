<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCountryToPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id');             
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedBigInteger('city_id');             
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('country_id');
            $table->dropForeign('persons_country_id_foreign');
            $table->dropForeign('persons_city_id_foreign');
            $table->dropColumn('city_id');
        });
    }
}
