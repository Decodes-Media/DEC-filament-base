<?php

namespace App\Policies\Base;

use App\Models\Base\Setting;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Access\Authorizable;

class SettingPolicy
{
    public function viewAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function view(Authorizable $authorizable, Setting $record): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function create(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function update(Authorizable $authorizable, Setting $record): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function delete(Authorizable $authorizable, Setting $record): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function deleteAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function forceDelete(Authorizable $authorizable, Setting $record): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function forceDeleteAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function restore(Authorizable $authorizable, Setting $record): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function restoreAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function replicate(Authorizable $authorizable, Setting $record): Response|bool
    {
        return $authorizable->can('system.setting');
    }

    public function reorder(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.setting');
    }
}
