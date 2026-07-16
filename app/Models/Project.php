<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'date_debut',
        'date_fin',
        'statut',
        'department_id'
    ];


    // Un projet appartient à un département
    public function department()
    {
        return $this->belongsTo(Department::class);
    }


    // Un projet possède plusieurs documents
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}