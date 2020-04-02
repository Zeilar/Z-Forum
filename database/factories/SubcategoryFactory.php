<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Subcategory;
use App\Category;

$factory->define(Subcategory::class, function (Faker $faker) {
	$title = $faker->word;
    return [
        'title'		  => $title,
		'slug'		  => urlencode($title),
		'category_id' => Category::all()->random()->id,
    ];
});
