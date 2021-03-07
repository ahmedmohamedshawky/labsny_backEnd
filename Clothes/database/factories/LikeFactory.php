<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Like;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'clothes_id' => $faker->numberBetween(1,10),
        'manager_id' => 3,
        'client_id' => 4,
    ];
});
