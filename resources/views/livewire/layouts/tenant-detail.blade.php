{{-- resources/views/livewire/layouts/tenant-detail.blade.php --}}

<div class="bg-white rounded-3xl shadow-lg p-6 flex flex-col h-full">
    @if($currentTenant)
        {{-- Tenant Information Header --}}
        <div class="mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">{{ $currentTenant['name'] }}</h1>
            <p class="text-gray-600 mb-1">{{ $currentTenant['contact_number'] }}</p>
            <p class="text-gray-600">{{ $currentTenant['email'] }}</p>
        </div>

        {{-- Current Unit and Bed Number --}}
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Current Unit</h3>
                <p class="text-lg font-semibold text-gray-900">{{ $currentTenant['unit'] }}</p>
            </div>
            <div>
                <h3 class="text-sm font-medium text-gray-500 mb-2">Bed Number</h3>
                <p class="text-lg font-semibold text-gray-900">{{ $currentTenant['bed_number'] }}</p>
            </div>
        </div>

        <div class="border-t border-gray-200 my-6"></div>

        {{-- Tenant Details Section --}}
        <div class="mb-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Tenant Information</h2>

            {{-- Current Location --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Current Location</h3>
                <p class="text-gray-600 mb-1">{{ $currentTenant['address'] }}</p>
                <p class="text-gray-600">{{ $currentTenant['building'] }}</p>
            </div>

            {{-- Contact Details --}}
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Contact Details</h3>
                <div class="space-y-2">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                        <p class="text-gray-900">{{ $currentTenant['contact_number'] }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <p class="text-gray-900">{{ $currentTenant['email'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 my-6"></div>

        {{-- Rent Details Section --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Rent Details</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bed Number</label>
                    <p class="text-gray-900">{{ $currentTenant['bed_number'] }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($currentTenant['lease_start_date'])->format('F j, Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Term</label>
                    <p class="text-gray-900">{{ $currentTenant['lease_term'] }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Auto Renew Contract</label>
                    <p class="text-gray-900">{{ $currentTenant['is_auto_renew'] ? 'Yes' : 'No' }}</p>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200 my-6"></div>

        {{-- Move In Details Section --}}
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Move In Details</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Move-in Date</label>
                    <p class="text-gray-900">{{ \Carbon\Carbon::parse($currentTenant['move_in_date'])->format('F j, Y') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Monthly Rate</label>
                    <p class="text-gray-900">P {{ number_format($currentTenant['monthly_rate'], 2) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Security Deposit</label>
                    <p class="text-gray-900">P {{ number_format($currentTenant['security_deposit'], 2) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $currentTenant['payment_status'] === 'Paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ $currentTenant['payment_status'] }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Action Buttons - Properly placed inside the card --}}
        <div class="flex space-x-4 pt-6 mt-8 border-t border-gray-200">
            <button class="flex-1 py-3 px-6 border border-gray-300 rounded-xl text-base font-medium text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                Transfer
            </button>
            <button class="flex-1 py-3 px-6 border border-red-300 rounded-xl text-base font-medium text-red-700 hover:bg-red-50 transition-colors duration-200">
                Move Out
            </button>
        </div>

    @else
        {{-- Empty State --}}
        <div class="flex items-center justify-center h-full">
            <div class="text-center max-w-md">
                {{-- User Icon --}}
                <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                    <svg class="w-12 h-12 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>

                {{-- Message --}}
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Tenant Selected</h3>
                <p class="text-gray-600 text-lg mb-6">
                    Please select a tenant from the sidebar to view their details, lease information, and manage their tenancy.
                </p>

                {{-- Pointer Arrow --}}
                <div class="flex items-center justify-center gap-2 text-blue-600">
                    <svg class="w-6 h-6 animate-bounce -rotate-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    <span class="font-medium">Select a tenant from the left</span>
                </div>
            </div>
        </div>
    @endif
</div>
