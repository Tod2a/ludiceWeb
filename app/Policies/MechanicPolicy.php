<?php

namespace App\Policies;

use App\Models\User;
use App\Models\mechanic;
use Illuminate\Auth\Access\Response;

class MechanicPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, mechanic $mechanic): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return \App\Models\Role::USER !== $user->role->name;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, mechanic $mechanic): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, mechanic $mechanic): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, mechanic $mechanic): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, mechanic $mechanic): bool
    {
        return false;
    }
}
