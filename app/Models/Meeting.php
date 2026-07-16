<?php

namespace App\Models;
use App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    protected $fillable = [
    'titre',
    'description',
    'date',
    'heure_debut',
    'heure_fin',
    'user_id',
];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    // Participants
    public function participants()
    {
        return $this->belongsToMany(User::class, 'meeting_user')
            ->withTimestamps();
    }

    // Documents associés
    public function documents()
    {
        return $this->belongsToMany(Document::class, 'document_meeting')
            ->withTimestamps();
    }
    public function organisateur()
{
    return $this->belongsTo(User::class, 'user_id');
}
}