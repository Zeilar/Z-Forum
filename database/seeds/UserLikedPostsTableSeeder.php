<?php

use Illuminate\Database\Seeder;
use App\UserLikedPosts;

class UserLikedPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\UserLikedPosts::class, 5000)->create();
    }
}