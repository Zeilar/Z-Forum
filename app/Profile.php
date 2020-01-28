<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}
}
