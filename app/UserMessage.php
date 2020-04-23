<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    protected $guarded = [];

	public function author() {
		return $this->belongsTo(User::class, 'author_id');
	}

	public function recipients() {
		return $this->belongsToMany(User::class, 'user_messages', 'recipient_id', 'author_id');
	}
}