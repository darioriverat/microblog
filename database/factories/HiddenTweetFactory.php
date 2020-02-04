<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\HiddenTweets;
use App\User;
use Faker\Generator as Faker;

$factory->define(HiddenTweets::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()['id'];
        },
        'tweet_id' => $faker->randomNumber(7),
    ];
});
