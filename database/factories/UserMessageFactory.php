<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\UserMessage;
use App\User;

$factory->define(UserMessage::class, function (Faker $faker) {
    $users = User::inRandomOrder()->limit(2)->get();
    return [
		'title'		   => $faker->sentence(rand(4, 10), true),
		'content'      => $faker->text(rand(200, 800)),
        'author_id'	   => $users[0]->id,
		'recipient_id' => $users[1]->id,
    ];
});