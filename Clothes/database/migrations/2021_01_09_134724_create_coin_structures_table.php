<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_structures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->float('clothes')->nullable()->unsigned();
            $table->float('clothes_featured')->nullable()->unsigned();
            $table->float('offers')->nullable()->unsigned();
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
        Schema::dropIfExists('coin_structures');
    }
}
