<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'nom',
        'description',
    ];

    /**
     * Relation : un département possède plusieurs utilisateurs.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relation : un département possède plusieurs documents.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Relation : un département possède plusieurs projets.
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}