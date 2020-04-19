<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
			'username' => 'Philip',
			'email' => 'philip@zforum.nu',
			'password' => Hash::make('123'),
			'role' => 'superadmin',
			'remember_token' => null,
		]);
		User::create([
			'username' => 'Mod',
			'email' => 'mod@zforum.nu',
			'password' => Hash::make('123'),
			'role' => 'moderator',
			'remember_token' => null,
		]);
		User::create([
			'username' => 'Pleb',
			'email' => 'pleb@zforum.nu',
			'password' => Hash::make('123'),
			'role' => 'member',
			'remember_token' => null,
		]);

		factory(App\User::class, 25)->create();
    }
}