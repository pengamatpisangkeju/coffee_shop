<?php

namespace Database\Seeders;

use App\Models\Barista;
use App\Models\Cashier;
use App\Models\Manager;
use App\Models\Owner;
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

        $ownerUser = User::where('email', 'owner@example.com')->first();

        if ($ownerUser) {
            Owner::create([
                'user_id' => $ownerUser->id,
                'name' => 'Katie Owner',
                'phone_number' => '1234567890',
                'address' => '123 Manager St',
            ]);
        }

        $managerUser = User::where('email', 'manager@example.com')->first();

        if ($managerUser) {
            Manager::create([
                'user_id' => $managerUser->id,
                'name' => 'John Manager',
                'phone_number' => '1234567890',
                'address' => '123 Manager St',
                'monthly_wage' => 5000000,
            ]);
        }

        $cashierUser = User::where('email', 'cashier@example.com')->first();

        if ($cashierUser) {
            Cashier::create([
                'user_id' => $cashierUser->id,
                'name' => 'Jane Cashier',
                'phone_number' => '0987654321',
                'address' => '456 Cashier Ave',
                'monthly_wage' => 3000000,
            ]);
        }
    }
}
