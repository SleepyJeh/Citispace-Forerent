<?php

namespace Database\Factories;

use App\Models\Lease;
use App\Models\User;
use App\Models\Bed;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LeaseFactory extends Factory
{
    protected $model = Lease::class;

    private ?string $tenantRole = 'tenant';

    public function definition(): array
    {
        $tenantId = $this->getTenantId();
        $bedId = $this->getBedId();

        // Random start date between 3 years ago and today
        $startDate = $this->faker->dateTimeBetween('-3 years', 'now');

        // Lease term in months
        $term = $this->faker->numberBetween(3, 12);

        // End date based on term
        $endDate = (clone $startDate)->modify("+{$term} months");

        // Determine status automatically
        $status = $endDate < now() ? 'Expired' : 'Active';

        return [
            'tenant_id'        => $tenantId,
            'bed_id'           => $bedId,
            'status'           => $status,
            'term'             => $term,
            'shift'            => $this->faker->randomElement(['Night', 'Morning']),
            'auto_renew'       => $this->faker->boolean(),
            'start_date'       => $startDate->format('Y-m-d'),
            'end_date'         => $endDate->format('Y-m-d'),
            'contract_rate'    => $this->faker->randomFloat(2, 3000, 15000),
            'advance_amount'   => $this->faker->randomFloat(2, 500, 2000),
            'security_deposit' => $this->faker->randomFloat(2, 500, 5000),
            'move_in'          => $startDate->format('Y-m-d'),
        ];
    }

    /**
     * Chainable method to filter tenants by role
     */
    public function tenantRole(string $role): self
    {
        $factory = clone $this;
        $factory->tenantRole = $role;
        return $factory;
    }

    /**
     * Get a tenant that doesn't have a lease yet
     */
    private function getTenantId(): int
    {
        $tenant = User::where('role', $this->tenantRole)
            ->whereDoesntHave('leases') // assumes User has 'leases' relationship
            ->inRandomOrder()
            ->first();

        if (!$tenant) {
            $tenant = User::factory()->create(['role' => $this->tenantRole]);
        }

        return $tenant->user_id;
    }

    /**
     * Get a bed that is marked as 'occupied' but has no lease yet
     */
    private function getBedId(): int
    {
        $bed = Bed::where('status', 'Occupied')
            ->whereDoesntHave('leases') // assumes Bed has 'lease' relationship
            ->inRandomOrder()
            ->first();

        if (!$bed) {
            // Fallback: create a new occupied bed
            $bed = Bed::factory()->create(['status' => 'Occupied']);
        }

        return $bed->bed_id;
    }
}
