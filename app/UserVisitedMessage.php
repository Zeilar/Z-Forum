<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserVisitedMessage extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function user()
	{
		return $this->belongsTo(User::class);
	}
	
	public function message()
	{
		return $this->belongsTo(UserMessage::class, 'user_message_id');
	}
}