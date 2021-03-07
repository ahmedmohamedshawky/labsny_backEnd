<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\SizeCategory;
use Faker\Generator as Faker;

$factory->define(SizeCategory::class, function (Faker $faker) {
    return [
        'name'=>$faker->randomElement(['S', 'M', 'L', 'XL', 'XXL', 'XXXL']),
        'description'=>$faker->sentences(5,true),
    ];
});
