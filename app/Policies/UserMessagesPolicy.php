<?php

namespace App\Policies;

use App\User;
use App\UserMessage;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserMessagesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any user messages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->is_role('superadmin');
    }

    /**
     * Determine whether the user can view the user message.
     *
     * @param  \App\User  $user
     * @param  \App\UserMessage  $userMessage
     * @return mixed
     */
    public function view(User $user, UserMessage $userMessage)
    {
        return true;
        if ($user->is_role('superadmin')) return true;
        if ($userMessage->author->id === $user->id || $userMessage->recipient->id === $user->id) return true;
        return false;
    }

    /**
     * Determine whether the user can create user messages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if ($user->is_suspended()) return false;
        return logged_in();
    }

    /**
     * Determine whether the user can update the user message.
     *
     * @param  \App\User  $user
     * @param  \App\UserMessage  $userMessage
     * @return mixed
     */
    public function update(User $user, UserMessage $userMessage)
    {
        return $user->is_role('superadmin');
    }

    /**
     * Determine whether the user can delete the user message.
     *
     * @param  \App\User  $user
     * @param  \App\UserMessage  $userMessage
     * @return mixed
     */
    public function delete(User $user, UserMessage $userMessage)
    {
        return $user->is_role('superadmin');
    }

    /**
     * Determine whether the user can restore the user message.
     *
     * @param  \App\User  $user
     * @param  \App\UserMessage  $userMessage
     * @return mixed
     */
    public function restore(User $user, UserMessage $userMessage)
    {
        return $user->is_role('superadmin');
    }

    /**
     * Determine whether the user can permanently delete the user message.
     *
     * @param  \App\User  $user
     * @param  \App\UserMessage  $userMessage
     * @return mixed
     */
    public function forceDelete(User $user, UserMessage $userMessage)
    {
        return $user->is_role('superadmin');
    }
}