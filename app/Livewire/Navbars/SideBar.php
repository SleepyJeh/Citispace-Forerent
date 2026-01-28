<?php

namespace App\Livewire\Navbars;

use App\Enums\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SideBar extends Component
{
    public $navigations = [];
    public $sidebarOpen = true;

    public function mount()
    {
        $user = Auth::user();

        // FIX: Handle Guest/Not Logged In State
        // If there is no user, we provide a default 'dashboard' key to prevent the view from crashing.
        if (!$user) {
            $this->navigations = [
                'dashboard' => [
                    'label' => 'Login',
                    'route' => 'login', // Ensure this route exists in your web.php
                    'icon'  => 'icons.dashboard',
                ]
            ];
            return;
        }

        // Logic for Logged In Users
        switch ($user->role) {
            case Role::Landlord->value:
                $this->navigations = [
                    'dashboard' => [
                        'label' => 'Dashboard',
                        'route' => 'landlord.dashboard',
                        'icon'  => 'icons.dashboard',
                    ],
                    'properties' => [
                        'label' => 'Properties',
                        'route' => 'landlord.property',
                        'icon'  => 'icons.property',
                    ],
                    'manager' => [
                        'label' => 'Managers',
                        'route' => 'landlord.manager',
                        'icon'  => 'icons.property',
                    ],
                    'revenue' => [
                        'label' => 'Revenue',
                        'icon'  => 'icons.revenue',
                        'route' => 'landlord.revenue',
                        'children' => [
                            [
                                'label' => 'Reports',
                                'query' => ['view' => 'reports'],
                            ],
                            [
                                'label' => 'Records',
                                'query' => ['view' => 'records'],
                            ],
                        ],
                    ],
                    'messages' => [
                        'label' => 'Messages',
                        'route' => 'message',
                        'icon'  => 'icons.messages',
                    ],
                ];
                break;

            case 'tenant':
                $this->navigations = [
                    'dashboard' => [
                        'label' => 'Dashboard',
                        'route' => 'tenant.dashboard',
                        'icon' => 'icons.dashboard',
                    ],
                    'payments' => [
                        'label' => 'Payments',
                        'route' => 'tenant.payment',
                        'icon' => 'icons.payments',
                    ],
                    'maintenance' => [
                        'label' => 'Maintenance',
                        'route' => 'tenant.maintenance',
                        'icon' => 'icons.maintenance',
                    ],
                    'messages' => [
                        'label' => 'Messages',
                        'route' => 'message',
                        'icon' => 'icons.messages',
                    ],
                ];
                break;

            case 'manager':
                $this->navigations = [
                    'dashboard' => [
                        'label' => 'Dashboard',
                        'route' => 'manager.dashboard',
                        'icon'  => 'icons.dashboard',
                    ],
                    'properties' => [
                        'label' => 'Properties',
                        'route' => 'manager.property',
                        'icon'  => 'icons.property',
                    ],
                    'tenants' => [
                        'label' => 'Managers',
                        'route' => 'manager.tenant',
                        'icon'  => 'icons.property',
                    ],
                    'payments' => [
                        'label' => 'Payments',
                        'route' => 'manager.payment',
                        'icon'  => 'icons.payments',
                    ],
                    'maintenance' => [
                        'label' => 'Maintenance',
                        'route' => 'manager.maintenance',
                        'icon'  => 'icons.maintenance',
                    ],
                    'messages' => [
                        'label' => 'Messages',
                        'route' => 'message',
                        'icon'  => 'icons.messages',
                    ],
                ];
                break;

            // Optional: Add a default case if the role doesn't match any known roles
            default:
                $this->navigations = [
                    'dashboard' => [
                        'label' => 'Dashboard',
                        'route' => 'dashboard', // Fallback route
                        'icon'  => 'icons.dashboard',
                    ]
                ];
                break;
        }
    }

    public function getActiveClass($routeName)
    {
        return request()->routeIs($routeName)
            ? 'bg-[#DFE8FC] text-[#070642]'
            : 'text-gray-700 hover:bg-[#DFE8FC] hover:text-[#070642]';
    }

    public function render()
    {
        return view('livewire.navbars.side-bar');
    }
}
