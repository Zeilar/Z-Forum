<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Thread;
use App\Post;
use App\User;

$factory->define(Post::class, function(Faker $faker) {
	$threads = Thread::pluck('id')->all();
	$users = User::pluck('id')->all();
    return [
        'content' 	=> $faker->text(200),
		'thread_id' => rand($threads[0], array_key_last($threads)),
		'user_id' 	=> rand($users[0], array_key_last($users)),
    ];
});