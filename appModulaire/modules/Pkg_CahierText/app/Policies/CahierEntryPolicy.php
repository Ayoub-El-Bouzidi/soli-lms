<?php

namespace Modules\Pkg_CahierText\app\Policies;

use App\Models\User;
use Modules\Pkg_CahierText\app\Models\CahierEntry;
use Illuminate\Auth\Access\HandlesAuthorization;

class CahierEntryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->hasRole('formateur');
    }

    public function view(User $user, CahierEntry $entry)
    {
        return $user->id === $entry->formateur_id;
    }

    public function create(User $user)
    {
        return $user->hasRole('formateur');
    }

    public function update(User $user, CahierEntry $entry)
    {
        return $user->id === $entry->formateur_id;
    }

    public function delete(User $user, CahierEntry $entry)
    {
        return $user->id === $entry->formateur_id;
    }
}
