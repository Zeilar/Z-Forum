<?php

namespace App\Policies;

use App\MaintenanceMode;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenanceModePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the maintenance mode.
     *
     * @param  \App\User  $user
     * @param  \App\MaintenanceMode  $maintenanceMode
     * @return mixed
     */
    public function update(User $user, MaintenanceMode $maintenanceMode)
    {
        if ($user->is_suspended()) return false;
        return $user->is_role('superadmin');
    }
}