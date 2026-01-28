<div>
    {{-- Header with Title and Add Button --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-bold text-gray-900">{{ $title }}</h3>

        @if($showAddButton)
            <button
                type="button"
                onclick="Livewire.dispatch('{{ $addButtonEvent }}')"
                class="py-2 px-4 text-sm font-medium text-white bg-[#2360E8] rounded-lg hover:bg-[#1d4eb8] transition-colors">
                + Add Property
            </button>
        @endif
    </div>

    {{-- Building Cards Horizontal Scroll --}}
    <div class="flex gap-4 overflow-x-auto pb-4 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
        @forelse ($properties as $property)
            <div wire:key="building-{{ $property->property_id }}"
                 class="cursor-pointer transition-transform hover:scale-105"
                 onclick="Livewire.dispatch('buildingSelected', { buildingId: {{ $property->property_id }} })">
                <livewire:layouts.properties.buildings
                    :property="$property"
                    :key="'card-'.$property->property_id"
                />
            </div>
        @empty
            {{-- Empty State --}}
            <div class="w-full flex flex-col items-center justify-center text-center p-16 border-2 border-dashed border-gray-300 rounded-lg bg-white">
                <svg class="w-16 h-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="text-xl font-semibold text-gray-700">{{ $emptyStateTitle }}</h3>
                <p class="text-gray-500 mt-2">{{ $emptyStateDescription }}</p>

                @if($showAddButton)
                    <button
                        type="button"
                        onclick="Livewire.dispatch('{{ $addButtonEvent }}')"
                        class="mt-4 py-2 px-6 text-sm font-medium text-white bg-[#2360E8] rounded-lg hover:bg-[#1d4eb8] transition-colors">
                        Add Your First Property
                    </button>
                @endif
            </div>
        @endforelse
    </div>
</div>
