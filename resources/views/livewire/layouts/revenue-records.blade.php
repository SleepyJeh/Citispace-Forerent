<div>
    @php
        // We define the options here to easily loop over them for the custom dropdown
        // and to get the correct display label for the selected value.
        $monthOptions = [
            'january' => 'January',
            'february' => 'February',
            'march' => 'March',
            'april' => 'April',
            'may' => 'May',
            'june' => 'June',
            'july' => 'July',
            'august' => 'August',
            'september' => 'September',
            'october' => 'October',
            'november' => 'November',
            'december' => 'December',
        ];
        $buildingOptions = [
            'building1' => 'Building 1',
            'building2' => 'Building 2',
            'building3' => 'Building 3',
        ];
    @endphp

    {{-- Filters (Moved and Resized) --}}
   <div class="flex justify-end gap-4 mb-4">

        <div x-data="{ open: false }" class="relative w-48"> {{-- Increased width with w-48 --}}
            <button @click="open = !open"
                class="flex items-center justify-between w-full bg-blue-600 text-white rounded-lg px-4 py-2 border-0 focus:ring-2 focus:ring-blue-500 font-medium text-sm transition-all duration-150">
                <span>{{ $monthOptions[$selectedMonth] ?? 'Select Month' }}</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-white transition-transform duration-200"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute z-10 w-full mt-1 bg-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                @foreach ($monthOptions as $value => $label)
                    <div wire:click.prevent="$set('selectedMonth', '{{ $value }}')" @click="open = false"
                        class="px-4 py-3 hover:bg-blue-700 cursor-pointer text-sm {{ $selectedMonth === $value ? 'bg-blue-700 font-semibold' : '' }}">
                        {{ $label }}
                    </div>
                @endforeach
            </div>
        </div>

        <div x-data="{ open: false }" class="relative w-48"> {{-- Increased width with w-48 --}}
            <button @click="open = !open"
                class="flex items-center justify-between w-full bg-blue-600 text-white rounded-lg px-4 py-2 border-0 focus:ring-2 focus:ring-blue-500 font-medium text-sm transition-all duration-150">
                <span>{{ $buildingOptions[$selectedBuilding] ?? 'Select Building' }}</span>
                <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-white transition-transform duration-200"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                </svg>
            </button>
            <div x-show="open" @click.away="open = false" x-transition
                class="absolute z-10 w-full mt-1 bg-blue-600 text-white rounded-lg shadow-lg overflow-hidden">
                @foreach ($buildingOptions as $value => $label)
                    <div wire:click.prevent="$set('selectedBuilding', '{{ $value }}')" @click="open = false"
                        class="px-4 py-3 hover:bg-blue-700 cursor-pointer text-sm {{ $selectedBuilding === $value ? 'bg-blue-700 font-semibold' : '' }}">
                        {{ $label }}
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Tab Navigation --}}
   <div>
        <div class="flex gap-2 bg-white rounded-t-xl shadow-md overflow-hidden">
            <button wire:click="$set('activeTab', 'payment')"
                class="flex-1 px-6 py-4 font-semibold transition-all duration-200 {{ $activeTab === 'payment' ? 'bg-blue-600 text-white rounded-t-xl' : 'text-gray-600 hover:bg-gray-50' }}">
                Payment History
            </button>
            <button wire:click="$set('activeTab', 'maintenance')"
                class="flex-1 px-6 py-4 font-semibold transition-all duration-200 {{ $activeTab === 'maintenance' ? 'bg-blue-600 text-white rounded-t-xl' : 'text-gray-600 hover:bg-gray-50' }}">
                Total Maintenance History
            </button>
        </div>
    </div>

    {{-- Tab Content --}}
    <div class="bg-white  shadow-md p-6">
        {{-- Filters (REMOVED FROM HERE) --}}

        {{-- Payment History Table --}}
        @if ($activeTab === 'payment')
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Unit Number</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Tenant Name</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Payment Date</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Period Covered</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Monthly Rent</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Lease Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($paymentHistory as $payment)
                            <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                                <td class="py-4 px-4">
                                    <span class="text-blue-700 font-semibold">{{ $payment['unit'] }}</span>
                                </td>
                                <td class="py-4 px-4 text-gray-700">{{ $payment['tenant'] }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $payment['payment_date'] }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $payment['period'] }}</td>
                                <td class="py-4 px-4 text-gray-700 font-semibold">₱
                                    {{ number_format($payment['rent']) }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $payment['lease_type'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- Maintenance History Table --}}
        @if ($activeTab === 'maintenance')
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b-2 border-gray-200">
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Unit Number</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Tenant Name</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Maintenance Date</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Service Provider</th>
                            <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($maintenanceHistory as $maintenance)
                            <tr class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                                <td class="py-4 px-4">
                                    <span class="text-blue-700 font-semibold">{{ $maintenance['unit'] }}</span>
                                </td>
                                <td class="py-4 px-4 text-gray-700">{{ $maintenance['tenant'] }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $maintenance['maintenance_date'] }}</td>
                                <td class="py-4 px-4 text-gray-700">{{ $maintenance['service_provider'] }}</td>
                                <td class="py-4 px-4 text-gray-700 font-semibold">₱
                                    {{ number_format($maintenance['cost']) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
