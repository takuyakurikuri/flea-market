<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            //$table->integer('exhibitor_id');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            //$table->string('item_image_path');
            $table->string('image_path');
            $table->integer('condition');
            //$table->string('item_name');
            $table->string('name');
            // $table->string('item_brand')->nullable();
            $table->string('brand')->nullable();
            //$table->text('item_detail');
            $table->text('detail');
            //$table->integer('item_price');
            $table->integer('price');
            //$table->string('purchase_id')->nullable();//後程削除予定
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
        Schema::dropIfExists('items');
    }
}