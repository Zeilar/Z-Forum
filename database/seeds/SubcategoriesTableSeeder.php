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
			'icon' => route('index') . '/storage/icons/wow.jpg',
		]);
		Subcategory::create([
			'title' => 'Subnautica',
			'category_id' => 1,
			'slug' => urlencode('Subnautica'),
			'icon' => route('index') . '/storage/icons/',
		]);
		Subcategory::create([
			'title' => 'Counter-Strike: Global Offensive',
			'category_id' => 1,
			'slug' => urlencode('Counter-Strike: Global Offensive'),
			'icon' => route('index') . '/storage/icons/csgo.png',
		]);
		Subcategory::create([
			'title' => 'Satisfactory',
			'category_id' => 1,
			'slug' => urlencode('Satisfactory'),
			'icon' => route('index') . '/storage/icons/satisfactory.jpg',
		]);
		Subcategory::create([
			'title' => 'Terraria',
			'category_id' => 1,
			'slug' => urlencode('Terraria'),
			'icon' => route('index') . '/storage/icons/terraria.jpg',
		]);

		// Computers table category
		Subcategory::create([
			'title' => 'Processors',
			'category_id' => 2,
			'slug' => urlencode('Processors'),
			'icon' => route('index') . '/storage/icons/cpu.png',
		]);
		Subcategory::create([
			'title' => 'Graphics Cards',
			'category_id' => 2,
			'slug' => urlencode('Graphics Cards'),
			'icon' => route('index') . '/storage/icons/gpu.png',
		]);
		Subcategory::create([
			'title' => 'Motherboards',
			'category_id' => 2,
			'slug' => urlencode('Motherboards'),
			'icon' => route('index') . '/storage/icons/mobo.png',
		]);
		Subcategory::create([
			'title' => 'Memory',
			'category_id' => 2,
			'slug' => urlencode('Memory'),
			'icon' => route('index') . '/storage/icons/ram.png',
		]);
		Subcategory::create([
			'title' => 'Power Supplies',
			'category_id' => 2,
			'slug' => urlencode('Power Supplies'),
			'icon' => route('index') . '/storage/icons/psu.png',
		]);

		// General table category
		Subcategory::create([
			'title' => 'Donald Trump',
			'category_id' => 3,
			'slug' => urlencode('Donald Trump'),
			'icon' => route('index') . '/storage/icons/trump.jpg',
		]);
		Subcategory::create([
			'title' => 'Sweden',
			'category_id' => 3,
			'slug' => urlencode('Sweden'),
			'icon' => route('index') . '/storage/icons/sweden.jpg',
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
			'icon' => route('index') . '/storage/icons/dingo.jpg',
		]);
		Subcategory::create([
			'title' => 'Secret',
			'category_id' => 3,
			'slug' => urlencode('Secret'),
			'icon' => route('index') . '/storage/icons/secret.png',
		]);
    }
}