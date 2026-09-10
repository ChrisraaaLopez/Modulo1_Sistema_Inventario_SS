<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            AreasSeeder::class,
            CategoriasSeeder::class,
            DemoModulo1Seeder::class,
            ExtendedDemoSeeder::class,
        ]);
    }
}