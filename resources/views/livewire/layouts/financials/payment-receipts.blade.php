<div>
    <div class="bg-[#070589] rounded-t-2xl p-6 relative shadow-lg">
        <div class="flex items-center space-x-8">
            <button wire:click="$set('activeTab', 'all')"
                class="pb-2 font-semibold transition-all duration-200 {{ $activeTab === 'all' ? 'text-white border-b-4 border-white' : 'text-gray-300 hover:text-white' }}">
                All {{ $allCount }}
            </button>

            <button wire:click="$set('activeTab', 'Upcoming')"
                class="pb-2 font-semibold transition-all duration-200 {{ $activeTab === 'Upcoming' ? 'text-white border-b-4 border-white' : 'text-gray-300 hover:text-white' }}">
                Upcoming {{ $upcomingCount }}
            </button>

            <button wire:click="$set('activeTab', 'Overdue')"
                class="pb-2 font-semibold transition-all duration-200 {{ $activeTab === 'Overdue' ? 'text-white border-b-4 border-white' : 'text-gray-300 hover:text-white' }}">
                Overdue {{ $overdueCount }}
            </button>

            <button wire:click="$set('activeTab', 'Paid')"
                class="pb-2 font-semibold transition-all duration-200 {{ $activeTab === 'Paid' ? 'text-white border-b-4 border-white' : 'text-gray-300 hover:text-white' }}">
                Paid {{ $paidCount }}
            </button>
        </div>
    </div>


    <div class="bg-white shadow-md p-6 rounded-b-2xl">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Unit Number</th>
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Tenant Name</th>
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Due Date</th>
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Period Covered</th>
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Total Amount</th>
                        <th class="text-left py-4 px-4 text-sm font-semibold text-gray-600">Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($billingHistory as $billing)
                        <tr wire:key="billing-{{ $billing['billing_id'] }}" class="border-b border-gray-100 hover:bg-blue-50 transition-colors">
                            <td class="py-4 px-4">
                                <span class="text-blue-700 font-semibold">{{ $billing['unit_number'] }}</span>
                            </td>
                            <td class="py-4 px-4 text-gray-700">{{ $billing['tenant_name'] }}</td>
                            <td class="py-4 px-4 text-gray-700">{{ \Carbon\Carbon::parse($billing['billing_date'])->format('F j, Y') }}</td>
                            <td class="py-4 px-4 text-gray-700">{{ $billing['period_covered'] }}</td>
                            <td class="py-4 px-4 text-gray-700 font-semibold">₱
                                {{ number_format($billing['amount']) }}</td>
                            <td class="py-4 px-4">

                                @if($billing['status'] === 'Annually')
                                    <span class="text-gray-700">{{ $billing['status'] }}</span>
                                @else
                                    <div x-data="{ open: false }" class="relative">
                                        <button @click="open = !open" class="bg-blue-800 text-white text-xs font-semibold py-1.5 px-3 rounded-lg w-28 flex items-center justify-between">
                                            <span>
                                                {{ $billing['status'] === 'Paid' ? 'Paid' : ($billing['status'] === 'Overdue' ? 'Overdue' : 'Upcoming') }}
                                            </span>
                                            <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                        </button>

                                        <div x-show="open"
                                             @click.away="open = false"
                                             x-transition
                                             class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-lg"
                                             style="display: none;">

                                            <a href="#" wire:click.prevent="setStatus({{ $billing['billing_id'] }}, 'Paid')" @click="open = false"
                                               class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                               Set as Paid
                                            </a>
                                            <a href="#" wire:click.prevent="setStatus({{ $billing['billing_id'] }}, 'Unpaid')" @click="open = false"
                                               class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                               Set as Upcoming
                                            </a>
                                            <a href="#" wire:click.prevent="setStatus({{ $billing['billing_id'] }}, 'Overdue')" @click="open = false"
                                               class="block px-3 py-2 text-xs text-gray-700 hover:bg-gray-100">
                                               Set as Overdue
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-500">
                                No records found for this status.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
