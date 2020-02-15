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
			'table_category_id' => 1
		]);
		TableSubcategory::create([
			'title' => 'Subnautica',
			'table_category_id' => 1
		]);
		TableSubcategory::create([
			'title' => 'Counter-Strike: Global Offensive',
			'table_category_id' => 1
		]);
		TableSubcategory::create([
			'title' => 'Satisfactory',
			'table_category_id' => 1
		]);
		TableSubcategory::create([
			'title' => 'Terraria',
			'table_category_id' => 1
		]);

		// Computers table category
		TableSubcategory::create([
			'title' => 'Processors',
			'table_category_id' => 2
		]);
		TableSubcategory::create([
			'title' => 'Graphics Cards',
			'table_category_id' => 2
		]);
		TableSubcategory::create([
			'title' => 'Motherboards',
			'table_category_id' => 2
		]);
		TableSubcategory::create([
			'title' => 'Memory',
			'table_category_id' => 2
		]);
		TableSubcategory::create([
			'title' => 'Power Supplies',
			'table_category_id' => 2
		]);

		// General table category
		TableSubcategory::create([
			'title' => 'Donald Trump',
			'table_category_id' => 3
		]);
		TableSubcategory::create([
			'title' => 'Sweden',
			'table_category_id' => 3
		]);
		TableSubcategory::create([
			'title' => 'qhyrflhsaduifh',
			'table_category_id' => 3
		]);
		TableSubcategory::create([
			'title' => 'Dingo',
			'table_category_id' => 3
		]);
		TableSubcategory::create([
			'title' => 'Secret',
			'table_category_id' => 3
		]);
    }
}
