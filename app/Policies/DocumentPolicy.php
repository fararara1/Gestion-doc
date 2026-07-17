<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function view(User $user, Document $document): bool
    {
        return $user->isAdmin()
            || $user->id === $document->user_id
            || $document->sharedWith()->where('users.id', $user->id)->exists();
    }

    public function update(User $user, Document $document): bool
    {
        if ($user->isAdmin() || $user->id === $document->user_id) {
            return true;
        }

        return $document->sharedWith()
            ->where('users.id', $user->id)
            ->wherePivot('droit', 'modification')
            ->exists();
    }

    public function delete(User $user, Document $document): bool
    {
        return $user->isAdmin() || $user->id === $document->user_id;
    }

    public function share(User $user, Document $document): bool
    {
        return $user->isAdmin() || $user->id === $document->user_id;
    }
}
