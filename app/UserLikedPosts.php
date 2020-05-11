<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserLikedPosts extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function users()
	{
		return $this->belongsToMany(User::class);
	}
	
	public function posts()
	{
		return $this->belongsToMany(Post::class);
	}
}