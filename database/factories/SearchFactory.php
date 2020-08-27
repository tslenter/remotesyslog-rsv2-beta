<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Search;
use Faker\Generator as Faker;

$factory->define(Search::class, function (Faker $faker) {
    return [
        'user_id' => factory('App\User')->create(),
        'searchtext' => $faker->word,
        'startdatetime' => $faker->date . " " . $faker->time,
        'enddatetime' => $faker->date . " " . $faker->time,
    ];
});
