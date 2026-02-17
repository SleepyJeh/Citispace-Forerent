<?php

namespace Database\Factories;

use App\Models\Lease;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaseFactory extends Factory
{
    protected $model = Lease::class;

    public function definition(): array
    {
        // Random start date between 3 years ago and today
        $startDate = $this->faker->dateTimeBetween('-3 years', 'now');

        // Lease term (months)
        $term = $this->faker->numberBetween(3, 12);

        // Compute end date
        $endDate = (clone $startDate)->modify("+{$term} months");

        // Determine lease status
        $status = $endDate < now() ? 'Expired' : 'Active';

        return [
            // These will be set in LeaseSeeder
            'tenant_id'        => null,
            'bed_id'           => null,

            'status'           => $status,
            'term'             => $term,
            'shift'            => $this->faker->randomElement(['Night', 'Morning']),
            'auto_renew'       => $this->faker->boolean(),

            'start_date'       => $startDate->format('Y-m-d'),
            'end_date'         => $endDate->format('Y-m-d'),
            'move_in'          => $startDate->format('Y-m-d'),

            'contract_rate'    => $this->faker->randomFloat(2, 3000, 15000),
            'advance_amount'   => $this->faker->randomFloat(2, 500, 2000),
            'security_deposit' => $this->faker->randomFloat(2, 500, 5000),

            'created_at'       => now(),
            'updated_at'       => now(),
        ];
    }
}
