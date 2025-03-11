<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Owner',
            'email' => 'owner@example.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);
        
        User::create([
            'name' => 'Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'role' => 'manager',
        ]);
        
        User::create([
            'name' => 'Cashier',
            'email' => 'cashier@example.com',
            'password' => Hash::make('password'),
            'role' => 'cashier',
        ]);
        
        User::create([
            'name' => 'Barista',
            'email' => 'barista@example.com',
            'password' => Hash::make('password'),
            'role' => 'barista',
        ]);
    }
}
