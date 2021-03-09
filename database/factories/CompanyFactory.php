<?php

use Faker\Generator as Faker;

$factory->define(App\Company::class, function ($faker) use ($factory) {
    return [
        'user_id' => $factory->create(App\User::class)->id,
        'name' => $faker->company,
        'description' => $faker->sentence(8),
    ];
});
