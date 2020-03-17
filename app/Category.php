<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories()
	{
		return $this->hasMany(Subcategory::class);
	}

	public function threads()
	{
		return $this->hasMany(Thread::class);
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}
}