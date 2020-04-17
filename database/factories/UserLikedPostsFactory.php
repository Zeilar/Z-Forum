<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\UserLikedPosts;
use App\User;
use App\Post;

$factory->define(UserLikedPosts::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
		'post_id' => Post::all()->random()->id,
    ];
});