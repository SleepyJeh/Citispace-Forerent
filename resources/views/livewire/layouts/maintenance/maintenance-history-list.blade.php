{{-- resources/views/livewire/layouts/maintenance-history-list.blade.php --}}

<div class="w-full bg-white p-4 md:p-6 rounded-2xl shadow-md h-full flex flex-col">

    {{-- History List Container --}}
    <div class="flex-1 overflow-y-auto custom-scrollbar px-2 space-y-3">

        {{-- Loop through the history items --}}
        @forelse ($historyItems as $item)
            @php
                $baseClasses = 'w-full text-left font-semibold p-4 rounded-lg border-2 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400';

                $isActive = ($item['request_id'] == $activeHistoryId);

                if ($isActive) {
                    $buttonClasses = 'bg-blue-600 text-white border-blue-600 shadow-lg';
                } else {
                    $buttonClasses = 'bg-white text-gray-700 border-gray-200 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-500';
                }
            @endphp

            <button
                type="button"
                wire:click="selectHistory({{ $item['request_id'] }})"
                class="{{ $baseClasses }} {{ $buttonClasses }}"
            >
                <div class="flex justify-between items-start">
                    <div class="flex-1 text-left">
                        <h4 class="font-semibold text-base mb-1">{{ $item['tenant_name'] }}</h4>
                        <p class="text-sm opacity-90">{{ $item['unit_number'] }}</p>
                    </div>

                    {{-- Status Badge --}}
                    <div class="flex-shrink-0 ml-2">
                        @if($item['status'] === 'Completed')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Completed
                            </span>
                        @elseif($item['status'] === 'Ongoing')
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                In Progress
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Pending
                            </span>
                        @endif
                    </div>
                </div>
            </button>
        @empty
            <div class="text-center py-8">
                <p class="text-gray-500 mb-4">No maintenance history found for this status.</p>
            </div>
        @endempty
    </div>
</div>

{{-- This component shares the same custom scrollbar style as tenant-navigation --}}
@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1ff;
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
