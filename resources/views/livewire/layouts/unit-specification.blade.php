{{-- MODIFIED: Removed overflow-hidden, added h-full and flex flex-col --}}
<div class="bg-white rounded-2xl shadow-md h-full flex flex-col">
    @if ($unit)
    {{-- Unit Header (This will be fixed at the top) --}}
    {{-- MODIFIED: Added rounded-t-2xl to match parent card rounding --}}
    <div class="bg-blue-600 text-white p-4 md:p-6 rounded-t-2xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
            <div>
                <p class="text-xs md:text-sm opacity-80">{{ $unit['building'] }}</p>
                <h1 class="text-2xl md:text-3xl font-bold">{{ $unit['unit_number'] }}</h1>
                <p class="text-xs md:text-sm opacity-80 mt-1">{{ $unit['address'] }}</p>
            </div>
            <span class="{{ $this->getStatusColor($unit['status']) }} text-white text-xs md:text-sm font-semibold px-4 py-1.5 rounded-full whitespace-nowrap">
                {{ $unit['status'] }}
            </span>
        </div>
    </div>

    {{-- Main Content Area (This will be scrollable) --}}
    <div class="p-4 md:p-6 space-y-6 flex-1 overflow-y-auto">

        {{-- Unit Specifications Section --}}
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="text-blue-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-lg">Unit Specifications</h3>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                {{-- Guests --}}
                <div class="bg-[#F4F7FC] rounded-lg p-3.5 flex items-center gap-3">
                    <div class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-gray-800 text-lg">{{ $unit['specifications']['guests'] }}</span>
                        <p class="text-gray-600 text-sm">Guest</p>
                    </div>
                </div>
                {{-- Bedroom --}}
                <div class="bg-[#F4F7FC] rounded-lg p-3.5 flex items-center gap-3">
                    <div class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21.5 10.5c-.83 0-1.5.67-1.5 1.5v2c0 .55-.45 1-1 1h-1V9c0-1.1-.9-2-2-2h-7c-.55 0-1 .45-1 1s.45 1 1 1h7v2.5c0 .83-.67 1.5-1.5 1.5S13 13.83 13 13V9c0-2.21-1.79-4-4-4S5 6.79 5 9v4H4c-.55 0-1-.45-1-1v-2c0-.83-.67-1.5-1.5-1.5S0 11.17 0 12v5h24v-5c0-.83-.67-1.5-1.5-1.5z" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-gray-800 text-lg">{{ $unit['specifications']['bedroom'] }}</span>
                        <p class="text-gray-600 text-sm">Bedroom</p>
                    </div>
                </div>
                {{-- Restroom --}}
                <div class="bg-[#F4F7FC] rounded-lg p-3.5 flex items-center gap-3">
                    <div class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M22 10.5c-.83 0-1.5.67-1.5 1.5v3c0 .55-.45 1-1 1h-1.56c-.36-2.56-2.53-4.5-5.19-4.5s-4.83 1.94-5.19 4.5H4c-.55 0-1-.45-1-1v-3c0-.83-.67-1.5-1.5-1.5S0 11.17 0 12v5h24v-5c0-.83-.67-1.5-1.5-1.5zM7.25 7.5c.97 0 1.75-.78 1.75-1.75S8.22 4 7.25 4 5.5 4.78 5.5 5.75 6.28 7.5 7.25 7.5zm-2 2h4c1.1 0 2 .9 2 2v1H3.25v-1c0-1.1.9-2 2-2z" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-gray-800 text-lg">{{ $unit['specifications']['restroom'] }}</span>
                        <p class="text-gray-600 text-sm">Restroom</p>
                    </div>
                </div>
                {{-- Kitchen --}}
                <div class="bg-[#F4F7FC] rounded-lg p-3.5 flex items-center gap-3">
                    <div class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18 2.01 6 2c-1.1 0-2 .89-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.11-.9-1.99-2-1.99zM18 20H6v-9.02h12V20zm0-11H6V4h12v5zM8 5h2v3H8zm0 7h2v5H8z" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-gray-800 text-lg">{{ $unit['specifications']['kitchen'] }}</span>
                        <p class="text-gray-600 text-sm">Kitchen</p>
                    </div>
                </div>
                {{-- Area --}}
                <div class="bg-[#F4F7FC] rounded-lg p-3.5 flex items-center gap-3">
                    <div class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M21 6H3v2.53c.8-.51 1.7-.8 2.65-.82 2.14-.07 4.14.74 5.65 2.22 1.39 1.36 2.33 3.01 2.7 4.8H3v2h11.1c-.01.07-.02.13-.02.2 0 2.29 1.21 4.36 3.09 5.54C19.09 21.43 21 19.9 21 18c0-1.04-.5-1.98-1.28-2.62.6-.46 1.09-1.07 1.38-1.78.43-1.04.42-2.22 0-3.26-.52-1.25-1.52-2.23-2.76-2.7C17.65 7.28 16.88 7 16 7c-.68 0-1.33.12-1.95.34.8-.56 1.48-1.2 2.02-1.95.17-.23.42-.39.7-.49zM5.5 13c.83 0 1.5-.67 1.5-1.5S6.33 10 5.5 10s-1.5.67-1.5 1.5.67 1.5 1.5 1.5z" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-gray-800 text-lg">{{ $unit['specifications']['area'] }}</span>
                        <p class="text-gray-600 text-sm">Sqm</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tenant Information and Tabs --}}
        @include('livewire.layouts.tenant-information-tab', [
        'unit' => $unit,
        'activeTab' => $activeTab
        ])

    </div>
    @else
    {{-- MODIFIED: Added flex classes to center the text vertically --}}
    <div class="p-6 text-center text-gray-500 flex-1 flex items-center justify-center">
        <p>Select a unit to see its details.</p>
    </div>
    @endif
</div>