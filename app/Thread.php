<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function category()
	{
		return $this->belongsTo(Category::class);
	}

	public function subcategory()
	{
		return $this->belongsTo(Subcategory::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function toggle() {
        $this->locked ? $this->locked = false : true;
        return $this->save();
    }

    public function lock() {
        $this->locked = true;
        return $this->save();
    }

    public function unlock() {
        $this->locked = false;
        return $this->save();
    }

    public function is_locked() {
        return $this->locked;
    }
}