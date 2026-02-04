<div class="h-full flex flex-col">
    @if($ticket)
        @php
             $statusStyles = match($ticket->status) {
                'Completed', 'Resolved' => 'bg-green-100 text-green-700',
                'Pending' => 'bg-orange-100 text-orange-700',
                'In Progress', 'Ongoing' => 'bg-yellow-100 text-yellow-800',
                default => 'bg-gray-100 text-gray-700'
            };
        @endphp

        {{-- Header Section --}}
        <div class="p-6 border-b border-gray-100 flex-shrink-0">
            <div class="flex justify-between items-start mb-2">
                <h2 class="text-2xl font-bold text-[#070642]">{{ $ticketIdDisplay }}</h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $statusStyles }}">
                    {{ $ticket->status }}
                </span>
            </div>
            <p class="text-gray-500 text-sm">
                Submitted on {{ \Carbon\Carbon::parse($ticket->created_at)->format('F d, Y \a\t h:i A') }}
            </p>
        </div>

        {{-- Scrollable Content --}}
        <div class="flex-1 overflow-y-auto p-6 space-y-8 custom-scrollbar">

            {{-- Issue Details --}}
            <div>
                <h3 class="text-lg font-bold text-[#070642] mb-4">Issue Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-xl">
                        <p class="text-gray-400 text-xs uppercase font-semibold mb-1">Category</p>
                        {{-- Placeholder: Replace with actual category if you have it --}}
                        <p class="text-[#070642] font-medium">General Maintenance</p>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-xl">
                         <p class="text-gray-400 text-xs uppercase font-semibold mb-1">Priority</p>
                        <p class="text-[#070642] font-medium capitalize">{{ $ticket->urgency }}</p>
                    </div>
                </div>
            </div>

             {{-- Description --}}
             <div>
                <h3 class="text-lg font-bold text-[#070642] mb-4">Description</h3>
                <div class="bg-gray-50 p-5 rounded-xl text-gray-700 leading-relaxed">
                    {{ $ticket->problem }}
                </div>
            </div>

            {{-- Updates Timeline (Matches Mockup Visuals) --}}
            <div>
                <h3 class="text-lg font-bold text-[#070642] mb-4">Updates</h3>
                <div class="space-y-4 pl-2">

                    {{-- Mockup Data representing the timeline in the image --}}
                    {{-- In the future, you would loop through real updates from the DB here --}}

                    {{-- Timeline Item 1 (Latest) --}}
                    <div class="flex gap-4 relative">
                        {{-- Line --}}
                        <div class="absolute left-[9px] top-8 bottom-[-16px] w-[2px] bg-gray-200"></div>
                        {{-- Dot --}}
                        <div class="flex-shrink-0 w-5 h-5 rounded-full bg-[#2B66F5] border-2 border-white shadow-sm z-10 mt-1"></div>
                        <div>
                            <p class="font-semibold text-[#070642]">Technician assigned</p>
                            <p class="text-sm text-gray-500 mb-1">{{ \Carbon\Carbon::parse($ticket->created_at)->addHours(2)->format('M d, h:i A') }}</p>
                            <p class="text-gray-600 bg-white border border-gray-100 p-3 rounded-lg text-sm">
                                A technician has been dispatched to check the issue.
                            </p>
                        </div>
                    </div>

                     {{-- Timeline Item 2 (Earliest) --}}
                     <div class="flex gap-4 relative">
                        {{-- Dot --}}
                        <div class="flex-shrink-0 w-5 h-5 rounded-full bg-gray-300 border-2 border-white shadow-sm z-10 mt-1"></div>
                        <div>
                            <p class="font-semibold text-[#070642]">Request received</p>
                            <p class="text-sm text-gray-500 mb-1">{{ \Carbon\Carbon::parse($ticket->created_at)->format('M d, h:i A') }}</p>
                            <p class="text-gray-600 text-sm">
                                Your maintenance request has been submitted successfully.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

        </div>

    @else
        {{-- Empty State (Matches Image) --}}
        <div class="flex-1 flex flex-col items-center justify-center text-gray-400 p-6">
            <div class="bg-gray-100 p-6 rounded-full mb-4 opacity-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-1">No Ticket Selected</h3>
            <p>Select a maintenance request to view details.</p>
        </div>
    @endif
</div>
