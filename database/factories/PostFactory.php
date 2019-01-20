<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->realText(rand(200, 999)),
        'slug' => str_slug($faker->sentence),
        'published_at' => $faker->dateTimeThisMonth,
        'featured_image' => $faker->imageUrl(),
        'claps' => $faker->numberBetween(0, 999),
        'user_id' => function() {
            return factory(\App\User::class)->create()->id;
        },
    ];
});
