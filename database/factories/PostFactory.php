<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Subcategory;
use App\Thread;
use App\Post;
use App\User;

$factory->define(Post::class, function (Faker $faker) {
	$subcategory = Subcategory::all()->random();
    return [
        'content' 		 => $faker->realText(rand(50, 400), rand(1, 4)),
		'user_id' 		 => User::all()->random()->id,
		'thread_id' 	 => Thread::all()->random()->id,
		'subcategory_id' => $subcategory->id,
		'category_id' 	 => $subcategory->category->id,
    ];
});