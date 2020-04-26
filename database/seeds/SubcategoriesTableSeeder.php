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
			'icon' => 'wow.png',
		]);
		Subcategory::create([
			'title' => 'Subnautica',
			'category_id' => 1,
			'slug' => urlencode('Subnautica'),
			'icon' => 'subnautica.png',
		]);
		Subcategory::create([
			'title' => 'Counter-Strike: Global Offensive',
			'category_id' => 1,
			'slug' => urlencode('Counter-Strike: Global Offensive'),
			'icon' => 'csgo.png',
		]);
		Subcategory::create([
			'title' => 'Satisfactory',
			'category_id' => 1,
			'slug' => urlencode('Satisfactory'),
			'icon' => 'satisfactory.jpg',
		]);
		Subcategory::create([
			'title' => 'Terraria',
			'category_id' => 1,
			'slug' => urlencode('Terraria'),
			'icon' => 'terraria.jpg',
		]);

		// Computers table category
		Subcategory::create([
			'title' => 'Processors',
			'category_id' => 2,
			'slug' => urlencode('Processors'),
			'icon' => 'cpu.png',
		]);
		Subcategory::create([
			'title' => 'Graphics Cards',
			'category_id' => 2,
			'slug' => urlencode('Graphics Cards'),
			'icon' => 'gpu.png',
		]);
		Subcategory::create([
			'title' => 'Motherboards',
			'category_id' => 2,
			'slug' => urlencode('Motherboards'),
			'icon' => 'mobo.png',
		]);
		Subcategory::create([
			'title' => 'Memory',
			'category_id' => 2,
			'slug' => urlencode('Memory'),
			'icon' => 'ram.png',
		]);
		Subcategory::create([
			'title' => 'Power Supplies',
			'category_id' => 2,
			'slug' => urlencode('Power Supplies'),
			'icon' => 'psu.png',
		]);

		// General table category
		Subcategory::create([
			'title' => 'Donald Trump',
			'category_id' => 3,
			'slug' => urlencode('Donald Trump'),
			'icon' => 'trump.jpg',
		]);
		Subcategory::create([
			'title' => 'Sweden',
			'category_id' => 3,
			'slug' => urlencode('Sweden'),
			'icon' => 'sweden.jpg',
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
			'icon' => 'dingo.jpg',
		]);
		Subcategory::create([
			'title' => 'Secret',
			'category_id' => 3,
			'slug' => urlencode('Secret'),
			'icon' => 'secret.png',
		]);
    }
}