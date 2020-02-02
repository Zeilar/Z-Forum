<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	public function post()
	{
		return $this->hasMany(Post::class);
	}

	public function tableSubcategory()
	{
		return $this->belongsTo(TableSubcategory::class);
	}

	public function author()
	{
		return $this->belongsTo(User::class);
	}
}
