<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function ($faker) use ($factory) {
    return [
        'url' => $faker->name,
        'body' => $faker->sentence(8),
    ];
});