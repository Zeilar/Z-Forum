<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserMessage extends Model
{
    use SoftDeletes;

    protected $guarded = [];

	public function author() {
		return $this->belongsTo(User::class, 'author_id');
	}

	public function recipient() {
		return $this->belongsTo(User::class, 'recipient_id');
	}

    public function is_deleted() {
        return $this->deleted_at ?? false;
    }
}