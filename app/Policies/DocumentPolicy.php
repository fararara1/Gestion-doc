<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    public function view(User $user, Document $document): bool
    {
        if ($user->isAdmin() || $user->id === $document->user_id) {
            return true;
        }

        return $document->relationLoaded('sharedWith')
            ? $document->sharedWith->contains('id', $user->id)
            : $document->sharedWith()->where('users.id', $user->id)->exists();
    }

    public function update(User $user, Document $document): bool
    {
        if ($user->isAdmin() || $user->id === $document->user_id) {
            return true;
        }

        if (! $document->relationLoaded('sharedWith')) {
            return $document->sharedWith()
                ->where('users.id', $user->id)
                ->wherePivot('droit', 'modification')
                ->exists();
        }

        return $document->sharedWith
            ->where('id', $user->id)
            ->where('pivot.droit', 'modification')
            ->isNotEmpty();
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
