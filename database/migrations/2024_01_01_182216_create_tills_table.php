<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tills', function (Blueprint $table) {
            $table->id();
            $table->string('till_name');
            $table->string('till_account_number');
            $table->unsignedBigInteger('t_type_id');
            $table->foreign('t_type_id')->references('id')->on('till_types');
            $table->boolean('till_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tills');
    }
}
