<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Thread;
use User;

class UserVisitedThreads extends Model
{
	protected $guarded = [];

    public function user()
	{
		return $this->belongsTo(User::class);
	}
}