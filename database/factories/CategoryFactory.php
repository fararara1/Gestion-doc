<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->randomElement([
                'Rapport', 'Contrat', 'Facture', 'Procès-verbal',
                'Cahier des charges', 'Note interne',
            ]),
        ];
    }
}