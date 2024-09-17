<?php

namespace App\Policies;

use App\Models\Language;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LanguagePolicy
{
    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Language $language): bool
    {
        // return $language->key !== 'default' || $user->email == 'matse@vanhorebeek.be';
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Language $language): bool
    {
        return $language->key !== 'default';
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Language $language): bool
    {
        return $language->key !== 'default';
    }
}
