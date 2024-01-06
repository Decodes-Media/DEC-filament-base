<?php

namespace App\Policies\Base;

use App\Models\Base\ActivityLog;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Access\Authorizable;

class ActivityLogPolicy
{
    public function viewAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function view(Authorizable $authorizable, ActivityLog $record): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function create(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function update(Authorizable $authorizable, ActivityLog $record): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function delete(Authorizable $authorizable, ActivityLog $record): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function deleteAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function forceDelete(Authorizable $authorizable, ActivityLog $record): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function forceDeleteAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function restore(Authorizable $authorizable, ActivityLog $record): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function restoreAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function replicate(Authorizable $authorizable, ActivityLog $record): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }

    public function reorder(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.log_activity');
    }
}
