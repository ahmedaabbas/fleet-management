<?php

namespace App\Policies;

use App\Station;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any stations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function view(User $user, Station $station)
    {
        //
    }

    /**
     * Determine whether the user can create stations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role === 'admin' ?  Response::allow() : Response::deny('You do not have permission to create a station');
    }

    /**
     * Determine whether the user can update the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->role === 'admin' ?  Response::allow() : Response::deny('You do not have permission to update a station');
    }

    /**
     * Determine whether the user can delete the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->role === 'admin' ?  Response::allow() : Response::deny('You do not have permission to delete a station');
    }

    /**
     * Determine whether the user can restore the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function restore(User $user, Station $station)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the station.
     *
     * @param  \App\User  $user
     * @param  \App\Station  $station
     * @return mixed
     */
    public function forceDelete(User $user, Station $station)
    {
        //
    }
}
