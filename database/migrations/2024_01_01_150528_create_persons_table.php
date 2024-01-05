<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->string('person_fname');
            $table->string('person_lastname');
            $table->string('person_corpname');
            $table->string('person_idnumber');
            $table->string('person_ruc');
            $table->date('person_birtdate');
            $table->text('person_photo');
            $table->text('person_address');
            $table->unsignedBigInteger('p_type_id');
            $table->foreign('p_type_id')->references('id')->on('person_types');
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
        Schema::dropIfExists('persons');
    }
}
