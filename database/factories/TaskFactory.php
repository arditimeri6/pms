<?php

use Faker\Generator as Faker;

$factory->define(App\Task::class, function ($faker) use ($factory) {
    return [
        'user_id' => $factory->create(App\User::class)->id,
        'project_id' => $factory->create(App\Project::class)->id,
        'name' => $faker->name,
        'days' => $faker->numberBetween(1, 20),
    ];
});