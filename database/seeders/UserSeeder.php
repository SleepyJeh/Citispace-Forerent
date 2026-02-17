<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Tricia',
            'last_name' => 'Tenant',
            'email' => 'tenant@example.com',
            'role' => 'tenant',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Marcus',
            'last_name' => 'Manager',
            'email' => 'manager@example.com',
            'role' => 'manager',
            'password' => Hash::make('password'),
        ]);

        User::factory()->create([
            'first_name' => 'Liam',
            'last_name' => 'Landlord',
            'email' => 'landlord@example.com',
            'role' => 'landlord',
            'password' => Hash::make('password'),
        ]);

        User::factory()
            ->count(24)
            ->create([
                'role' => 'tenant',
                'password' => Hash::make('password'),
            ]);

        User::factory()
            ->count(4)
            ->create([
                'role' => 'manager',
                'password' => Hash::make('password'),
            ]);
    }
}
