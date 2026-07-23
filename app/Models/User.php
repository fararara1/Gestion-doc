<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $with = ['department'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function sharedDocuments(): BelongsToMany
    {
        return $this->belongsToMany(Document::class, 'document_user')
            ->withPivot('droit')
            ->withTimestamps();
    }

    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_user')
            ->withTimestamps();
    }

    public function isAdmin(): bool
    {
        return $this->role === 'administrateur';
    }
}
