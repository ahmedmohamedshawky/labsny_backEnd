<?php
/**
 * File name: ShopFactory.php
 * Last modified: 2020.04.30 at 08:21:08
 * Author: SmarterVision - https://codecanyon.net/user/smartervision
 * Copyright (c) 2020
 *
 */

 /** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Shop;
use Faker\Generator as Faker;

$factory->define(Shop::class, function (Faker $faker) {
    return [
        'name' => $faker->randomElement(['Town Team', 'Zinc', 'Zara']) . " " . $faker->company,
        'description' => $faker->text,
        'address' => $faker->address,
        'latitude' => $faker->randomElement(['29.9019354', '30.4382243', '31.0261234']),
        'longitude' => $faker->randomElement(['31.2864599', '31.1992407', '31.3545134']),
        'phone' => $faker->phoneNumber,
        'mobile' => $faker->phoneNumber,
        'information' => $faker->sentences(3, true),
        'admin_commission' => $faker->randomFloat(2, 10, 50),
        'delivery_fee' => $faker->randomFloat(2, 1, 10),
        'delivery_range' => $faker->randomFloat(2, 5, 100),
        'default_tax' => $faker->randomFloat(2, 5, 30), //added
        'closed' => $faker->boolean,
        'active' => 1,
        'available_for_delivery' => $faker->boolean,
    ];
});
