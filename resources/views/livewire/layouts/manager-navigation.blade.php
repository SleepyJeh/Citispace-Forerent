
<div class="w-full bg-white p-4 md:p-6 rounded-2xl shadow-md h-full flex flex-col">
    <h2 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">Property Manager</h2>

    {{-- Manager List Container --}}
    <div class="flex-1 overflow-y-auto custom-scrollbar px-2 space-y-3">

        {{-- Loop through the managers --}}
        @forelse ($managers as $manager)
        @php

        $baseClasses = 'w-full text-left font-semibold p-4 rounded-lg border-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400';

        $isActive = ($manager['user_id'] == $this->activeManagerId);


        if ($isActive) {

            $buttonClasses = 'bg-blue-600 text-white border-blue-600 shadow-lg';
        } else {

            $buttonClasses = 'bg-white text-gray-700 border-gray-200 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-500';
        }
        @endphp

        <button
            type="button"
            wire:click="selectManager({{ $manager['user_id'] }})"
            class="{{ $baseClasses }} {{ $buttonClasses }}">
            {{ $manager['first_name'] }} {{ $manager['last_name'] }}
        </button>
        @empty
        <p class="text-gray-500">No managers found.</p>
        @endforelse
    </div>

</div>

@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #0039C6;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #002A8F;
    }
</style>
@endpush
