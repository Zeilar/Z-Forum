<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\UserMessage;
use App\User;

$factory->define(UserMessage::class, function (Faker $faker) {
    $users = User::inRandomOrder()->limit(2)->get();
    return [
        'author_id'	   => $users[0]->id,
		'recipient_id' => $users[1]->id,
		'content'      => $faker->text(),
    ];
});