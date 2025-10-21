{{--
    This component displays tenant and maintenance information in a tabbed layout.
    It requires the following variables to be passed from the parent component:
    - $unit: An array containing the unit's details, including 'current_tenant', 'past_tenants' and 'maintenance_requests'.
    - $activeTab: A string representing the currently active tab ('current' or 'past').
--}}

<div class="pt-6">
    {{-- Tab Navigation --}}
    <div class="w-full bg-gray-100 p-1.5 rounded-xl flex justify-center items-center gap-2 mb-6">
        <button wire:click="selectTab('current')"
            @class([ 'flex-1 text-center px-4 py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50'
            , 'bg-blue-600 text-white shadow-md'=> $activeTab === 'current',
            'bg-transparent text-gray-600 hover:bg-white' => $activeTab !== 'current',
            ])>
            Current Tenant
        </button>
        <button wire:click="selectTab('past')"
            @class([ 'flex-1 text-center px-4 py-2.5 text-sm font-semibold rounded-lg transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50'
            , 'bg-blue-600 text-white shadow-md'=> $activeTab === 'past',
            'bg-transparent text-gray-600 hover:bg-white' => $activeTab !== 'past',
            ])>
            Past Tenant
        </button>
    </div>

    <div>
        {{-- CURRENT TENANT TAB CONTENT --}}
        @if ($activeTab === 'current')
        <div>
            @if ($unit['current_tenant'])
            <div class="space-y-6">
                {{-- Tenant Information & Lease Card --}}
                <div class="bg-[#F4F7FC] rounded-xl p-5">
                    <h4 class="font-bold text-gray-700 mb-4">Tenant Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                        {{-- Tenant Details --}}
                        <div class="md:col-span-3 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                            <div>
                                <label class="text-xs text-gray-500">Tenant Name</label>
                                <p class="font-semibold text-gray-800">{{ $unit['current_tenant']['name'] }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Phone Number</label>
                                <p class="font-semibold text-gray-800">{{ $unit['current_tenant']['phone'] }}</p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Email</label>
                                <p class="font-semibold text-gray-800">{{ $unit['current_tenant']['email'] }}</p>
                            </div>
                        </div>

                        {{-- Lease Details --}}
                        <div class="md:col-span-3 border-t border-gray-200 mt-4 pt-4 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                            <div>
                                <label class="text-xs text-gray-500">Lease Start</label>
                                <p class="font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $unit['current_tenant']['lease_start'] }}
                                </p>
                            </div>
                            <div>
                                <label class="text-xs text-gray-500">Lease End</label>
                                <p class="font-semibold text-gray-800 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $unit['current_tenant']['lease_end'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Financials Card --}}
                <div class="bg-[#F4F7FC] rounded-xl p-5">
                    <h4 class="font-bold text-gray-700 mb-4">Tenant Information</h4> {{-- As per image --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-y-4 gap-x-6">
                        <div>
                            <label class="text-xs text-gray-500">Rental Price</label>
                            <p class="font-semibold text-gray-800">{{ $unit['current_tenant']['rental_price'] }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">Deposit</label>
                            <p class="font-semibold text-gray-800">{{ $unit['current_tenant']['deposit'] }}</p>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500">Status</label>
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-green-100 text-green-800 border border-green-300">
                                {{ $unit['current_tenant']['deposit_status'] }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Start Maintenance Request Container --}}
                <div class="bg-white rounded-xl p-5 shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h4 class="font-bold text-gray-800 text-xl">Maintenance Request</h4>

                        {{-- Dropdown Filter --}}
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="text-sm font-semibold text-white flex items-center gap-2 bg-[#0039C6] px-4 py-2 rounded-lg transition-colors hover:bg-[#002A8F] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0039C6]">
                                <span>{{ $this->getFilterDisplayName() }}</span>
                                <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 origin-top-right" style="display: none;">
                                <div class="py-1">
                                    <a href="#" wire:click.prevent="setMaintenanceFilter('pending')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">On Going</a>
                                    <a href="#" wire:click.prevent="setMaintenanceFilter('on hold')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">On Hold</a>
                                    <a href="#" wire:click.prevent="setMaintenanceFilter('completed')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Done</a>
                                    <div class="border-t border-gray-100 my-1"></div>
                                    <a href="#" wire:click.prevent="setMaintenanceFilter('all')" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Scrollable List of Requests --}}
                    <div class="space-y-3 max-h-[250px] overflow-y-auto custom-scrollbar pr-2">
                        @forelse ($this->filteredMaintenanceRequests as $request)
                        @php $colors = $this->getMaintenanceStatusColor($request['status']); @endphp
                        <div class="flex items-center gap-4 p-3.5 bg-white border border-gray-200 border-l-4 {{ $colors['border'] }} rounded-lg shadow-sm">
                            <div class="flex-shrink-0 {{ $colors['icon_color'] }}">
                                @if (strtolower($request['status']) === 'pending')
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                @elseif (strtolower($request['status']) === 'on hold')
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                                @elseif (strtolower($request['status']) === 'completed')
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                @endif
                            </div>
                            <div class="flex-grow">
                                <p class="font-semibold text-gray-800">{{ $request['description'] }}</p>
                                <p class="text-xs text-gray-500 flex items-center gap-1.5 mt-0.5">
                                    <svg class="w-3 h-3 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $request['date'] }}
                                </p>
                            </div>
                            {{-- Updated badge style to better match the screenshot --}}
                            <span class="text-xs font-semibold px-3 py-1 rounded-full {{ $colors['bg'] }} {{ $colors['text'] }}">
                                {{ $request['status'] }}
                            </span>
                        </div>
                        @empty
                        <div class="text-center py-8 px-4 bg-gray-50 rounded-lg">
                            <p class="text-gray-500">No maintenance requests match the current filter.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                {{-- End Maintenance Request Container --}}

                {{-- Add the custom scrollbar styles needed for this component --}}
                @push('styles')
                <style>
                    .custom-scrollbar::-webkit-scrollbar {
                        width: 6px;
                    }

                    .custom-scrollbar::-webkit-scrollbar-track {
                        background: transparent;
                    }

                    .custom-scrollbar::-webkit-scrollbar-thumb {
                        background: #0039C6;
                        border-radius: 10px;
                    }

                    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                        background: #002A8F;
                    }
                </style>
                @endpush
            </div>
            @else
            <div class="text-center py-10 px-4 bg-gray-50 rounded-lg">
                <p class="text-gray-500">This unit is currently vacant.</p>
            </div>
            @endif
        </div>
        @endif

        {{-- PAST TENANT TAB CONTENT --}}
        @if ($activeTab === 'past')
        <div>
            @if (!empty($unit['past_tenants']))
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                    <thead class="text-xs text-white uppercase bg-blue-600">
                        <tr>
                            <th scope="col" class="px-6 py-3">Tenant</th>
                            <th scope="col" class="px-6 py-3">Lease Start</th>
                            <th scope="col" class="px-6 py-3">Lease End</th>
                            <th scope="col" class="px-6 py-3">Lease Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($unit['past_tenants'] as $pastTenant)
                        <tr class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $pastTenant['name'] }}
                            </th>
                            <td class="px-6 py-4">{{ $pastTenant['lease_start'] }}</td>
                            <td class="px-6 py-4">{{ $pastTenant['lease_end'] }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full">
                                    {{ $pastTenant['lease_type'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-10 px-4 bg-gray-50 rounded-lg">
                <p class="text-gray-500">No past tenant information available for this unit.</p>
            </div>
            @endif
        </div>
        @endif
    </div>
</div>