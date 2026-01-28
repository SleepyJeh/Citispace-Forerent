<div class="mt-6">
    <div class="flex items-center gap-2 mb-4">
        <svg class="w-5 h-5 text-[#2360E8]" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd"/>
        </svg>
        <h3 class="font-bold text-[#2360E8]">Selected Amenities</h3>
    </div>

    @if(count($amenities) > 0)
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
            @foreach($amenities as $amenity)
                <div class="bg-blue-100 text-blue-800 rounded-lg px-3 py-2">
                    <span class="text-sm font-medium">{{ $amenity }}</span>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-4 text-gray-500">
            <p>No amenities available for this unit</p>
        </div>
    @endif
</div>
