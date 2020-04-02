<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Subcategory;
use App\Thread;
use App\User;
use App\Post;

$factory->define(Thread::class, function (Faker $faker) {
	$latest_thread = DB::table('threads')->latest('id')->first();
	$title = $faker->realText(rand(10, 100), rand(1, 3));
    $subcategory = Subcategory::all()->random();
	$user = User::all()->random();

    Post::create([
        'content' 		 => $faker->realText(rand(50, 400), rand(1, 4)),
		'user_id' 		 => $user->id,
		'thread_id' 	 => $latest_thread->id + 1,
		'subcategory_id' => $subcategory->id,
		'category_id' 	 => $subcategory->category->id,
    ]);
	
	return [
		'title'			 => $title,
		'slug'			 => urlencode($title),
		'excerpt'		 => substr($title, 0, 40),
		'user_id'		 => $user->id,
		'subcategory_id' => $subcategory->id,
		'category_id'	 => $subcategory->category->id,
	];
});