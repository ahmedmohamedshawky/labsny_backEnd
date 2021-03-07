<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClothesSizeCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clothes_size_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('clothes_id')->unsigned();
            $table->foreign('clothes_id')->references('id')->on('clothes')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('size_id')->unsigned();
            $table->foreign('size_id')->references('id')->on('size_categories')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('clothes_size_categories');
    }
}
