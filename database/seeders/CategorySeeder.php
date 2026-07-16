<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Rapport', 'Contrat', 'Facture',
            'Procès-verbal', 'Cahier des charges', 'Note interne',
        ];

        foreach ($categories as $nom) {
            Category::create(['nom' => $nom]);
        }
    }
}