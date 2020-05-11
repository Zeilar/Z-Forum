<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use SoftDeletes;

    protected $guarded = [];

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

    public function is_deleted() {
        return $this->deleted_at ?? false;
    }
}