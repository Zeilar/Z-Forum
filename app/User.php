<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

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
    ];

    /**
     * The attributes that should be Carbon objects.
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'suspended',
        'last_seen',
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

    public function is_role(string ...$roles) : bool {
        foreach ($roles as $role) {
            if (strtolower($this->role) === strtolower($role)) return true;
        }
        return false;
	}

    public function suspend($date, $reason) {
        $this->update([
            'suspended' => $date,
            'suspended_reason' => $reason,
        ]);
        return $this;
    }

    public function pardon() {
        $this->update([
            'suspended' => null,
            'suspended_reason' => null,
        ]);
        return $this;
    }

    public function is_online() {
        return \Illuminate\Support\Facades\Cache::has('user-online-' . $this->id) ? true : false;
    }

    public function is_suspended() {
        return $this->suspended !== null && !$this->suspended->isPast();
    }
}