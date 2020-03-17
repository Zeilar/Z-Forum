<?php

use Illuminate\Database\Seeder;
use App\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		Post::create([
			'content' => 'This expansion is the worst',
			'thread_id' => 1,
			'user_id' => 1,
			'subcategory_id' => 1,
			'category_id' => 1,
		]);
		Post::create([
			'content' => 'Agreed, I loved how scary the reaper leviathans were!',
			'thread_id' => 2,
			'user_id' => 2,
			'subcategory_id' => 2,
			'category_id' => 1,
		]);
		Post::create([
			'content' => 'Don\'t bully pourpol :(',
			'thread_id' => 3,
			'user_id' => 3,
			'subcategory_id' => 3,
			'category_id' => 1,
		]);
		Post::create([
			'content' => 'Yeah it\'s pretty much 3D Factorio',
			'thread_id' => 4,
			'user_id' => 1,
			'subcategory_id' => 4,
			'category_id' => 1,
		]);
		Post::create([
			'content' => 'It\'s been a long day without you my friend...',
			'thread_id' => 5,
			'user_id' => 2,
			'subcategory_id' => 5,
			'category_id' => 1,
		]);
		Post::create([
			'content' => 'But can it run Crysis 2???',
			'thread_id' => 6,
			'user_id' => 3,
			'subcategory_id' => 6,
			'category_id' => 2,
		]);
		Post::create([
			'content' => 'Because NvidiaTM',
			'thread_id' => 7,
			'user_id' => 3,
			'subcategory_id' => 7,
			'category_id' => 2,
		]);
		Post::create([
			'content' => 'I think mine is the most pice worthy; MSI X470 GAMING PLUS',
			'thread_id' => 8,
			'user_id' => 2,
			'subcategory_id' => 8,
			'category_id' => 2,
		]);
		Post::create([
			'content' => 'The future is now old man',
			'thread_id' => 9,
			'user_id' => 3,
			'subcategory_id' => 9,
			'category_id' => 2,
		]);
		Post::create([
			'content' => 'Did you try turning it off and on again?',
			'thread_id' => 10,
			'user_id' => 1,
			'subcategory_id' => 10,
			'category_id' => 2,
		]);
		Post::create([
			'content' => 'God Emperor Trump brother',
			'thread_id' => 11,
			'user_id' => 3,
			'subcategory_id' => 11,
			'category_id' => 3,
		]);
		Post::create([
			'content' => 'Min nya ringsignal',
			'thread_id' => 12,
			'user_id' => 3,
			'subcategory_id' => 12,
			'category_id' => 3,
		]);
		Post::create([
			'content' => 'Yes.',
			'thread_id' => 13,
			'user_id' => 2,
			'subcategory_id' => 13,
			'category_id' => 3,
		]);
		Post::create([
			'content' => 'Still looks better than your mom',
			'thread_id' => 14,
			'user_id' => 2,
			'subcategory_id' => 14,
			'category_id' => 3,
		]);
		Post::create([
			'content' => 'Meet me at the nearest police station and I\'ll help you hack them!',
			'thread_id' => 15,
			'user_id' => 3,
			'subcategory_id' => 15,
			'category_id' => 3,
		]);
    }
}