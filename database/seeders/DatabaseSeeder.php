<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // This tells Laravel to run your Admin script
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}