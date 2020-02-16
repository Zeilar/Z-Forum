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
		// Threads by user 1 (Superadmin)
        Thread::create([
			'title' => '8.3 sucks!',
			'table_subcategory_id' => 1,
			'user_id' => 1,
			'slug' => urlencode('8.3 sucks!'),
		]);
		Thread::create([
			'title' => 'Subnautica is the best underwater game ever',
			'table_subcategory_id' => 2,
			'user_id' => 1,
			'slug' => urlencode('Subnautica is the best underwater game ever'),
		]);
		Thread::create([
			'title' => 'Faking pourpol again!',
			'table_subcategory_id' => 3,
			'user_id' => 1,
			'slug' => urlencode('Faking pourpol again!'),
		]);
		Thread::create([
			'title' => '3D Factorio?',
			'table_subcategory_id' => 4,
			'user_id' => 1,
			'slug' => urlencode('3D Factorio?'),
		]);
		Thread::create([
			'title' => 'RIP Terraria 2011-2020, good night sweet prince',
			'table_subcategory_id' => 5,
			'user_id' => 1,
			'slug' => urlencode('RIP Terraria 2011-2020, good night sweet prince'),
		]);

		// Threads by user 2 (Moderator)
		Thread::create([
			'title' => 'AMD Threadripper 3990X can run Crysis',
			'table_subcategory_id' => 6,
			'user_id' => 2,
			'slug' => urlencode('AMD Threadripper 3990X can run Crysis'),
		]);
		Thread::create([
			'title' => 'Why is GTX 1060 getting GDDR6?',
			'table_subcategory_id' => 7,
			'user_id' => 2,
			'slug' => urlencode('Why is GTX 1060 getting GDDR6?'),
		]);
		Thread::create([
			'title' => 'The best motherboard on the market?',
			'table_subcategory_id' => 8,
			'user_id' => 2,
			'slug' => urlencode('The best motherboard on the market?'),
		]);
		Thread::create([
			'title' => 'M.2 is the future',
			'table_subcategory_id' => 9,
			'user_id' => 2,
			'slug' => urlencode('M.2 is the future'),
		]);
		Thread::create([
			'title' => 'Corsair CX300 blew up? House is on fire, what do?',
			'table_subcategory_id' => 10,
			'user_id' => 2,
			'slug' => urlencode('Corsair CX300 blew up? House is on fire, what do?'),
		]);

		// Threads by user 3 (User)
		Thread::create([
			'title' => 'Trump 2020 hell ye brother',
			'table_subcategory_id' => 11,
			'user_id' => 3,
			'slug' => urlencode('Trump 2020, hell ye brother'),
		]);
		Thread::create([
			'title' => 'Det är bara käbbel',
			'table_subcategory_id' => 12,
			'user_id' => 3,
			'slug' => urlencode('Det är bara käbbel'),
		]);
		Thread::create([
			'title' => 'ywoepafnyawi8yvf',
			'table_subcategory_id' => 13,
			'user_id' => 3,
			'slug' => urlencode('ywoepafnyawi8yvf'),
		]);
		Thread::create([
			'title' => 'Nice dingo pictures',
			'table_subcategory_id' => 14,
			'user_id' => 3,
			'slug' => urlencode('Nice dingo pictures'),
		]);
		Thread::create([
			'title' => 'My plan to hack NSA, don\'t tell anyone',
			'table_subcategory_id' => 15,
			'user_id' => 3,
			'slug' => urlencode('My plan to hack NSA, don\'t tell anyone'),
		]);
    }
}