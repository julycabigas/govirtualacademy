<?php

use Faker\Generator as Faker;

$factory->define(App\Video::class, function (Faker $faker) {
    return [
       'title' => $faker->sentence(),
       'description' => $faker->sentence(),
       'file' => str_random(10)

    ];
});
