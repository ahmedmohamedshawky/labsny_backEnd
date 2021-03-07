<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ClothesColourCategory;
use Faker\Generator as Faker;

$factory->define(ClothesColourCategory::class, function (Faker $faker) {
    return [
        'clothes_id' => $faker->numberBetween(1,10),
        'colour_id' => $faker->numberBetween(1,10),
    ];
});
