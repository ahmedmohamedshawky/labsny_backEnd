<?php
/**
 * File name: 2019_08_29_213837_create_clothes_table.php
 * Last modified: 2020.05.03 at 10:56:45
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClothesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clothes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 127);
            $table->double('price', 8, 2)->default(0);
            $table->double('discount_price', 8, 2)->nullable()->default(0);
            $table->text('description')->nullable();
            $table->text('ingredients')->nullable();
            $table->double('package_items_count', 9, 2)->nullable()->default(0); // added
            $table->double('weight', 9, 2)->nullable()->default(0);
            $table->string('unit', 127)->nullable(); // added
            $table->boolean('featured')->nullable()->default(0);
            $table->boolean('deliverable')->nullable()->default(1); // added
            $table->boolean('coin')->nullable()->default(0); // 0 -> coin or 1 -> commission
            $table->integer('amount')->default(0);
            $table->integer('shop_id')->unsigned();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::drop('clothes');
    }
}
