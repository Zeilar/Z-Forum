<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Subcategory;
use \Carbon\Carbon;
use App\Thread;
use App\User;
use App\Post;

$factory->define(Thread::class, function (Faker $faker) {
    $date = Carbon::now()->subSeconds(rand(0, DAY_IN_SECONDS * 3));
    $subcategory = Subcategory::inRandomOrder()->first();
	$title = $faker->realText(rand(10, 100), rand(1, 3));
	$user = User::inRandomOrder()->first();
	
	return [
		'title'			 => $title,
		'slug'			 => urlencode($title),
		'views'			 => rand(500, 1500),
		'user_id'		 => $user->id,
		'subcategory_id' => $subcategory->id,
		'category_id'	 => $subcategory->category->id,
        'created_at'     => $date,
        'updated_at'     => $date,
	];
});