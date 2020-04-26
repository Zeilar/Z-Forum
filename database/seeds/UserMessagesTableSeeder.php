<?php

use Illuminate\Database\Seeder;
use App\UserMessage;
use App\User;

class UserMessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::all()->each(function() {
			factory(App\UserMessage::class, 25)->create();
		});
    }
}