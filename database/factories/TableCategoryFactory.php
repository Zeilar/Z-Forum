<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\TableCategory;

$factory->define(TableCategory::class, function(Faker $faker) {
	$title = $faker->word();
    return [
		'title' => $title,
		'slug'	=> urlencode($title),
    ];
});