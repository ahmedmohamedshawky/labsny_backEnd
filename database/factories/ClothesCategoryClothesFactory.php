<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ClothesCategoryClothes;
use Faker\Generator as Faker;

$factory->define(ClothesCategoryClothes::class, function (Faker $faker) {
    return [
        'clothes_id' => $faker->numberBetween(1,10),
        'clothes_category_id' => $faker->numberBetween(1,10),
    ];
});
