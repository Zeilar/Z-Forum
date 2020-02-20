<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\TableSubcategory;
use App\TableCategory;
use App\Thread;
use App\Post;
use App\User;

$factory->define(Post::class, function(Faker $faker) {
	$tableSubcategories = TableSubcategory::pluck('id')->all();
	$tableCategories = TableCategory::pluck('id')->all();
	$threads = Thread::pluck('id')->all();
	$users = User::pluck('id')->all();
    return [
        'content' 			   => $faker->text(200),
		'thread_id' 		   => rand($threads[0], array_key_last($threads)),
		'user_id' 			   => rand($users[0], array_key_last($users)),
		'table_subcategory_id' => rand($tableSubcategories[0], array_key_last($tableSubcategories)),
		'table_category_id'    => rand($tableCategories[0], array_key_last($tableCategories)),
    ];
});