<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function threads()
	{
		return $this->hasMany(Thread::class);
	}

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

    public function is_deleted() {
        return $this->deleted_at ?? false;
    }
}