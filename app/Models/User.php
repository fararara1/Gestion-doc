<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'role',
        'department_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Service (département) de l'utilisateur
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Documents dont l'utilisateur est l'auteur
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Documents partagés avec cet utilisateur (avec le droit associé)
    public function sharedDocuments()
    {
        return $this->belongsToMany(Document::class, 'document_user')
            ->withPivot('droit')
            ->withTimestamps();
    }

    // Réunions auxquelles l'utilisateur participe
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_user')
            ->withTimestamps();
    }

    // Helper de rôle
    public function isAdmin(): bool
    {
        return $this->role === 'administrateur';
    }
}