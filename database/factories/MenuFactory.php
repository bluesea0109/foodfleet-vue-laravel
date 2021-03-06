<?php

use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\Foodfleet\Menu::class, function (Faker $faker) {
    return [
        'item' => $faker->word,
        'category' => $faker->word,
        "street_price" => $faker->numberBetween(700, 10000)
    ];
});
