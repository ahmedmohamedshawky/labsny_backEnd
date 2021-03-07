<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ClothesCategory;
use Faker\Generator as Faker;

$factory->define(ClothesCategory::class, function (Faker $faker) {
    return [
        'name'=>$faker->randomElement(['men', 'woman', 'child']),
        'description'=>$faker->sentences(5,true),
    ];
});
