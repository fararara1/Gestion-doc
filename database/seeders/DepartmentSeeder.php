<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Informatique', 'Ressources Humaines', 'Finance',
            'Marketing', 'Juridique', 'Logistique',
        ];

        foreach ($departments as $nom) {
            Department::create(['nom' => $nom]);
        }
    }
}