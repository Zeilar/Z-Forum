<?php

use Illuminate\Database\Seeder;
use App\Thread;

class ThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Thread::create([
			'title' => '8.3 sucks!',
			'slug' => urlencode('8.3 sucks!'),
			'user_id' => 1,
			'subcategory_id' => 1,
			'category_id' => 1,
		]);
		Thread::create([
			'title' => 'Subnautica is the best underwater game ever',
			'slug' => urlencode('Subnautica is the best underwater game ever'),
			'user_id' => 2,
			'subcategory_id' => 2,
			'category_id' => 1,
		]);
		Thread::create([
			'title' => 'Faking pourpol again!',
			'slug' => urlencode('Faking pourpol again!'),
			'user_id' => 3,
			'subcategory_id' => 3,
			'category_id' => 1,
		]);
		Thread::create([
			'title' => '3D Factorio?',
			'slug' => urlencode('3D Factorio?'),
			'user_id' => 1,
			'subcategory_id' => 4,
			'category_id' => 1,
		]);
		Thread::create([
			'title' => 'RIP Terraria 2011-2020, good night sweet prince',
			'slug' => urlencode('RIP Terraria 2011-2020, good night sweet prince'),
			'user_id' => 2,
			'subcategory_id' => 5,
			'category_id' => 1,
		]);
		Thread::create([
			'title' => 'AMD Threadripper 3990X can run Crysis',
			'slug' => urlencode('AMD Threadripper 3990X can run Crysis'),
			'user_id' => 3,
			'subcategory_id' => 6,
			'category_id' => 2,
		]);
		Thread::create([
			'title' => 'Why is GTX 1060 getting GDDR6?',
			'slug' => urlencode('Why is GTX 1060 getting GDDR6?'),
			'user_id' => 1,
			'subcategory_id' => 7,
			'category_id' => 2,
		]);
		Thread::create([
			'title' => 'The best motherboard on the market?',
			'slug' => urlencode('The best motherboard on the market?'),
			'user_id' => 2,
			'subcategory_id' => 8,
			'category_id' => 2,
		]);
		Thread::create([
			'title' => 'M.2 is the future',
			'slug' => urlencode('M.2 is the future'),
			'user_id' => 3,
			'subcategory_id' => 9,
			'category_id' => 2,
		]);
		Thread::create([
			'title' => 'Corsair CX300 blew up? House is on fire, what do?',
			'slug' => urlencode('Corsair CX300 blew up? House is on fire, what do?'),
			'user_id' => 1,
			'subcategory_id' => 10,
			'category_id' => 2,
		]);
		Thread::create([
			'title' => 'Trump 2020 hell ye brother',
			'slug' => urlencode('Trump 2020, hell ye brother'),
			'user_id' => 2,
			'subcategory_id' => 11,
			'category_id' => 3,
		]);
		Thread::create([
			'title' => 'Det är bara käbbel',
			'slug' => urlencode('Det är bara käbbel'),
			'user_id' => 3,
			'subcategory_id' => 12,
			'category_id' => 3,
		]);
		Thread::create([
			'title' => 'ywoepafnyawi8yvf',
			'slug' => urlencode('ywoepafnyawi8yvf'),
			'user_id' => 1,
			'subcategory_id' => 13,
			'category_id' => 3,
		]);
		Thread::create([
			'title' => 'Nice dingo pictures',
			'slug' => urlencode('Nice dingo pictures'),
			'user_id' => 2,
			'subcategory_id' => 14,
			'category_id' => 3,
		]);
		Thread::create([
			'title' => 'My plan to hack NSA, don\'t tell anyone',
			'slug' => urlencode('My plan to hack NSA, don\'t tell anyone'),
			'user_id' => 3,
			'subcategory_id' => 15,
			'category_id' => 3,
		]);
    }
}