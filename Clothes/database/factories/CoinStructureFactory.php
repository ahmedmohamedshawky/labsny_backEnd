<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CoinStructure;
use Faker\Generator as Faker;

$factory->define(CoinStructure::class, function (Faker $faker) {
    return [
        'clothes' => $faker->randomNumber(),
        'clothes_featured' => $faker->randomNumber(),
        'offers' => $faker->randomNumber(),
    ];
});
