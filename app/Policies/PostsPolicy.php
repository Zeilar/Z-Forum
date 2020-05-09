<?php

namespace App\Policies;

use App\Post;
use App\User;
use App\Thread;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function view(User $user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user, Thread $thread)
    {
        if ($user->is_suspended()) {
            return false;
        } else if ($user->is_role('superadmin', 'moderator')) {
			return true;
		} else if ($thread->locked) {
			return false;
		} else {
			return true;
		}
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        if ($user->is_suspended()) {
            return false;
        } else if ($user->is_role('superadmin', 'moderator')) {
			return true;
		} else if ($post->thread->locked) {
			return false;
		} else if ($user->id === $post->user->id) {
			return true;
		} else {
			return false;
		}
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        if ($user->is_suspended()) {
            return false;
        } if ($user->is_role('superadmin')) {
			return true;
		} else if ($post->thread->locked) {
			return false;
		} else if ($post->thread->posts()->first()->id === $post->id) {
			return false;
		} else if ($user->id === $post->user->id) {
			return true;
		} else {
			return false;
		}
    }

    /**
     * Determine whether the user can restore the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function restore(User $user, Post $post)
    {
        return $user->is_role('superadmin');
    }

    /**
     * Determine whether the user can permanently delete the post.
     *
     * @param  \App\User  $user
     * @param  \App\Post  $post
     * @return mixed
     */
    public function forceDelete(User $user, Post $post)
    {
        return $user->is_role('superadmin');
    }
}