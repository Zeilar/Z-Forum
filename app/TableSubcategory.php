<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TableSubcategory extends Model
{
    public function tableCategory()
	{
		return $this->belongsTo(TableCategory::class);
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