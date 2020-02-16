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
			'username' => 'Superadmin',
			'email' => 'superadmin@zforum.nu',
			'password' => Hash::make('123'),
			'role' => 'Superadmin',
			'remember_token' => null,
		]);
		User::create([
			'username' => 'Moderator',
			'email' => 'moderator@zforum.nu',
			'password' => Hash::make('123'),
			'role' => 'Moderator',
			'remember_token' => null,
		]);
		User::create([
			'username' => 'Pleb',
			'email' => 'pleb@zforum.nu',
			'password' => Hash::make('123'),
			'role' => 'User',
			'remember_token' => null,
		]);
    }
}