<?php

namespace App\Policies;

use App\Subcategory;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubcategoriesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any subcategories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the subcategory.
     *
     * @param  \App\User  $user
     * @param  \App\Subcategory  $subcategory
     * @return mixed
     */
    public function view(User $user, Subcategory $subcategory)
    {
        return true;
    }

    /**
     * Determine whether the user can create subcategories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return is_role('superadmin');
    }

    /**
     * Determine whether the user can update the subcategory.
     *
     * @param  \App\User  $user
     * @param  \App\Subcategory  $subcategory
     * @return mixed
     */
    public function update(User $user, Subcategory $subcategory)
    {
        return is_role('superadmin');
    }

    /**
     * Determine whether the user can delete the subcategory.
     *
     * @param  \App\User  $user
     * @param  \App\Subcategory  $subcategory
     * @return mixed
     */
    public function delete(User $user, Subcategory $subcategory)
    {
        return is_role('superadmin');
    }

    /**
     * Determine whether the user can restore the subcategory.
     *
     * @param  \App\User  $user
     * @param  \App\Subcategory  $subcategory
     * @return mixed
     */
    public function restore(User $user, Subcategory $subcategory)
    {
        return is_role('superadmin');
    }

    /**
     * Determine whether the user can permanently delete the subcategory.
     *
     * @param  \App\User  $user
     * @param  \App\Subcategory  $subcategory
     * @return mixed
     */
    public function forceDelete(User $user, Subcategory $subcategory)
    {
        return is_role('superadmin');
    }
}
