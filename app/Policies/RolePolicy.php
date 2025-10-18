<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny( $user): bool
    {
        return $user->hasAbility('roles.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view( $user, Role $role): bool
    {
        return $user->hasAbility('roles.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create( $user): bool
    {
        return $user->hasAbility('roles.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update( $user, Role $role): bool
    {
        return $user->hasAbility('roles.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete( $user, Role $role): bool
    {

        // we avoid any one deleting the role 'administrator' by mistake
        return $user->hasAbility('roles.delete') && $role->name !== 'Adminstrator';
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore( $user, Role $role): bool
    {
        
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete( $user, Role $role): bool
    {
        //
    }
}
