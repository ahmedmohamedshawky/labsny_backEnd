<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ClothesSizeCategory;
use Faker\Generator as Faker;

$factory->define(ClothesSizeCategory::class, function (Faker $faker) {
    return [
        'clothes_id' => $faker->numberBetween(1,10),
        'size_id' => $faker->numberBetween(1,10),
    ];
});
