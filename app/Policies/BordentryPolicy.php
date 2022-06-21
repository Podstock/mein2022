<?php

namespace App\Policies;

use App\Models\Bordentry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BordentryPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->hasRole('Admin') || $user->hasRole('Orga')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bordentry  $bordentry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Bordentry $bordentry)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bordentry  $bordentry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Bordentry $bordentry)
    {
        return $user->id === $bordentry->user->id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bordentry  $bordentry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Bordentry $bordentry)
    {
        return $user->id === $bordentry->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bordentry  $bordentry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Bordentry $bordentry)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Bordentry  $bordentry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Bordentry $bordentry)
    {
        //
    }
}
