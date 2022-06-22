<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LocalEvent;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocalEventPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, LocalEvent $localEvent)
    {
        return $localEvent->created_by === $user->id;
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, LocalEvent $localEvent)
    {
        return $localEvent->created_by === $user->id;
    }

    public function delete(User $user, LocalEvent $localEvent)
    {
        //
    }

    public function restore(User $user, LocalEvent $localEvent)
    {
        //
    }

    public function forceDelete(User $user, LocalEvent $localEvent)
    {
        //
    }
}
