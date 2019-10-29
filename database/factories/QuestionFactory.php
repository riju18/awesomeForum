<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Question::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5,10),
        'body' => $faker->paragraph(5,10),
        'views' => $faker->numberBetween(5,10),
        'votes_count' => $faker->numberBetween(5,10),
        'answer_count' => $faker->numberBetween(5,10),
        'user_id' => $faker->numberBetween(1, 4),
    ];
});
