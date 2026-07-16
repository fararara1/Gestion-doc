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
}