<?php

namespace App\Policies\Main;

use App\Models\Main\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Access\Authorizable;

class UserPolicy
{
    public function viewAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('user.view');
    }

    public function view(Authorizable $authorizable, User $record): Response|bool
    {
        return $authorizable->can('user.view');
    }

    public function create(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('user.create');
    }

    public function update(Authorizable $authorizable, User $record): Response|bool
    {
        return $authorizable->can('user.update');
    }

    public function delete(Authorizable $authorizable, User $record): Response|bool
    {
        return $authorizable->can('user.delete');
    }

    public function deleteAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('user.delete');
    }

    public function forceDelete(Authorizable $authorizable, User $record): Response|bool
    {
        return $authorizable->can('user.delete');
    }

    public function forceDeleteAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('user.delete');
    }

    public function restore(Authorizable $authorizable, User $record): Response|bool
    {
        return $authorizable->can('user.create');
    }

    public function restoreAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('user.create');
    }

    public function replicate(Authorizable $authorizable, User $record): Response|bool
    {
        return $authorizable->can('user.create');
    }

    public function reorder(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('user.update');
    }
}
