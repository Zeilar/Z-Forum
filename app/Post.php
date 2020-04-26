<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	public function thread()
	{
		return $this->belongsTo(Thread::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function subcategory()
	{
		return $this->belongsTo(Subcategory::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function likes() {
		return $this->hasMany(UserLikedPosts::class);
	}
}