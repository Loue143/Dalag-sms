<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Creates the default admin account
        User::create([
            'name' => 'UniFAST Administrator',
            'email' => 'admin@unifast.gov.ph',
            'password' => Hash::make('adminpassword123'),
            'role' => 'admin' // We explicitly set this to admin!
        ]);
    }
}