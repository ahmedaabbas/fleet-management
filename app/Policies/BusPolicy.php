<?php

namespace App\Policies;

use App\Bus;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BusPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any buses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the bus.
     *
     * @param  \App\User  $user
     * @param  \App\Bus  $bus
     * @return mixed
     */
    public function view(User $user, Bus $bus)
    {
        //
    }

    /**
     * Determine whether the user can create buses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role === 'admin' ?  Response::allow() : Response::deny('You do not have permission to create a bus');
    }

    /**
     * Determine whether the user can update the bus.
     *
     * @param  \App\User  $user
     * @param  \App\Bus  $bus
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role === 'admin' ?  Response::allow() : Response::deny('You do not have permission to update a bus');
    }

    /**
     * Determine whether the user can delete the bus.
     *
     * @param  \App\User  $user
     * @param  \App\Bus  $bus
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role === 'admin' ?  Response::allow() : Response::deny('You do not have permission to delete a station');
    }

    /**
     * Determine whether the user can restore the bus.
     *
     * @param  \App\User  $user
     * @param  \App\Bus  $bus
     * @return mixed
     */
    public function restore(User $user, Bus $bus)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the bus.
     *
     * @param  \App\User  $user
     * @param  \App\Bus  $bus
     * @return mixed
     */
    public function forceDelete(User $user, Bus $bus)
    {
        //
    }
}
