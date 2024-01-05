<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTillDetailProofPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('till_detail_proof_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('till_detail_id');
            $table->foreign('till_detail_id')->references('id')->on('till_details');
            $table->unsignedBigInteger('proof_payment_id');
            $table->foreign('proof_payment_id')->references('id')->on('proof_payments');
            $table->string('td_pr_desc');
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
        Schema::dropIfExists('till_detail_proof_payments');
    }
}
