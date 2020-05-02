<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\UserLikedPosts;
use \Carbon\Carbon;
use App\User;
use App\Post;

$factory->define(UserLikedPosts::class, function (Faker $faker) {
    $date = Carbon::now()->subSeconds(rand(0, DAY_IN_SECONDS * 3));
    return [
        'user_id' => User::inRandomOrder()->first()->id,
		'post_id' => Post::inRandomOrder()->first()->id,
    ];
});