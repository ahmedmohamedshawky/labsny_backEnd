<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClothesColourCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clothes_colour_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('clothes_id')->unsigned();
            $table->foreign('clothes_id')->references('id')->on('clothes')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('colour_id')->unsigned();
            $table->foreign('colour_id')->references('id')->on('colour_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('clothes_colour_categories');
    }
}
