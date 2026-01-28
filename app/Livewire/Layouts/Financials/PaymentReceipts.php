<?php

namespace App\Livewire\Layouts\Financials;
use Livewire\Component;

class PaymentReceipts extends Component
{
    public $activeTab = 'all'; // Default tab
    public $allBillingHistory = []; // Public property to hold data

    // Private method to get the initial data
    private function getFullBillingHistory()
    {
        return [
            [
                'billing_id' => 1,
                'lease_id' => 101,
                'billing_date' => '2025-01-28',
                'next_billing' => '2025-02-28',
                'amount' => 24000.00,
                'status' => 'Paid',
                'tenant_name' => 'Adam Candelaria',
                'unit_number' => 'Unit 103',
                'period_covered' => 'January 2025',
            ],
            [
                'billing_id' => 2,
                'lease_id' => 102,
                'billing_date' => '2025-01-28',
                'next_billing' => '2025-02-28',
                'amount' => 24000.00,
                'status' => 'Overdue',
                'tenant_name' => 'Adam Candelaria',
                'unit_number' => 'Unit 103',
                'period_covered' => 'January 2025',
            ],
            [
                'billing_id' => 3,
                'lease_id' => 103,
                'billing_date' => '2025-01-28',
                'next_billing' => '2025-02-28',
                'amount' => 24000.00,
                'status' => 'Unpaid',
                'tenant_name' => 'Adam Candelaria',
                'unit_number' => 'Unit 103',
                'period_covered' => 'January 2025',
            ],
            [
                'billing_id' => 4,
                'lease_id' => 104,
                'billing_date' => '2025-01-28',
                'next_billing' => '2026-01-28',
                'amount' => 24000.00,
                'status' => 'Unpaid', // UPDATED: Changed from 'Annually'
                'tenant_name' => 'Adam Candelaria',
                'unit_number' => 'Unit 103',
                'period_covered' => 'January 2025',
            ],
        ];
    }

    // Load data into the public property when component mounts
    public function mount()
    {
        $this->allBillingHistory = $this->getFullBillingHistory();
    }

    // Action to update the status
    public function setStatus($billingId, $newStatus)
    {
        // Find and update the item in the public array
        foreach ($this->allBillingHistory as $key => $billing) {
            if ($billing['billing_id'] == $billingId) {
                $this->allBillingHistory[$key]['status'] = $newStatus;
                break; // Stop the loop once found and updated
            }
        }
    }

    public function render()
    {
        $allData = $this->allBillingHistory; // Use the public property

        // Calculate counts
        $upcomingCount = count(array_filter($allData, fn($item) => $item['status'] === 'Unpaid'));
        $overdueCount = count(array_filter($allData, fn($item) => $item['status'] === 'Overdue'));
        $paidCount = count(array_filter($allData, fn($item) => $item['status'] === 'Paid'));
        $allCount = count($allData);

        // Filter data based on active tab
        $filteredData = $allData;
        if ($this->activeTab === 'Upcoming') {
            $filteredData = array_filter($allData, fn($item) => $item['status'] === 'Unpaid');
        } elseif ($this->activeTab === 'Overdue') {
            $filteredData = array_filter($allData, fn($item) => $item['status'] === 'Overdue');
        } elseif ($this->activeTab === 'Paid') {
            $filteredData = array_filter($allData, fn($item) => $item['status'] === 'Paid');
        }

        return view('livewire.layouts.financials.payment-receipts', [
            'billingHistory' => $filteredData,
            'allCount' => $allCount,
            'upcomingCount' => $upcomingCount,
            'overdueCount' => $overdueCount,
            'paidCount' => $paidCount,
        ]);
    }
}
