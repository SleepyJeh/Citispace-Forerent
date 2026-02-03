<div class="h-full flex flex-col">
    {{-- Scrollable Area --}}
    <div class="flex-1 overflow-y-auto p-4 space-y-3 custom-scrollbar">
        @forelse($requests as $req)
            @php
                $isActive = $activeRequestId === $req->request_id;

                $statusStyles = match($req->status) {
                    'Completed', 'Resolved' => 'bg-green-100 text-green-700',
                    'Pending' => 'bg-orange-100 text-orange-700',
                    'In Progress', 'Ongoing' => 'bg-yellow-100 text-yellow-800',
                    default => 'bg-gray-100 text-gray-700'
                };

                $ticketId = $req->ticket_number ?? 'TKT-'.str_pad($req->request_id, 4, '0', STR_PAD_LEFT);
            @endphp

            <div
                wire:click="selectRequest({{ $req->request_id }})"
                class="cursor-pointer p-4 rounded-xl border transition-all duration-200 group bg-white
                {{ $isActive
                    ? 'border-[#2B66F5] shadow-sm'
                    : 'border-gray-100 hover:border-blue-200 hover:shadow-sm'
                }}"
            >
                {{-- Top Row: ID, Date, Status --}}
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-[#2B66F5]">{{ $ticketId }}</h3>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ \Carbon\Carbon::parse($req->created_at)->format('M d, Y') }}
                        </p>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusStyles }}">
                        {{ $req->status }}
                    </span>
                </div>

                {{-- Category/Priority --}}
                <h4 class="font-semibold text-[#070642] mb-1">
                    {{ ucfirst($req->urgency) }} Priority Issue
                </h4>

                {{-- Description Preview --}}
                <p class="text-sm text-gray-500 line-clamp-2">
                    {{ $req->problem }}
                </p>
            </div>
        @empty
            {{-- Empty State --}}
             <div class="flex flex-col items-center justify-center h-full text-gray-400 py-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 opacity-30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <p>No requests found.</p>
            </div>
        @endforelse
    </div>
</div>
