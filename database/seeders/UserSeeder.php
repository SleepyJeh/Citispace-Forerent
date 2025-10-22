<?php

// database/seeders/UserSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <-- 1. Import your User model

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 2. Create a specific Tenant for testing
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Tenant',
            'email' => 'tenant@example.com',
            'role' => 'tenant',
            'password' => 'password',
        ]);

        // 3. Create a specific Manager for testing
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Manager',
            'email' => 'manager@example.com',
            'role' => 'manager',
            'password' => 'password',
        ]);

        // 4. Create a specific Landlord for testing
        User::factory()->create([
            'first_name' => 'Test',
            'last_name' => 'Landlord',
            'email' => 'landlord@example.com',
            'role' => 'landlord',
            'password' => 'password',
        ]);

        // 5. Create 20 more random users
        User::factory()->count(20)->create();
    }
}