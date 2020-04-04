<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Subcategory;
use \Carbon\Carbon;
use App\Thread;
use App\Post;
use App\User;

$factory->define(Post::class, function (Faker $faker) {
	$thread = Thread::all()->random();
	$date = Carbon::now()->subSeconds(rand(0, DAY_IN_SECONDS * 3));
	
    return [
        'content' 		 => $faker->realText(rand(50, 400), rand(1, 4)),
		'user_id' 		 => User::all()->random()->id,
		'thread_id' 	 => $thread->id,
		'subcategory_id' => $thread->subcategory->id,
		'category_id' 	 => $thread->subcategory->category->id,
		'created_at'	 => $date,
		'updated_at'	 => $date,
    ];
});