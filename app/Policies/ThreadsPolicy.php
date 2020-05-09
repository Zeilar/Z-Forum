<?php

namespace App\Policies;

use App\Thread;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreadsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function view(User $user, Thread $thread)
    {
        return true;
    }

    /**
     * Determine whether the user can create threads.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->is_suspended()) {
            return false;
        }
        return logged_in();
    }

    /**
     * Determine whether the user can update the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function update(User $user, Thread $thread)
    {
        return $user->is_role('superadmin');
    }

    /**
     * Determine whether the user can delete the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function delete(User $user, Thread $thread)
    {
        return $user->is_role('superadmin');
    }

	/**
     * Determine whether the user can toggle the thread lock.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function toggle(User $user, Thread $thread)
    {
        return $user->is_role('superadmin', 'moderator');
    }

    /**
     * Determine whether the user can restore the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function restore(User $user, Thread $thread)
    {
        return $user->is_role('superadmin');
    }

    /**
     * Determine whether the user can permanently delete the thread.
     *
     * @param  \App\User  $user
     * @param  \App\Thread  $thread
     * @return mixed
     */
    public function forceDelete(User $user, Thread $thread)
    {
        return $user->is_role('superadmin');
    }
}
