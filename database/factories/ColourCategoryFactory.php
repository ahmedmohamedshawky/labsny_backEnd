<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ColourCategory;
use Faker\Generator as Faker;

$factory->define(ColourCategory::class, function (Faker $faker) {
    return [
        'name'=>$faker->randomElement(['red', 'blue', 'black', 'orange', 'white']),
        'description'=>$faker->sentences(5,true),
    ];
});
