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
            $table->integer('exhibitor_id');
            $table->string('item_image_path');
            $table->foreignId('item_category_id')->constrained()->cascadeOnDelete();//中間テーブル設定後削除
            $table->foreignId('condition_id')->constrained()->cascadeOnDelete();
            $table->string('item_name');
            $table->string('item_brand');
            $table->text('item_detail');
            $table->integer('item_price');
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