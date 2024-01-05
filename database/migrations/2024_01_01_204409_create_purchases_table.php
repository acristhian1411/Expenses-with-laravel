<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('person_id');
            $table->foreign('person_id')->references('id')->on('persons');    
            $table->unsignedBigInteger('purchase_id');
            $table->foreign('purchase_id')->references('id')->on('products');        
            $table->string('purchase_desc');
            $table->string('purchase_number');
            $table->date('purchase_date');
            $table->boolean('purchase_status');
            $table->string('purchase_type');
            $table->timestamps();
        });
    }

    /**php artisan make:migration remove_purchase_id_from_purchases_table --table=purchases

     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchases');
    }
}
