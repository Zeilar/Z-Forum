<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

	/**
     * The default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'settings' => '{
			"posts_per_page": 20
		}',
		'role' => 'member',
    ];

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [
		'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

	public function posts()
	{
		return $this->hasMany(Post::class);
	}

	public function threads() {
		return $this->hasMany(Thread::class);
	}

	public function visited_threads()
	{
		return $this->hasMany(UserVisitedThreads::class);
	}

	public function visited_messages()
	{
		return $this->hasMany(UserVisitedMessage::class);
	}

	public function likes() {
		return $this->hasMany(UserLikedPosts::class);
	}

	public function messages_sent() {
		return $this->hasMany(UserMessage::class, 'author_id', 'id');
	}

	public function messages_received() {
		return $this->hasMany(UserMessage::class, 'recipient_id', 'id');
	}

    public function chat_messages() {
        return $this->hasMany(ChatMessage::class);
    }
}