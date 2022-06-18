<?php

namespace App\Policies;

use App\Models\DrivingService;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DrivingServicePolicy
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
     * @param  \App\Models\DrivingService  $drivingService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, DrivingService $drivingService)
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
     * @param  \App\Models\DrivingService  $drivingService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, DrivingService $drivingService)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DrivingService  $drivingService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, DrivingService $drivingService)
    {
        return $user->id === $drivingService->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DrivingService  $drivingService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, DrivingService $drivingService)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\DrivingService  $drivingService
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, DrivingService $drivingService)
    {
        //
    }
}
