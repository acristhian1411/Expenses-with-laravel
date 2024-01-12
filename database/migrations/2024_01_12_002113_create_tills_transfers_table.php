<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTillsTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tills_transfers', function (Blueprint $table) {
            $table->id();
            // add references to tills as origin_id
            $table->foreignId('origin_id')->constrained('tills');
            $table->foreignId('destiny_id')->constrained('tills');
            $table->float('t_transfer_amount');
            $table->date('t_transfer_date');
            $table->string('t_transfer_obs');
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
        Schema::dropIfExists('tills_transfers');
    }
}
