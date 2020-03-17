<?php

use Illuminate\Database\Seeder;
use App\Subcategory;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// Games table category
        Subcategory::create([
			'title' => 'World of Warcraft',
			'category_id' => 1,
			'slug' => urlencode('World of Warcraft'),
		]);
		Subcategory::create([
			'title' => 'Subnautica',
			'category_id' => 1,
			'slug' => urlencode('Subnautica'),
		]);
		Subcategory::create([
			'title' => 'Counter-Strike: Global Offensive',
			'category_id' => 1,
			'slug' => urlencode('Counter-Strike: Global Offensive'),
		]);
		Subcategory::create([
			'title' => 'Satisfactory',
			'category_id' => 1,
			'slug' => urlencode('Satisfactory'),
		]);
		Subcategory::create([
			'title' => 'Terraria',
			'category_id' => 1,
			'slug' => urlencode('Terraria'),
		]);

		// Computers table category
		Subcategory::create([
			'title' => 'Processors',
			'category_id' => 2,
			'slug' => urlencode('Processors'),
		]);
		Subcategory::create([
			'title' => 'Graphics Cards',
			'category_id' => 2,
			'slug' => urlencode('Graphics Cards'),
		]);
		Subcategory::create([
			'title' => 'Motherboards',
			'category_id' => 2,
			'slug' => urlencode('Motherboards'),
		]);
		Subcategory::create([
			'title' => 'Memory',
			'category_id' => 2,
			'slug' => urlencode('Memory'),
		]);
		Subcategory::create([
			'title' => 'Power Supplies',
			'category_id' => 2,
			'slug' => urlencode('Power Supplies'),
		]);

		// General table category
		Subcategory::create([
			'title' => 'Donald Trump',
			'category_id' => 3,
			'slug' => urlencode('Donald Trump'),
		]);
		Subcategory::create([
			'title' => 'Sweden',
			'category_id' => 3,
			'slug' => urlencode('Sweden'),
		]);
		Subcategory::create([
			'title' => 'qhyrflhsaduifh',
			'category_id' => 3,
			'slug' => urlencode('qhyrflhsaduifh'),
		]);
		Subcategory::create([
			'title' => 'Dingo',
			'category_id' => 3,
			'slug' => urlencode('Dingo'),
		]);
		Subcategory::create([
			'title' => 'Secret',
			'category_id' => 3,
			'slug' => urlencode('Secret'),
		]);
    }
}