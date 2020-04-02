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
		$this->call(MaintenanceModeTableSeeder::class);
		$this->call(DefaultSettingsTableSeeder::class);

		// Keep these in this order
		$this->call(CategoriesTableSeeder::class);
		$this->call(SubcategoriesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
		$this->call(ThreadsTableSeeder::class);
		$this->call(PostsTableSeeder::class);
    }
}