<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClothesCategoryClothesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clothes_category_clothes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('clothes_id')->unsigned();
            $table->foreign('clothes_id')->references('id')->on('clothes')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('clothes_category_id')->unsigned();
            $table->foreign('clothes_category_id')->references('id')->on('clothes_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('clothes_category_clothes');
    }
}
