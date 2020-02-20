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

	public function tableSubcategory()
	{
		return $this->belongsTo(TableSubcategory::class);
	}

	public function tableCategory()
	{
		return $this->belongsTo(TableCategory::class);
	}
}