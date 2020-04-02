<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Subcategory;
use App\Thread;
use App\User;
use App\Post;

$factory->define(Thread::class, function (Faker $faker) {
	$title = $faker->realText(rand(10, 100), rand(1, 3));
    $subcategory = Subcategory::all()->random();
	$user = User::all()->random();
	
	return [
		'title'			 => $title,
		'slug'			 => urlencode($title),
		'views'			 => rand(500, 1500),
		'user_id'		 => $user->id,
		'subcategory_id' => $subcategory->id,
		'category_id'	 => $subcategory->category->id,
	];
});