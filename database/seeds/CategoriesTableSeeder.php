<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
			'title' => 'Gaming',
			'slug' => 'Gaming',
		]);
		Category::create([
			'title' => 'Computers',
			'slug' => 'Computers',
		]);
		Category::create([
			'title' => 'General',
			'slug' => 'General',
		]);
    }
}