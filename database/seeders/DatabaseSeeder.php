<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            DepartmentSeeder::class,
            CategorySeeder::class,
            ProjectSeeder::class,
            UserSeeder::class,
        ]);
    }
}