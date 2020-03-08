<?php

namespace App\Policies;

use App\Trip;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TripPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return $user->role === 'admin' ?  Response::allow() : Response::deny('You do not have permission to create a trip');
    }
    public function update(User $user)
    {
        return $user->role === 'admin' ?  Response::allow() : Response::deny('You do not have permission to update a trip');
    }
}
