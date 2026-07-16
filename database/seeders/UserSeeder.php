<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $informatique = Department::where('nom', 'Informatique')->first();

        // Compte administrateur par défaut
        User::factory()->admin()->create([
            'nom' => 'Admin',
            'prenom' => 'Super',
            'email' => 'admin@entreprise.com',
            'department_id' => $informatique?->id,
        ]);

        // Collaborateurs de test
        User::factory()->count(10)->create();
    }
}