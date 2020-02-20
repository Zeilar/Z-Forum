<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\TableSubcategory;
use App\Thread;

$factory->define(Thread::class, function(Faker $faker) {
	$tableSubcategories = TableSubcategory::pluck('id')->all(); 
	$title = $faker->sentence(rand(5, 10));
    return [
		'title' 			   => $title,
		'user_id' 			   => rand(1, 3),
		'slug' 				   => urlencode($title),
		'table_subcategory_id' => rand($tableSubcategories[0], array_key_last($tableSubcategories)),
    ];
});