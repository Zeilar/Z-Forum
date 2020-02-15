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
		]);
		Thread::create([
			'title' => 'Subnautica is the best underwater game ever',
			'table_subcategory_id' => 2,
			'user_id' => 1,
		]);
		Thread::create([
			'title' => 'Faking pourpol again!',
			'table_subcategory_id' => 3,
			'user_id' => 1,
		]);
		Thread::create([
			'title' => '3D Factorio?',
			'table_subcategory_id' => 4,
			'user_id' => 1,
		]);
		Thread::create([
			'title' => 'RIP Terraria 2011-2020, good night sweet prince',
			'table_subcategory_id' => 5,
			'user_id' => 1,
		]);

		// Threads by user 2 (Moderator)
		Thread::create([
			'title' => 'AMD Threadripper 3990X can run Crysis',
			'table_subcategory_id' => 6,
			'user_id' => 2,
		]);
		Thread::create([
			'title' => 'Why is GTX 1060 getting GDDR6?',
			'table_subcategory_id' => 7,
			'user_id' => 2,
		]);
		Thread::create([
			'title' => 'The best motherboard on the market?',
			'table_subcategory_id' => 8,
			'user_id' => 2,
		]);
		Thread::create([
			'title' => 'M.2 is the future',
			'table_subcategory_id' => 9,
			'user_id' => 2,
		]);
		Thread::create([
			'title' => 'Corsair CX300 blew up? House is on fire, what do?',
			'table_subcategory_id' => 10,
			'user_id' => 2,
		]);

		// Threads by user 3 (User)
		Thread::create([
			'title' => 'Trump 2020 hell ye brother',
			'table_subcategory_id' => 11,
			'user_id' => 3,
		]);
		Thread::create([
			'title' => 'Det är bara käbbel',
			'table_subcategory_id' => 12,
			'user_id' => 3,
		]);
		Thread::create([
			'title' => 'ywoepafnyawi8yvf',
			'table_subcategory_id' => 13,
			'user_id' => 3,
		]);
		Thread::create([
			'title' => 'Nice dingo pictures',
			'table_subcategory_id' => 14,
			'user_id' => 3,
		]);
		Thread::create([
			'title' => 'My plan to hack NSA, don\'t tell anyone',
			'table_subcategory_id' => 15,
			'user_id' => 3,
		]);
    }
}