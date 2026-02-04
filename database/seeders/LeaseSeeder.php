<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bed;
use App\Models\Lease;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaseSeeder extends Seeder
{
    public function run(): void
    {
      
        $beds = Bed::where('status', 'occupied')
            ->whereDoesntHave('leases')
            ->get();

        foreach ($beds as $bed) {
             $tenant = User::factory()->create(['role' => 'tenant']);

             $lease = Lease::factory()->create([
                'tenant_id' => $tenant->user_id,
                'bed_id'    => $bed->bed_id,
                'contract_rate' => 24000,
            ]);


            for ($i = 0; $i < 12; $i++) {


                $anchorDate = Carbon::parse('2025-01-28');

                $billingDate = $anchorDate->copy()->subMonths($i);
                $nextBilling = $billingDate->copy()->addMonth();

                // DETERMINE STATUS
                if ($i === 0) {
                     $status = 'Unpaid';
                } elseif ($i === 1) {
                     $status = 'Overdue';
                } else {
                     $status = 'Paid';
                }

                // Insert the bill
                DB::table('billings')->insert([
                    'lease_id' => $lease->lease_id,
                    'billing_date' => $billingDate,
                    'next_billing' => $nextBilling,
                    'to_pay' => 24000,
                    'amount' => ($status === 'Paid') ? 24000 : 0,
                    'status' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
