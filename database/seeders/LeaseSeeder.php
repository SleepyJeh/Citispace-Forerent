<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bed;
use App\Models\Lease;

class LeaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all beds that are 'occupied' but have no lease yet
        $beds = Bed::where('status', 'occupied')
            ->whereDoesntHave('leases')
            ->get();

        foreach ($beds as $bed) {
            // Create a tenant for each bed
            $tenant = User::factory()->create(['role' => 'tenant']);

            // Create a lease linking tenant and bed
            Lease::factory()->create([
                'tenant_id' => $tenant->user_id,
                'bed_id'    => $bed->bed_id,
            ]);
        }
    }
}
