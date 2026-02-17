<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bed;
use App\Models\Lease;

class LeaseSeeder extends Seeder
{
    public function run(): void
    {
        // Get all tenants
        $tenants = User::where('role', 'tenant')->get();

        // Get all vacant beds with their units loaded
        $availableBeds = Bed::where('status', 'Vacant')->with('unit')->get();

        foreach ($tenants as $tenant) {

            // Stop if no beds left
            if ($availableBeds->isEmpty()) {
                break;
            }

            // Filter beds that are in units with a manager
            $managedBeds = $availableBeds->filter(function ($bed) {
                return !is_null($bed->unit->manager_id);
            });

            // Filter beds that match tenant gender based on unit occupants
            $matchingBeds = $managedBeds->filter(function ($bed) use ($tenant) {
                $occupantsType = $bed->unit->occupants; // Male, Female, Co-ed
                return $occupantsType === 'Co-ed' || $occupantsType === $tenant->gender;
            });

            // If no matching bed, skip tenant
            if ($matchingBeds->isEmpty()) {
                continue;
            }

            // Pick a random matching bed
            $bed = $matchingBeds->random();

            // Create the lease
            Lease::factory()->create([
                'tenant_id' => $tenant->user_id,
                'bed_id'    => $bed->bed_id,
            ]);

            // Mark bed as occupied
            $bed->update(['status' => 'Occupied']);

            // Remove the bed from available list
            $availableBeds = $availableBeds->reject(
                fn($b) => $b->bed_id === $bed->bed_id
            );
        }
    }
}
