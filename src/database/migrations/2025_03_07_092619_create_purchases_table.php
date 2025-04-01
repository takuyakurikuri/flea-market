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
            $table->id();
            $table->integer('user_id');
            //$table->integer('payment_method_id');
            $table->integer('payment_method');
            //$table->integer('address_id');
            // $table->string('purchase_zipcode');
            // $table->string('purchase_address');
            // $table->string('purchase_building')->nullable();
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();//改修作業
            $table->foreignId('address_id')->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('purchases');
    }
}