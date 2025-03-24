<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_item', function (Blueprint $table) {
            $table->id();
            //$table->string('content');//中間テーブル化したら消すカラム
            $table->foreignId('item_id')->constrained()->cascadeOnDelete();//中間テーブル化時に追加するカラム
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();//中間テーブル化時に追加するカラム
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
        Schema::dropIfExists('category_item');
    }
}