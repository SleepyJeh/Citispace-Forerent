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
        User::factory()->create([
            'first_name' => 'Tricia',
            'last_name' => 'Tenant',
            'email' => 'tenant@example.com',
            'role' => 'tenant',
            'password' => 'password',
        ]);

        User::factory()->create([
            'first_name' => 'Marcus',
            'last_name' => 'Manager',
            'email' => 'manager@example.com',
            'role' => 'manager',
            'password' => 'password',
        ]);

        User::factory()->create([
            'first_name' => 'Liam',
            'last_name' => 'Landlord',
            'email' => 'landlord@example.com',
            'role' => 'landlord',
            'password' => 'password',
        ]);

        // 4 Random Manager
        User::factory()->count(4)->create(['role' => 'manager']);

    }
}
