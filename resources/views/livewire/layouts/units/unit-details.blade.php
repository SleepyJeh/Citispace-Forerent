
<div class="bg-white rounded-2xl shadow-md h-full flex flex-col">
    @if ($unit)

    <div class="bg-blue-600 text-white p-4 md:p-6 rounded-t-2xl">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
            <div>
                <p class="text-xs md:text-sm opacity-80">{{ $unit['building'] }}</p>
                <h1 class="text-2xl md:text-3xl font-bold">{{ $unit['unit_number'] }}</h1>
                <div class="flex items-center gap-2 mt-1">
                    <svg class="h-4 w-4 opacity-80" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.1.4-.22.655-.365A15.8 15.8 0 0013 17.65l.003-.001c.645-.378 1.268-.826 1.84-1.33C16.48 14.978 17 13.796 17 12.5c0-1.25-.5-2.45-1.35-3.39C14.8 8.16 13.5 7.5 12 7.5c-1.5 0-2.8.66-3.65 1.61C7.5 10.05 7 11.25 7 12.5c0 1.296.52 2.478 1.16 3.32.572.504 1.195.952 1.84 1.33l.003.001a15.8 15.8 0 001.342.635c.255.145.47.265.655.365a5.741 5.741 0 00.28.14l.018.008.006.003zM10 11a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-xs md:text-sm opacity-80">{{ $unit['address'] }}</p>
                </div>
            </div>
            {{-- Right Side: Status Pill --}}
            <div class="text-right">
                <span class="{{ $this->getStatusColor($unit['status']) }} text-white text-xs md:text-sm font-semibold px-4 py-1.5 rounded-full whitespace-nowrap">
                    {{ $unit['status'] }}
                </span>
                <p class="text-xs text-white/90 mt-1.5">{{ $unit['status_details'] }}</p>
            </div>
        </div>
    </div>


    <div class="p-4 md:p-6 space-y-6 flex-1 overflow-y-auto">

        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="text-blue-600">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                </div>
                <h3 class="font-bold text-gray-800 text-lg">Unit Specifications</h3>
            </div>

            {{-- New 2x3 Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">

                {{-- Loop through the specifications data from the component --}}
                @foreach ($unit['specifications'] as $spec)
                <div class="bg-[#F4F7FC] rounded-lg p-3.5 flex items-center gap-3">
                    <div class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                            {!! $spec['icon'] !!}
                        </svg>
                    </div>
                    <div>
                        <span class="font-bold text-gray-800 text-lg">{{ $spec['value'] }}</span>
                        <p class="text-gray-600 text-sm">{{ $spec['label'] }}</p>
                    </div>
                </div>
                @endforeach

            </div>
        </div>

        {{--
          MODIFIED:
          Removed the @include for 'tenant-information-tab' as it's not
          in the new design.
        --}}

    </div>
    @else
    {{-- Fallback if no unit is selected --}}
    <div class="p-6 text-center text-gray-500 flex-1 flex items-center justify-center">
        <p>Select a unit to see its details.</p>
    </div>
    @endif
</div>
