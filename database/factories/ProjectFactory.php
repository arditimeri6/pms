<?php

use Faker\Generator as Faker;

$factory->define(App\Project::class, function ($faker) use ($factory) {
    return [
        'user_id' => $factory->create(App\User::class)->id,
        'name' => $faker->name,
        'description' => $faker->sentence(8),
        'days' => $faker->numberBetween(1, 20),
        'company_id' => $factory->create(App\Company::class)->id,
    ];
});