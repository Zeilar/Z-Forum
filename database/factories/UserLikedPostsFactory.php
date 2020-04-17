<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\UserLikedPosts;
use App\User;
use App\Post;

$factory->define(UserLikedPosts::class, function (Faker $faker) {
	$users = User::all()->random();
    return [
        'user_id' => $users,
		'post_id' => 1,
    ];
});