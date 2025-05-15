<?php

namespace App\Policies;

use App\Models\User;
use App\Models\publisher;
use Illuminate\Auth\Access\Response;

class PublisherPolicy
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
    public function view(User $user, publisher $publisher): bool
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
    public function update(User $user, publisher $publisher): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, publisher $publisher): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, publisher $publisher): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, publisher $publisher): bool
    {
        return false;
    }
}
