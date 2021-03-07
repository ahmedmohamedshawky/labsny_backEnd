<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Models\Clothes::class, function (Faker $faker) {
    $clothes = [
        'T-Shirt',
        'Polo',
        'Shirt',
        'Trouser'
    ];
    $price = $faker->randomFloat(2,10,50);
    $discountPrice = $price - $faker->randomFloat(2,1,10);
    return [
        'name' => $faker->randomElement($clothes),
        'price' => $price,
        'discount_price' => $faker->randomElement([$discountPrice,0]),
        'description' => $faker->text,
        'weight' => $faker->randomFloat(2,0.1,500),
        'package_items_count' => $faker->numberBetween(1,6),
        'unit' => $faker->randomElement(['L','g','Kg','ml']),
        'featured' => $faker->boolean,
        'deliverable' =>  $faker->boolean,
        'shop_id' => $faker->numberBetween(1,10),
    ];
});
