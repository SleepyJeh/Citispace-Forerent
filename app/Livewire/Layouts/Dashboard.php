<?php

namespace App\Livewire\Layouts;

use App\Models\Announcement;
use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $selectedDate;
    public $currentMonth;
    public $currentYear;

    // Financial metrics (Landlord)
    public $totalRentCollected = 120000;
    public $totalUncollectedRent = 10000;
    public $totalIncome = 120000;

    public $revenueCurrentValue = 20000;
    public $revenueTargetValue = 80000;

    public $expensesCurrentValue = 20000;
    public $expensesTargetValue = 80000;

    public $roiCurrentValue = 22.3;
    public $roiTargetValue = 18.0;

    // Maintenance metrics (Manager)
    public $totalMaintenanceCost = 120000;
    public $newRequests = 3;
    public $pendingRequests = 3;

    public $userRole;

    protected $listeners = ['announcement-posted' => '$refresh'];

    public function mount()
    {
        $this->selectedDate = Carbon::today();
        $this->currentMonth = Carbon::now()->format('F Y');
        $this->currentYear = Carbon::now()->year;
        $this->userRole = auth()->user()->role;

        // Load role-specific data
        if ($this->userRole === 'landlord') {
            $this->loadFinancialData();
        } elseif ($this->userRole === 'manager') {
            $this->loadMaintenanceData();
        }
    }

    public function loadFinancialData()
    {
        // TODO: Replace with actual database queries
        // Example:
        // $this->totalRentCollected = Payment::whereMonth('created_at', now()->month)->sum('amount');
        // $this->totalUncollectedRent = Tenant::unpaid()->sum('rent_amount');
    }

    public function loadMaintenanceData()
    {
        $userId = auth()->id();

        // Base query: all maintenance requests for units managed by this manager
        $maintenanceQuery = \App\Models\MaintenanceRequest::query()
            ->join('leases', 'maintenance_requests.lease_id', '=', 'leases.lease_id')
            ->join('beds', 'leases.bed_id', '=', 'beds.bed_id')
            ->join('units', 'beds.unit_id', '=', 'units.unit_id')
            ->where('units.manager_id', $userId);

        // Total Maintenance Cost - This month
        $this->totalMaintenanceCost = \App\Models\MaintenanceLog::query()
            ->join('maintenance_requests', 'maintenance_logs.request_id', '=', 'maintenance_requests.request_id')
            ->join('leases', 'maintenance_requests.lease_id', '=', 'leases.lease_id')
            ->join('beds', 'leases.bed_id', '=', 'beds.bed_id')
            ->join('units', 'beds.unit_id', '=', 'units.unit_id')
            ->where('units.manager_id', $userId)
            ->whereMonth('maintenance_logs.completion_date', now()->month)
            ->whereYear('maintenance_logs.completion_date', now()->year)
            ->sum('maintenance_logs.cost');

        // New Requests - Status 'Pending' created this week
        $this->newRequests = (clone $maintenanceQuery)
            ->where('maintenance_requests.status', 'Pending')
            ->whereBetween('maintenance_requests.created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->count();

        // Pending Requests - Status 'Pending' or 'Ongoing' created this week
        $this->pendingRequests = (clone $maintenanceQuery)
            ->whereIn('maintenance_requests.status', ['Pending', 'Ongoing'])
            ->whereBetween('maintenance_requests.created_at', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ])
            ->count();
    }

    public function selectDate($date)
    {
        $this->selectedDate = Carbon::parse($date);
    }

    public function getAnnouncementsProperty()
    {
        $query = Announcement::query()
            ->leftJoin('properties', 'announcements.property_id', '=', 'properties.property_id')
            ->selectRaw('
                COALESCE(properties.building_name, "All Properties") as property,
                announcements.title,
                announcements.description,
                announcements.created_at
            ');

        if ($this->userRole === 'landlord') {
            // Landlord: Only announcements authored by them
            $query->where('announcements.author_id', auth()->id());
        } elseif ($this->userRole === 'manager') {
            // Manager: Announcements authored by them OR
            // announcements from their managed properties targeted at managers
            $query->where(function($q) {
                $q->where('announcements.author_id', auth()->id())
                    ->orWhere(function($subQuery) {
                        $subQuery->whereIn('announcements.property_id', function($propertyQuery) {
                            // Get properties where the manager has units
                            $propertyQuery->select('property_id')
                                ->from('units')
                                ->where('manager_id', auth()->id());
                        })
                            ->where('announcements.recipient_role', 'manager');
                    });
            });
        }

        return $query->orderByDesc('announcements.created_at')
            ->get()
            ->map(function ($announcement) {
                return [
                    'property' => $announcement->property,
                    'date' => Carbon::parse($announcement->created_at)->format('F j, Y'),
                    'title' => $announcement->title,
                    'description' => $announcement->description,
                ];
            });
    }

    public function getDailyEventsProperty()
    {
        $query = Announcement::query()
            ->leftJoin('properties', 'announcements.property_id', '=', 'properties.property_id')
            ->selectRaw('
                COALESCE(properties.building_name, "All Properties") as property,
                announcements.title,
                announcements.description,
                announcements.created_at
            ')
            ->whereDate('announcements.created_at', $this->selectedDate);

        if ($this->userRole === 'landlord') {
            // Landlord: Only announcements authored by them
            $query->where('announcements.author_id', auth()->id());
        } elseif ($this->userRole === 'manager') {
            // Manager: Announcements authored by them OR
            // announcements from their managed properties targeted at managers
            $query->where(function($q) {
                $q->where('announcements.author_id', auth()->id())
                    ->orWhere(function($subQuery) {
                        $subQuery->whereIn('announcements.property_id', function($propertyQuery) {
                            // Get properties where the manager has units
                            $propertyQuery->select('property_id')
                                ->from('units')
                                ->where('manager_id', auth()->id());
                        })
                            ->where('announcements.recipient_role', 'manager');
                    });
            });
        }

        return $query->orderByDesc('announcements.created_at')
            ->get()
            ->map(function ($announcement) {
                return [
                    'property' => $announcement->property,
                    'date' => Carbon::parse($announcement->created_at)->format('F j, Y'),
                    'title' => $announcement->title,
                    'description' => $announcement->description,
                ];
            });
    }

    public function getAnnouncementDaysProperty()
    {
        $query = Announcement::query()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);

        if ($this->userRole === 'landlord') {
            // Landlord: Only announcements authored by them
            $query->where('author_id', auth()->id());
        } elseif ($this->userRole === 'manager') {
            // Manager: Announcements authored by them OR
            // announcements from their managed properties targeted at managers
            $query->where(function($q) {
                $q->where('author_id', auth()->id())
                    ->orWhere(function($subQuery) {
                        $subQuery->whereIn('property_id', function($propertyQuery) {
                            // Get properties where the manager has units
                            $propertyQuery->select('property_id')
                                ->from('units')
                                ->where('manager_id', auth()->id());
                        })
                            ->where('recipient_role', 'manager');
                    });
            });
        }

        return $query->selectRaw('DATE(created_at) as date')
            ->pluck('date')
            ->map(fn($date) => Carbon::parse($date)->day)
            ->toArray();
    }

    public function getCalendarDaysProperty()
    {
        $startOfMonth = Carbon::parse($this->currentMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($this->currentMonth)->endOfMonth();

        $startDay = $startOfMonth->dayOfWeek;
        $daysInMonth = $endOfMonth->day;

        $days = [];

        // Add empty cells for days before month starts
        for ($i = 0; $i < $startDay; $i++) {
            $days[] = null;
        }

        // Add actual days
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $days[] = $day;
        }

        return $days;
    }

    public function calculatePercentage($current, $target)
    {
        if ($target == 0) return 0;
        return round(($current / $target) * 100);
    }

    public function render()
    {
        $data = [];

        // Only calculate financial percentages for landlords
        if ($this->userRole === 'landlord') {
            $data = [
                'revenuePercentage' => $this->calculatePercentage($this->revenueCurrentValue, $this->revenueTargetValue),
                'expensesPercentage' => $this->calculatePercentage($this->expensesCurrentValue, $this->expensesTargetValue),
                'roiPercentage' => round(($this->roiCurrentValue / $this->roiTargetValue) * 100),
            ];
        }

        return view('livewire.layouts.dashboard-components', $data);
    }
}
