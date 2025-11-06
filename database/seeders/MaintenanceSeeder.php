<?php
// database/seeders/MaintenanceSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        $maintenanceCategories = [
            'Plumbing',
            'Electrical',
            'Structural',
            'Appliance',
            'Pest Control'
        ];

        $urgencyLevels = ['Level 1', 'Level 2', 'Level 3', 'Level 4'];

        // Get existing lease IDs or create minimal dummy data
        $leaseIds = $this->getOrCreateLeaseIds();

        $maintenanceRequests = [];
        $maintenanceLogs = [];

        // Create exactly 3 years of data: 2021, 2022, 2023
        $startDate = Carbon::create(2021, 1, 1);
        $endDate = Carbon::now();

        $requestId = 1;
        $logId = 1;

        $this->command->info("Generating 3 years of maintenance data from {$startDate->format('Y')} to {$endDate->format('Y')}...");

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            // Generate 2-8 maintenance requests per month (creates realistic volume)
            $requestsThisMonth = rand(2, 8);

            for ($i = 0; $i < $requestsThisMonth; $i++) {
                $category = $maintenanceCategories[array_rand($maintenanceCategories)];
                $urgency = $this->getWeightedUrgency($category);
                $leaseId = $leaseIds[array_rand($leaseIds)];

                // Determine status - mix of completed and ongoing/pending
                // For historical data, most should be completed
                $statusWeights = ['Completed' => 0.85, 'Ongoing' => 0.1, 'Pending' => 0.05];
                $status = $this->getWeightedRandom($statusWeights);

                $costRange = $this->getCostRange($category);
                $baseCost = rand($costRange[0], $costRange[1]);

                // Add seasonal variation
                $seasonalFactor = $this->getSeasonalFactor($category, $currentDate->month);
                $finalCost = $baseCost * $seasonalFactor * (0.8 + (rand(0, 40) / 100));

                $completionDays = $this->getCompletionDays($category, $urgency);
                $completionDate = $currentDate->copy()->addDays($completionDays);

                // Ensure completion date doesn't exceed current date for realistic data
                if ($completionDate->gt(Carbon::now())) {
                    $completionDate = $currentDate->copy()->addDays(rand(1, 5));
                }

                // Create maintenance request
                $maintenanceRequests[] = [
                    'request_id' => $requestId,
                    'lease_id' => $leaseId,
                    'status' => $status,
                    'logged_by' => $this->getRandomStaffName(),
                    'ticket_number' => 'TICKET-' . str_pad($requestId, 6, '0', STR_PAD_LEFT),
                    'log_date' => $currentDate->format('Y-m-d'),
                    'problem' => $this->generateProblemDescription($category),
                    'urgency' => $urgency,
                    'created_at' => $currentDate->format('Y-m-d H:i:s'),
                    'updated_at' => $currentDate->format('Y-m-d H:i:s'),
                ];

                // Only create log entry for completed requests
                if ($status === 'Completed') {
                    $maintenanceLogs[] = [
                        'log_id' => $logId,
                        'request_id' => $requestId,
                        'completion_date' => $completionDate->format('Y-m-d'),
                        'cost' => round($finalCost, 2),
                        'created_at' => $completionDate->format('Y-m-d H:i:s'),
                        'updated_at' => $completionDate->format('Y-m-d H:i:s'),
                    ];
                    $logId++;
                }

                $requestId++;

                // Add some random days between requests in the same month for more realistic distribution
                if ($i < $requestsThisMonth - 1) {
                    $currentDate = $currentDate->copy()->addDays(rand(1, 5));
                    // Ensure we don't go beyond the current month
                    if ($currentDate->month != $startDate->month) {
                        $currentDate = $currentDate->copy()->subDays(rand(1, 5));
                    }
                }
            }

            // Move to next month
            $currentDate = $currentDate->copy()->addMonth()->day(1);

            // Show progress for each year
            if ($currentDate->month == 1) {
                $this->command->info("Generated data for year: " . ($currentDate->year - 1));
            }
        }

        // Insert requests in chunks
        $this->command->info("Inserting " . count($maintenanceRequests) . " maintenance requests...");
        foreach (array_chunk($maintenanceRequests, 100) as $chunk) {
            DB::table('maintenance_requests')->insert($chunk);
        }

        // Insert logs in chunks
        $this->command->info("Inserting " . count($maintenanceLogs) . " maintenance logs...");
        foreach (array_chunk($maintenanceLogs, 100) as $chunk) {
            DB::table('maintenance_logs')->insert($chunk);
        }

        // Calculate statistics
        $totalCost = array_sum(array_column($maintenanceLogs, 'cost'));
        $avgMonthlyRequests = count($maintenanceRequests) / 36; // 36 months in 3 years

        $this->command->info("✅ Successfully seeded 3 years of maintenance data!");
        $this->command->info("📊 Statistics:");
        $this->command->info("   • Total Maintenance Requests: " . number_format(count($maintenanceRequests)));
        $this->command->info("   • Completed Requests (with logs): " . number_format(count($maintenanceLogs)));
        $this->command->info("   • Date Range: 2021-01-01 to 2023-12-31");
        $this->command->info("   • Total Maintenance Cost: ₱" . number_format($totalCost, 2));
        $this->command->info("   • Average Monthly Requests: " . number_format($avgMonthlyRequests, 1));
    }

    private function getOrCreateLeaseIds()
    {
        // First, try to get existing lease IDs
        $leaseIds = DB::table('leases')->pluck('lease_id')->toArray();

        if (!empty($leaseIds)) {
            $this->command->info("Found " . count($leaseIds) . " existing leases.");
            return $leaseIds;
        }

        // If no leases exist, create realistic dummy leases spanning 3+ years
        $this->command->info("No existing leases found. Creating dummy leases spanning 3+ years...");

        // First, ensure we have users and beds
        $userIds = $this->getOrCreateUserIds();
        $bedIds = $this->getOrCreateBedIds();

        $leaseIds = [];
        $leaseStatuses = ['Active', 'Active', 'Active', 'Active', 'Expired', 'Active', 'Active', 'Expired', 'Active', 'Active'];

        for ($i = 0; $i < 10; $i++) {
            $startDate = Carbon::now()->subMonths(rand(6, 48)); // Leases starting from 6 to 48 months ago
            $endDate = $startDate->copy()->addMonths(rand(6, 24));

            $leaseId = DB::table('leases')->insertGetId([
                'tenant_id' => $userIds[array_rand($userIds)],
                'bed_id' => $bedIds[array_rand($bedIds)],
                'status' => $leaseStatuses[$i],
                'term' => rand(6, 24),
                'auto_renew' => rand(0, 1),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'contract_rate' => rand(5000, 15000),
                'advance_amount' => rand(0, 5000),
                'security_deposit' => rand(2000, 10000),
                'move_in' => $startDate->format('Y-m-d'),
                'created_at' => $startDate->format('Y-m-d H:i:s'),
                'updated_at' => $startDate->format('Y-m-d H:i:s'),
            ]);
            $leaseIds[] = $leaseId;
        }

        $this->command->info("Created " . count($leaseIds) . " dummy leases.");
        return $leaseIds;
    }

    private function getOrCreateUserIds()
    {
        $userIds = DB::table('users')->pluck('user_id')->toArray();

        if (!empty($userIds)) {
            return $userIds;
        }

        // Create realistic dummy users
        $userIds = [];
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Lisa', 'Robert', 'Maria', 'William', 'Anna'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];

        for ($i = 1; $i <= 10; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];

            $userId = DB::table('users')->insertGetId([
                'name' => $firstName . ' ' . $lastName,
                'email' => strtolower($firstName) . '.' . strtolower($lastName) . $i . '@example.com',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->subYears(rand(1, 3))->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            $userIds[] = $userId;
        }

        return $userIds;
    }

    private function getOrCreateBedIds()
    {
        $bedIds = DB::table('beds')->pluck('bed_id')->toArray();

        if (!empty($bedIds)) {
            return $bedIds;
        }

        // Create realistic dummy beds
        $bedIds = [];
        $bedStatuses = ['Available', 'Occupied', 'Available', 'Occupied', 'Available', 'Maintenance', 'Occupied', 'Available', 'Occupied', 'Available'];

        for ($i = 1; $i <= 15; $i++) {
            $bedId = DB::table('beds')->insertGetId([
                'bed_code' => 'BED-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => $bedStatuses[$i % count($bedStatuses)],
                'created_at' => Carbon::now()->subYears(rand(1, 3))->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            $bedIds[] = $bedId;
        }

        return $bedIds;
    }

    private function getWeightedUrgency($category)
    {
        $weights = [
            'Plumbing' => ['Level 1' => 0.4, 'Level 2' => 0.3, 'Level 3' => 0.2, 'Level 4' => 0.1],
            'Electrical' => ['Level 1' => 0.5, 'Level 2' => 0.3, 'Level 3' => 0.15, 'Level 4' => 0.05],
            'Structural' => ['Level 1' => 0.3, 'Level 2' => 0.4, 'Level 3' => 0.2, 'Level 4' => 0.1],
            'Appliance' => ['Level 1' => 0.2, 'Level 2' => 0.4, 'Level 3' => 0.3, 'Level 4' => 0.1],
            'Pest Control' => ['Level 1' => 0.1, 'Level 2' => 0.3, 'Level 3' => 0.4, 'Level 4' => 0.2],
        ];

        return $this->getWeightedRandom($weights[$category]);
    }

    private function getWeightedRandom($weights)
    {
        $random = rand(1, 100) / 100;
        $cumulative = 0;

        foreach ($weights as $item => $weight) {
            $cumulative += $weight;
            if ($random <= $cumulative) {
                return $item;
            }
        }

        return array_key_first($weights);
    }

    private function getCostRange($category)
    {
        $ranges = [
            'Plumbing' => [1500, 8000],
            'Electrical' => [2500, 8000],
            'Structural' => [3000, 8000],
            'Appliance' => [1000, 6000],
            'Pest Control' => [600, 2500],
        ];

        return $ranges[$category];
    }

    private function getSeasonalFactor($category, $month)
    {
        $factors = [
            'Plumbing' => [12 => 1.4, 1 => 1.4, 2 => 1.3, 6 => 0.8, 7 => 0.7, 8 => 0.8],
            'Electrical' => [6 => 1.3, 7 => 1.5, 8 => 1.4, 12 => 0.8, 1 => 0.7, 2 => 0.8],
            'Structural' => [3 => 1.2, 4 => 1.1, 9 => 1.2, 10 => 1.1],
            'Appliance' => [],
            'Pest Control' => [3 => 1.2, 6 => 1.2, 9 => 1.2, 12 => 1.2],
        ];

        return $factors[$category][$month] ?? 1.0;
    }

    private function getCompletionDays($category, $urgency)
    {
        $baseRanges = [
            'Plumbing' => [1, 7],
            'Electrical' => [1, 5],
            'Structural' => [5, 20],
            'Appliance' => [1, 7],
            'Pest Control' => [1, 4],
        ];

        $urgencyMultipliers = [
            'Level 1' => 0.3,
            'Level 2' => 0.6,
            'Level 3' => 0.8,
            'Level 4' => 1.0
        ];

        $range = $baseRanges[$category];
        $maxDays = (int)($range[1] * $urgencyMultipliers[$urgency]);
        $minDays = max(1, (int)($range[0] * $urgencyMultipliers[$urgency]));

        return rand($minDays, $maxDays);
    }

    private function getRandomStaffName()
    {
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Lisa', 'Robert', 'Maria', 'William', 'Anna'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez'];

        return $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    }

    private function generateProblemDescription($category)
    {
        $problems = [
            'Plumbing' => [
                'Leaking faucet in bathroom',
                'Clogged drain in kitchen sink',
                'Running toilet in unit',
                'Low water pressure in shower',
                'Water heater not working',
                'Pipe leakage under sink',
                'Dripping shower head needs replacement',
                'Sink drainage issue in common area'
            ],
            'Electrical' => [
                'Power outlet not working',
                'Light fixture malfunction',
                'Circuit breaker tripping',
                'AC unit electrical issues',
                'Wiring problem in bedroom',
                'Switch not functioning',
                'Flickering lights in hallway',
                'Electrical panel inspection needed'
            ],
            'Structural' => [
                'Crack in wall needs repair',
                'Door frame damage',
                'Window frame repair needed',
                'Ceiling crack inspection',
                'Flooring issue in living room',
                'Wall damage from moisture',
                'Loose floor tiles in bathroom',
                'Door not closing properly'
            ],
            'Appliance' => [
                'Refrigerator not cooling',
                'Oven temperature inaccurate',
                'Microwave not heating',
                'Washing machine malfunction',
                'Dryer not working properly',
                'Dishwasher leakage',
                'AC remote control not working',
                'Exhaust fan making noise'
            ],
            'Pest Control' => [
                'Ant infestation in kitchen',
                'Cockroach sighting in bathroom',
                'Rodent activity detected',
                'Termite inspection needed',
                'Spider infestation in corners',
                'General pest control treatment',
                'Mosquito problem near windows',
                'Bed bug inspection requested'
            ]
        ];

        return $problems[$category][array_rand($problems[$category])];
    }
}
