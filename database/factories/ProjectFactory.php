<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->catchPhrase(),
            'description' => fake()->sentence(15),
        ];
    }
}