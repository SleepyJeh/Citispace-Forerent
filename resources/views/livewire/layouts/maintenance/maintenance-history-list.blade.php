<div class="bg-white rounded-2xl shadow-md h-full flex flex-col">
    {{-- Header / Filters --}}
    <div class="p-4 border-b border-gray-100 flex justify-between items-center flex-shrink-0">
        <h3 class="font-bold text-gray-800">Requests</h3>

        {{-- Status Filter (Only valid for Manager) --}}
        @if(property_exists($this, 'filter'))
            <select wire:model.live="filter" class="text-sm border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                <option value="all">All Status</option>
                <option value="Pending">Pending</option>
                <option value="Ongoing">Ongoing</option>
                <option value="Completed">Completed</option>
            </select>
        @endif
    </div>

    {{-- Scrollable List --}}
    <div class="overflow-y-auto flex-1 p-2 space-y-2 custom-scrollbar">
        @forelse($historyItems as $item)
            <div
                wire:key="history-{{ $item->request_id }}"
                wire:click="selectHistory({{ $item->request_id }})"
                class="p-4 rounded-xl cursor-pointer transition-all duration-200 border border-transparent hover:shadow-md
                {{ $activeHistoryId === $item->request_id ? 'bg-blue-50 border-blue-200 ring-1 ring-blue-300' : 'bg-gray-50 hover:bg-white hover:border-gray-200' }}"
            >
                <div class="flex justify-between items-start mb-2">
                    <span class="font-bold text-[#070642] text-sm">
                        {{ $item->ticket_number ?? 'TKT-'.$item->request_id }}
                    </span>
                    <span class="text-xs px-2 py-1 rounded-full font-medium
                        {{ $item->status === 'Completed' ? 'bg-green-100 text-green-700' :
                          ($item->status === 'Ongoing' ? 'bg-blue-100 text-blue-700' : 'bg-orange-100 text-orange-700') }}">
                        {{ $item->status }}
                    </span>
                </div>

                <p class="text-sm text-gray-600 line-clamp-2 mb-2">{{ $item->problem }}</p>

                <div class="flex justify-between items-center text-xs text-gray-500">
                    <span>
                        {{ \Carbon\Carbon::parse($item->created_at)->format('M d, Y') }}
                    </span>
                    {{-- Only show Tenant Name/Unit if the property exists (Manager View) --}}
                    @if(isset($item->tenant_name))
                        <span class="flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            {{ $item->tenant_name }}
                        </span>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-10 text-gray-400">
                <p>No maintenance requests found.</p>
            </div>
        @endforelse
    </div>
</div>
