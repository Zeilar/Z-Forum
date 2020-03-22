<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
		$this->call(DefaultSettingsTableSeeder::class);
		$this->call(SubcategoriesTableSeeder::class);
		$this->call(CategoriesTableSeeder::class);
		$this->call(ThreadsTableSeeder::class);
		$this->call(PostsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}