<?php

use Illuminate\Database\Seeder;
use App\TableSubcategory;

class TableSubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Games table category
        TableSubcategory::create([
			'title' => 'World of Warcraft',
			'table_category_id' => 1,
			'slug' => urlencode('World of Warcraft'),
		]);
		TableSubcategory::create([
			'title' => 'Subnautica',
			'table_category_id' => 1,
			'slug' => urlencode('Subnautica'),
		]);
		TableSubcategory::create([
			'title' => 'Counter-Strike: Global Offensive',
			'table_category_id' => 1,
			'slug' => urlencode('Counter-Strike: Global Offensive'),
		]);
		TableSubcategory::create([
			'title' => 'Satisfactory',
			'table_category_id' => 1,
			'slug' => urlencode('Satisfactory'),
		]);
		TableSubcategory::create([
			'title' => 'Terraria',
			'table_category_id' => 1,
			'slug' => urlencode('Terraria'),
		]);

		// Computers table category
		TableSubcategory::create([
			'title' => 'Processors',
			'table_category_id' => 2,
			'slug' => urlencode('Processors'),
		]);
		TableSubcategory::create([
			'title' => 'Graphics Cards',
			'table_category_id' => 2,
			'slug' => urlencode('Graphics Cards'),
		]);
		TableSubcategory::create([
			'title' => 'Motherboards',
			'table_category_id' => 2,
			'slug' => urlencode('Motherboards'),
		]);
		TableSubcategory::create([
			'title' => 'Memory',
			'table_category_id' => 2,
			'slug' => urlencode('Memory'),
		]);
		TableSubcategory::create([
			'title' => 'Power Supplies',
			'table_category_id' => 2,
			'slug' => urlencode('Power Supplies'),
		]);

		// General table category
		TableSubcategory::create([
			'title' => 'Donald Trump',
			'table_category_id' => 3,
			'slug' => urlencode('Donald Trump'),
		]);
		TableSubcategory::create([
			'title' => 'Sweden',
			'table_category_id' => 3,
			'slug' => urlencode('Sweden'),
		]);
		TableSubcategory::create([
			'title' => 'qhyrflhsaduifh',
			'table_category_id' => 3,
			'slug' => urlencode('qhyrflhsaduifh'),
		]);
		TableSubcategory::create([
			'title' => 'Dingo',
			'table_category_id' => 3,
			'slug' => urlencode('Dingo'),
		]);
		TableSubcategory::create([
			'title' => 'Secret',
			'table_category_id' => 3,
			'slug' => urlencode('Secret'),
		]);
    }
}