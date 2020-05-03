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
		$title = '8.3 sucks!';
        Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 1,
			'subcategory_id' => 1,
			'category_id' => 1,
		]);
		$title = 'Subnautica is the best underwater game ever';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 2,
			'subcategory_id' => 2,
			'category_id' => 1,
		]);
		$title = 'Faking pourpol again!';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 3,
			'subcategory_id' => 3,
			'category_id' => 1,
		]);
		$title = '3D Factorio?';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 1,
			'subcategory_id' => 4,
			'category_id' => 1,
		]);
		$title = 'RIP Terraria 2011-2020, good night sweet prince';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 2,
			'subcategory_id' => 5,
			'category_id' => 1,
		]);
		$title = 'AMD Threadripper 3990X can run Crysis';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 3,
			'subcategory_id' => 6,
			'category_id' => 2,
		]);
		$title = 'Why is GTX 1060 getting GDDR6?';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 1,
			'subcategory_id' => 7,
			'category_id' => 2,
		]);
		$title = 'The best motherboard on the market?';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 2,
			'subcategory_id' => 8,
			'category_id' => 2,
		]);
		$title = 'M.2 is the future';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 3,
			'subcategory_id' => 9,
			'category_id' => 2,
		]);
		$title = 'Corsair CX300 blew up? House is on fire, what do?';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 1,
			'subcategory_id' => 10,
			'category_id' => 2,
		]);
		$title = 'Trump 2020 hell ye brother';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 2,
			'subcategory_id' => 11,
			'category_id' => 3,
		]);
		$title = 'Det är bara käbbel';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 3,
			'subcategory_id' => 12,
			'category_id' => 3,
		]);
		$title = 'ywoepafnyawi8yvf';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 1,
			'subcategory_id' => 13,
			'category_id' => 3,
		]);
		$title = 'Nice dingo pictures';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 2,
			'subcategory_id' => 14,
			'category_id' => 3,
		]);
		$title = 'My plan to hack NSA, don\'t tell anyone';
		Thread::create([
			'title' => $title,
			'slug' => urlencode($title),
			'user_id' => 3,
			'subcategory_id' => 15,
			'category_id' => 3,
		]);

		factory(App\Thread::class, 10)->create()->each(function($thread) {
			App\ActivityLog::create([
				'user_id' 	   => $thread->user->id,
				'task'	  	   => __('created'),
				'performed_on' => json_encode(['table' => 'threads', 'id' => $thread->id]),
                'created_at'   => $thread->created_at,
                'updated_at'   => $thread->updated_at,
			]);
		});
    }
}