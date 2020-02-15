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
		$this->call(TableCategoriesTableSeeder::class);
		$this->call(TableSubcategoriesTableSeeder::class);
		$this->call(ThreadsTableSeeder::Class);
		$this->call(PostsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}