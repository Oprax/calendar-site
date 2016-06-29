<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Reservation::class, function (Faker\Generator $faker) {
    $formatter = 'Y-m-d';
    return [
        'arrive_at' => $faker->dateTimeBetween('now', '+ 5 days')
            ->format($formatter),

        'leave_at'  => $faker->dateTimeBetween('+ 5 days', '+ 30 days')
            ->format($formatter),

        'name' => $faker->firstName,

        'forename' => $faker->lastName,

        'email' => $faker->email,

        'nb_people' => $faker->numberBetween($min = 1, $max = 15)
    ];
});