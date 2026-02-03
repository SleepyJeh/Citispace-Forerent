<div class="h-full bg-white rounded-3xl shadow-lg flex flex-col overflow-hidden relative">

    @if($unit)
        {{-- 1. Blue Header Banner --}}
        <div class="bg-[#2B66F5] p-6 text-white flex justify-between items-start">
            <div>
                <p class="text-sm opacity-90 mb-1">{{ $unit['building'] }} - {{ $unit['floor'] }}</p>
                <h1 class="text-3xl font-bold mb-1">{{ $unit['name'] }}</h1>
                <p class="text-xs opacity-75 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9z"/></svg>
                    {{ $unit['address'] }}
                </p>
            </div>

            <div class="bg-pink-100 text-red-500 px-4 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider">
                {{ $unit['status'] }}
            </div>
        </div>

        {{-- Content Area --}}
        <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">

            {{-- Unit Specs Table --}}

        <div class="mb-8">
            <h3 class="text-[#2B66F5] font-bold text-lg mb-4">Maintenance Details</h3>

            {{-- CHANGED: Removed 'overflow-x-auto' and 'min-w-max'. Added 'table-fixed' --}}
            <div class="rounded-xl overflow-hidden border border-gray-100">
                <table class="w-full text-xs lg:text-sm text-left table-fixed">
                    <thead class="bg-[#263093] text-white">
                        <tr>
                            {{-- Manually defining headers to control width if needed, or keeping loop --}}
                            @foreach(array_keys($unit['specs']) as $label)
                                <th class="px-2 py-3 font-medium break-words align-top">
                                    {{ $label }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr>
                            @foreach($unit['specs'] as $value)
                                <td class="px-2 py-4 text-[#263093] font-semibold border-b border-gray-100 break-words align-top">
                                    {{ $value }}
                                    @if($loop->iteration == 6) {{-- Under "Occupied Unit" --}}
                                        <div class="text-[10px] text-blue-400 font-normal mt-0.5">All Female</div>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

            {{-- Bed Section --}}
            <div>
                <h3 class="text-[#2B66F5] font-bold text-lg mb-4">Bed Number</h3>

                <div class="flex gap-6 border-b border-gray-200 mb-6">
                    @foreach($beds as $index => $bed)
                        @php $num = $index + 1; @endphp
                        <button
                            wire:click="selectBed({{ $num }})"
                            class="pb-2 px-2 text-lg font-bold transition-all relative
                            {{ $activeBedNum === $num ? 'text-[#2B66F5]' : 'text-gray-400 hover:text-gray-600' }}">
                            {{ $num }}

                            @if($activeBedNum === $num)
                                <div class="absolute bottom-0 left-0 w-full h-1 bg-[#2B66F5] rounded-t-full"></div>
                            @endif
                        </button>
                    @endforeach
                </div>

                {{-- Tenant Table --}}
                <div class="rounded-xl overflow-hidden border border-gray-100 shadow-sm">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-[#263093] text-white">
                            <tr>
                                <th class="px-6 py-3 font-medium">Tenant</th>
                                <th class="px-6 py-3 font-medium">Lease Start</th>
                                <th class="px-6 py-3 font-medium">Lease End</th>
                                <th class="px-6 py-3 font-medium">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <tr>
                                <td class="px-6 py-4 font-bold text-[#070642]">{{ $selectedBedData['Tenant'] ?? '-' }}</td>
                                <td class="px-6 py-4 text-[#070642]">{{ $selectedBedData['Lease Start'] ?? '-' }}</td>
                                <td class="px-6 py-4 text-[#070642]">{{ $selectedBedData['Lease End'] ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-xs font-bold">
                                        {{ $selectedBedData['Status'] ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Current Issue Context --}}
                @if($ticket)
                <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                    <h4 class="text-xs font-bold text-gray-500 uppercase mb-2">Reported Issue</h4>
                    <p class="text-gray-800">{{ $ticket->problem }}</p>
                </div>
                @endif
            </div>

        </div>
    @else
        {{-- Empty State --}}
        <div class="flex flex-col items-center justify-center h-full text-gray-400">
            <svg class="w-16 h-16 mb-4 opacity-20" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a8 8 0 100 16 8 8 0 000-16zm0 14a6 6 0 110-12 6 6 0 010 12z"/></svg>
            <p>Select a maintenance request from the left to view unit details.</p>
        </div>
    @endif
</div>
