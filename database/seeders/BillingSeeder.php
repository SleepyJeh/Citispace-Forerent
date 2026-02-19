<?php

namespace Database\Seeders;

use App\Models\Billing;
use App\Models\Lease;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $leases = Lease::all();

        foreach ($leases as $lease) {
            $billingDate = Carbon::parse($lease->move_in)->addMonth();
            $nextBilling = (clone $billingDate)->addMonth();
            $contractPrice = $lease->contract_rate;

            // Determine status based on today's date
            if (Carbon::now()->gt($billingDate)) {
                // Today is later than billing date -> Overdue or Paid
                $status = fake()->randomElement(['Overdue', 'Paid']);
            } else {
                // Today is on or before billing date -> Paid or Unpaid
                $status = fake()->randomElement(['Paid', 'Unpaid']);
            }

            Billing::factory()->create([
                'lease_id'     => $lease->lease_id,
                'billing_date' => $billingDate->format('Y-m-d'),
                'next_billing' => $nextBilling->format('Y-m-d'),
                'to_pay'       => $contractPrice,
                'amount'       => $contractPrice,
                'status'       => $status,
            ]);
        }
    }
}
