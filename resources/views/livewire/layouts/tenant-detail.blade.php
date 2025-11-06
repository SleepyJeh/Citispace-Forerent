<div class="bg-white rounded-3xl shadow-lg p-6 flex flex-col h-auto">
    @if($currentTenant && $lease)
        {{-- Tenant Information Header --}}
        <div class="bg-blue-600 text-white p-6 rounded-2xl mb-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Tenant Information</h3>
                <span class="text-sm bg-white/20 px-3 py-1 rounded-full">Unit {{ $currentUnit ?? 'N/A' }}</span>
            </div>
            <h2 class="text-2xl font-bold">{{ $currentTenant->first_name }} {{ $currentTenant->last_name }}</h2>

            {{-- Building / Floor / Address Info --}}
            <div class="flex flex-col gap-1 mt-2 text-white/90">
                <div class="flex items-center gap-2">
                    {{-- Building Icon --}}
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M3 22V2h18v20H3zm2-2h14V4H5v16zM7 6h2v2H7V6zm0 4h2v2H7v-2zm0 4h2v2H7v-2zm4-8h2v2h-2V6zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2zm4-8h2v2h-2V6zm0 4h2v2h-2v-2zm0 4h2v2h-2v-2z"/>
                    </svg>
                    {{ $currentBuilding ?? 'N/A' }} - Floor {{ $currentFloor ?? 'N/A' }}
                </div>
                <div class="flex items-center gap-2">
                    {{-- Location / Address Icon --}}
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5S10.62 6.5 12 6.5s2.5 1.12 2.5 2.5S13.38 11.5 12 11.5z"/>
                    </svg>
                    {{ $currentAddress ?? 'N/A' }}
                </div>
            </div>
        </div>

        {{-- Contact Details --}}
        <div class="mb-6 bg-gray-50 p-4 rounded-xl">
            <h4 class="text-base font-bold text-gray-900 mb-3">Contact Details</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Contact Number</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $currentTenant->contact }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Email</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $currentTenant->email }}</p>
                </div>
            </div>
        </div>

        {{-- Rent Details --}}
        <div class="mb-6 bg-gray-50 p-4 rounded-xl">
            <h4 class="text-base font-bold text-gray-900 mb-3">Rent Details</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Bed Number</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $currentBed ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Dorm Type</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $dormType }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Start Date</p>
                    <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($lease->start_date)->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">End Date</p>
                    <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($lease->end_date)->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Term</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $lease->term }} {{ $lease->term > 1 ? 'Months' : 'Month' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Shift</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $lease->shift }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Auto Renew Contract</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $lease->auto_renew ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>

        {{-- Move In Details --}}
        <div class="mb-6 bg-gray-50 p-4 rounded-xl">
            <h4 class="text-base font-bold text-gray-900 mb-3">Move In Details</h4>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500 mb-1">Move-In Date</p>
                    <p class="text-sm font-semibold text-gray-900">{{ \Carbon\Carbon::parse($lease->move_in)->format('F j, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Monthly Rate</p>
                    <p class="text-sm font-semibold text-gray-900">₱ {{ number_format($lease->contract_rate, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Security Deposit</p>
                    <p class="text-sm font-semibold text-gray-900">₱ {{ number_format($lease->security_deposit, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 mb-1">Payment Status</p>
                    <p class="text-sm font-semibold text-gray-900">{{ $lease->payment_status ?? 'Unpaid' }}</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="flex gap-3 mt-auto pt-4">
            <button
                type="button"
                wire:click="transfer"
                class="flex-1 bg-blue-600 text-white font-semibold py-3 rounded-xl hover:bg-blue-700 transition-colors">
                Transfer
            </button>
            <button
                type="button"
                wire:click="moveOut"
                class="flex-1 bg-indigo-900 text-white font-semibold py-3 rounded-xl hover:bg-indigo-800 transition-colors">
                Move Out
            </button>
        </div>

        {{-- Include the modals --}}
        <livewire:layouts.move-out-tenant-modal />
        <livewire:layouts.transfer-tenant-modal :tenant-id="$currentTenantId"/>

    @elseif($currentTenant && !$lease)
        {{-- Tenant selected but no active lease --}}
        <div class="flex items-center justify-center h-full">
            <div class="text-center max-w-md">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-yellow-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Active Lease Found</h3>
                <p class="text-gray-600 text-lg mb-2">{{ $currentTenant->first_name }} {{ $currentTenant->last_name }} does not have an active lease.</p>
                <p class="text-gray-500 text-sm">Please check if the tenant has an expired lease or create a new one.</p>
            </div>
        </div>
    @else
        {{-- Empty State --}}
        <div class="flex items-center justify-center h-full">
            <div class="text-center max-w-md">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Tenant Selected</h3>
                <p class="text-gray-600 text-lg mb-6">Please select a tenant from the sidebar to view their details and lease information.</p>
            </div>
        </div>
    @endif

</div>
