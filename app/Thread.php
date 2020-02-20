<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function tableCategory()
	{
		return $this->belongsTo(TableCategory::class);
	}

	public function tableSubcategory()
	{
		return $this->belongsTo(TableSubcategory::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}