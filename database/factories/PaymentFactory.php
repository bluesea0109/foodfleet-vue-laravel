<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(\App\Models\Foodfleet\Square\Payment::class, function (Faker $faker) {
    return [
        "square_id" => $faker->randomNumber(5),
        "amount_money" => $faker->numberBetween(7, 100),
        "tip_money" => $faker->numberBetween(7, 100),
        "total_money" => $faker->numberBetween(7, 100),
        "app_fee_money" => $faker->numberBetween(7, 100),
        "refunded_money" => $faker->numberBetween(7, 100),
        "square_created_at" => $faker->dateTime('now')
    ];
});
