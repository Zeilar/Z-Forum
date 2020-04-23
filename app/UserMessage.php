<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    protected $guarded = [];

	public function author() {
		return $this->belongsTo(User::class, 'author_id');
	}

	public function recipient() {
		return $this->belongsTo(User::class, 'recipient_id');
	}
}