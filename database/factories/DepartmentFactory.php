<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->randomElement([
                'Informatique', 'Ressources Humaines', 'Finance',
                'Marketing', 'Juridique', 'Logistique',
            ]),
        ];
    }
}