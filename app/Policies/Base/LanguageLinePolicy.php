<?php

namespace App\Policies\Base;

use App\Models\Base\LanguageLine;
use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Access\Authorizable;

class LanguageLinePolicy
{
    public function viewAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function view(Authorizable $authorizable, LanguageLine $record): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function create(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function update(Authorizable $authorizable, LanguageLine $record): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function delete(Authorizable $authorizable, LanguageLine $record): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function deleteAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function forceDelete(Authorizable $authorizable, LanguageLine $record): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function forceDeleteAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function restore(Authorizable $authorizable, LanguageLine $record): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function restoreAny(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function replicate(Authorizable $authorizable, LanguageLine $record): Response|bool
    {
        return $authorizable->can('system.translation');
    }

    public function reorder(Authorizable $authorizable): Response|bool
    {
        return $authorizable->can('system.translation');
    }
}
