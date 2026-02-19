<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Billing>
 */
class BillingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lease_id'      => null,
            'billing_date'  => now(),
            'next_billing'  => now()->addMonth(),
            'to_pay'        => 0,
            'amount'        => 0,
            'status'        => 'Pending',
        ];
    }
}
