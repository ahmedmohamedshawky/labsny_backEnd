<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Offer;
use Faker\Generator as Faker;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['50%', '30%', '10%']) . " " . $faker->company,
        'description' => $faker->text,
        'active' => 1,
        'shop_id' => $faker->numberBetween(1,10),
        'manager_id' => 3
    ];
});
