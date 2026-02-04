<div class="h-full"> {{-- This wrapper ensures the component fills the parent height --}}

    <x-ui.list-view
        title="Maintenance History"
        :tabs="['all' => 'All', 'open' => 'Open', 'pending' => 'Pending', 'closed' => 'Closed']"
        :activeTab="$activeTab"
        :counts="$counts"
    >
        {{-- LIST ITEMS --}}
        @forelse($requests as $req)
            @php
                $isActive = $activeRequestId === $req->request_id;
            @endphp

            <div
                wire:click="selectRequest({{ $req->request_id }})"
                class="group cursor-pointer rounded-xl p-4 border transition-all duration-200 relative overflow-hidden
                {{ $isActive
                    ? 'bg-[#2B66F5] border-[#2B66F5] shadow-md'
                    : 'bg-white border-gray-100 hover:border-blue-300 hover:shadow-sm'
                }}"
            >
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        {{-- Tenant Name --}}
                        <p class="text-xs font-bold uppercase tracking-wide mb-1
                            {{ $isActive ? 'text-blue-200' : 'text-gray-400' }}">
                            {{ $req->tenant_name ?? 'Unknown Tenant' }}
                        </p>

                        {{-- Unit Number --}}
                        <h3 class="text-lg font-extrabold
                            {{ $isActive ? 'text-white' : 'text-[#070642] group-hover:text-[#2B66F5]' }}">
                            Unit {{ $req->unit_number }}
                        </h3>
                    </div>

                    {{-- Status Dot --}}
                    @php
                        $statusColor = match($req->status) {
                            'Ongoing' => 'bg-blue-400',
                            'Pending' => 'bg-orange-400',
                            'Completed' => 'bg-green-400',
                            default => 'bg-gray-300'
                        };
                    @endphp
                    <span class="w-2.5 h-2.5 rounded-full {{ $statusColor }} {{ $isActive ? 'ring-2 ring-white/30' : '' }}"></span>
                </div>

                {{-- Decorative background shape for active state --}}
                @if($isActive)
                    <div class="absolute right-0 bottom-0 opacity-10">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="white"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
                    </div>
                @endif
            </div>

        @empty
            <div class="flex flex-col items-center justify-center h-full py-10 text-gray-400">
                <svg class="w-12 h-12 mb-3 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/><path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/></svg>
                <p class="text-sm">No tickets found</p>
            </div>
        @endforelse

    </x-ui.list-view>
</div>
