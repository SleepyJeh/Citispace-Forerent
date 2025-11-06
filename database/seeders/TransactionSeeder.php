<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    public function run()
    {
        $transactions = [];

        // Generate 2 years of transaction data
        $startDate = Carbon::create(2021, 1, 1);
        $endDate = Carbon::now();

        $categories = ['Rent Payment', 'Deposit', 'Advance', 'Maintenance', 'Vendor Payment'];
        
        $currentDate = $startDate->copy();
        $transactionId = 1;

        while ($currentDate <= $endDate) {
            // Generate 20-50 transactions per month
            $transactionsPerMonth = rand(20, 50);
            
            for ($i = 0; $i < $transactionsPerMonth; $i++) {
                $category = $categories[array_rand($categories)];
                
                // Set amount ranges based on category
                switch ($category) {
                    case 'Rent Payment':
                        $amount = rand(500000, 1200000) / 100; // ₱5,000 - ₱12,000
                        $type = 'Credit';
                        break;
                    case 'Deposit':
                        $amount = rand(500000, 1000000) / 100; // ₱5,000 - ₱12,000
                        $type = 'Credit';
                        break;
                    case 'Advance':
                        $amount = rand(1000000, 2000000) / 100; // ₱10,000 - ₱20,000
                        $type = 'Credit';
                        break;
                    case 'Maintenance':
                        $amount = rand(60000, 1500000) / 100; // ₱600 - ₱8,000
                        $type = 'Debit';
                        break;
                    case 'Vendor Payment':
                        $amount = rand(30000, 1000000) / 100; // ₱300 - ₱10000
                        $type = 'Debit';
                        break;
                }

                $transactions[] = [
                    'transaction_id' => $transactionId,
                    'billing_id' => null, // Can be linked later if needed
                    'name' => "Transaction {$transactionId}",
                    'reference_number' => $this->generateReferenceNumber($category, $currentDate, $transactionId),
                    'transaction_type' => $type,
                    'category' => $category,
                    'transaction_date' => $currentDate->copy()->addDays(rand(0, 27))->format('Y-m-d'),
                    'amount' => $amount,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $transactionId++;
            }

            $currentDate->addMonth();
        }

        // Insert in chunks to avoid memory issues
        foreach (array_chunk($transactions, 1000) as $chunk) {
            Transaction::insert($chunk);
        }
    }

    private function generateReferenceNumber($category, $date, $id)
    {
        $prefixes = [
            'Rent Payment' => 'RENT',
            'Deposit' => 'DEP',
            'Advance' => 'ADV',
            'Maintenance' => 'MNT',
            'Vendor Payment' => 'VEND'
        ];

        $prefix = $prefixes[$category] ?? 'TXN';
        return $prefix . $date->format('Ymd') . str_pad($id, 6, '0', STR_PAD_LEFT);
    }
}