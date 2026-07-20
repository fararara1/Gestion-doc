<?php

namespace App\Policies;

use App\Models\Meeting;
use App\Models\User;

class MeetingPolicy
{
    public function view(User $user, Meeting $meeting): bool
    {
        if ($user->isAdmin() || $user->id === $meeting->user_id) {
            return true;
        }

        return $meeting->relationLoaded('participants')
            ? $meeting->participants->contains('id', $user->id)
            : $meeting->participants()->where('users.id', $user->id)->exists();
    }

    public function update(User $user, Meeting $meeting): bool
    {
        return $user->isAdmin() || $user->id === $meeting->user_id;
    }

    public function delete(User $user, Meeting $meeting): bool
    {
        return $user->isAdmin() || $user->id === $meeting->user_id;
    }
}
