<?php

use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    $visibilityArray = [
        'event_location',
        'square_created_at',
        'total_money',
        'total_tax_money',
        'total_discount_money'
    ];
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'data_visibility' => $faker->randomElements($visibilityArray, 4)
    ];
});
