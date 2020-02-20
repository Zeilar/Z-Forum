<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableCategory extends Model
{
    public function tableSubcategories()
	{
		return $this->hasMany(TableSubcategory::class);
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