<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ShopCategoryShop;
use Faker\Generator as Faker;

$factory->define(ShopCategoryShop::class, function (Faker $faker) {
    return [
        'shop_id' => $faker->numberBetween(1,10),
        'shop_category_id' => $faker->numberBetween(1,10),
    ];
});
