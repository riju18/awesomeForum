<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Answer::class, function (Faker $faker) {
    return [
        'que_id' => $faker->numberBetween(1,10),
        'user_id' => $faker->numberBetween(1,3),
        'body' => $faker->paragraph(rand(5,10), true),
        'votes'=> $faker->numberBetween(8,15)
    ];
});
