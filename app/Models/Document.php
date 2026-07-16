<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'titre',
        'description',
        'fichier',
        'project_id',
        'category_id',
        'department_id',
        'user_id',
    ];

    // Auteur du document
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    // Utilisateurs avec qui le document est partagé (+ droit)
    public function sharedWith()
    {
        return $this->belongsToMany(User::class, 'document_user')
            ->withPivot('droit')
            ->withTimestamps();
    }

    // Réunions associées au document
    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'document_meeting')
            ->withTimestamps();
    }
}