<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\TableSubcategory;
use App\TableCategory;

$factory->define(TableSubcategory::class, function(Faker $faker) {
    $tableCategories = TableCategory::pluck('id')->all(); 
	$title = $faker->word();
    return [
		'title'				=> $title,
		'slug' 				=> urlencode($title),
		'table_category_id' => rand($tableCategories[0], array_key_last($tableCategories)),
    ];
});