<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTillDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('till_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('till_id')->constrained('tills')->onDelete('cascade');
            $table->foreignId('person_id')->constrained('persons')->onDelete('cascade');
            $table->string('td_desc');
            $table->string('td_amount');
            $table->date('td_date');
            $table->boolean('td_type');
            $table->foreignId('account_p_id')->constrained('account_plans')->onDelete('cascade');
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
        Schema::dropIfExists('till_details');
    }
}
