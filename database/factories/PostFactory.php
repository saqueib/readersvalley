<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => function() use($faker) {
            // build a story with images
            $para = $imgs = [];
            foreach (range(3, rand(5, 9)) as $p) {
                $para[] = '<p>'.$faker->realText(rand(200, 999)).'</p>';
            }

            // add some images aswell
            foreach (range(0, rand(0, 2)) as $img) {
                $imgs[] = '<div class="story-img-full"><img src="'.$faker->imageUrl(820).'" alt=""></div>';
            }

            $paraImage = array_merge($para, $imgs);
            shuffle($paraImage);

            return implode("\n", $paraImage);
        },
        'slug' => str_slug($faker->sentence),
        'published_at' => $faker->dateTimeThisMonth,
        'featured_image' => $faker->imageUrl(400, 400),
        'claps' => $faker->numberBetween(0, 999),
        'user_id' => function() {
            return factory(\App\User::class)->create()->id;
        },
        'updated_at' => $faker->dateTimeThisMonth
    ];
});
