<?php

namespace App\Policies;

use App\ChatMessage;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatMessagesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any chat messages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the chat message.
     *
     * @param  \App\User  $user
     * @param  \App\ChatMessage  $chatMessage
     * @return mixed
     */
    public function view(User $user, ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Determine whether the user can create chat messages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        if (!logged_in()) {
            return false;
        } else if ($user->is_suspended()) {
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can update the chat message.
     *
     * @param  \App\User  $user
     * @param  \App\ChatMessage  $chatMessage
     * @return mixed
     */
    public function update(User $user, ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Determine whether the user can delete the chat message.
     *
     * @param  \App\User  $user
     * @param  \App\ChatMessage  $chatMessage
     * @return mixed
     */
    public function delete(User $user, ChatMessage $chatMessage)
    {
        if ($user->is_suspended()) {
            return false;
        } else if ($user->id === $chatMessage->user->id || $user->is_role('moderator', 'superadmin')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the chat message.
     *
     * @param  \App\User  $user
     * @param  \App\ChatMessage  $chatMessage
     * @return mixed
     */
    public function restore(User $user, ChatMessage $chatMessage)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the chat message.
     *
     * @param  \App\User  $user
     * @param  \App\ChatMessage  $chatMessage
     * @return mixed
     */
    public function forceDelete(User $user, ChatMessage $chatMessage)
    {
        //
    }
}