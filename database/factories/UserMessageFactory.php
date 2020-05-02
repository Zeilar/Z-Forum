<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\UserMessage;
use \Carbon\Carbon;
use App\User;

$factory->define(UserMessage::class, function (Faker $faker) {
    $date = Carbon::now()->subSeconds(rand(0, DAY_IN_SECONDS * 3));
    $users = User::inRandomOrder()->limit(2)->get();
    return [
		'title'		   => $faker->sentence(rand(4, 10), true),
		'content'      => $faker->text(rand(200, 800)),
        'author_id'	   => $users[0]->id,
		'recipient_id' => $users[1]->id,
        'created_at'   => $date,
        'updated_at'   => $date,
    ];
});