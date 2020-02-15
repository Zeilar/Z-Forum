<?php

use Illuminate\Database\Seeder;
use App\TableCategory;

class TableCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TableCategory::create([
			'title' => 'Gaming',
		]);
		TableCategory::create([
			'title' => 'Computers',
		]);
		TableCategory::create([
			'title' => 'General',
		]);
    }
}