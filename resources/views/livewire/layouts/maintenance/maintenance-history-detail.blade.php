{{-- resources/views/livewire/layouts/maintenance-history-detail.blade.php --}}

<div class="bg-white rounded-3xl shadow-lg flex flex-col h-full overflow-hidden">
    @if($currentHistoryItem)
        {{-- Wrapper for the "content" state --}}
        <div class="flex flex-col h-full">

            {{-- 1. Fixed Header Card (`flex-shrink-0`) --}}
            <div class="flex-shrink-0 bg-blue-600 text-white p-6 rounded-t-3xl shadow-md z-10">

                {{-- Title --}}
                <div class="flex items-center gap-2 mb-4">

                    <h4 class="font-bold text-xl">History Details</h4>
                </div>

                {{-- Main Info --}}
                <div class="flex justify-between items-start">
                    {{-- Left: Tenant Name and Building --}}
                    <div>
                        <h3 class="font-bold text-3xl mb-2">{{ $currentHistoryItem['tenant_name'] }}</h3>
                        <div class="flex flex-col gap-1.5">
                            <span class="flex items-center gap-2 text-sm text-white/90">
                                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                </svg>
                                {{ $currentHistoryItem['building_name'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Right: Unit and Request ID --}}
                    <div class="flex-shrink-0 flex flex-col items-end space-y-2">
                        <span class="bg-white text-blue-700 text-sm font-semibold px-4 py-1.5 rounded-full">
                            {{ $currentHistoryItem['unit_number'] }}
                        </span>
                        <span class="text-xs text-white/80 font-medium pr-1">
                            Request ID: #{{ $currentHistoryItem['request_id'] }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- 2. Scrollable Content Area (`flex-1 overflow-y-auto`) --}}
            <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-4 bg-gray-50">

                {{-- Helper function for label-value pairs --}}
                @php
                $detailItem = function($label, $value, $statusClass = '') {
                    $valueClass = 'text-gray-900';
                    if ($statusClass) { $valueClass = $statusClass; }
                    if (is_null($value) || $value === '') { $value = 'N/A'; $valueClass = 'text-gray-400'; }
                    return '
                        <div>
                            <label class="block text-sm font-medium text-gray-500">'.$label.'</label>
                            <p class="text-base font-semibold ' . $valueClass . '">'.$value.'</p>
                        </div>
                    ';
                };

                $statusDisplay = [
                    'Pending' => ['text' => 'Pending', 'class' => 'text-yellow-600'],
                    'Ongoing' => ['text' => 'In Progress', 'class' => 'text-blue-600'],
                    'Completed' => ['text' => 'Completed', 'class' => 'text-green-600'],
                ];
                $statusInfo = $statusDisplay[$currentHistoryItem['status']] ?? ['text' => $currentHistoryItem['status'], 'class' => 'text-gray-900'];

                @endphp

                {{-- Request Details Card --}}
                <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h5 class="font-bold text-lg text-gray-900 mb-4">Task Details</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        {!! $detailItem('Status', $statusInfo['text'], $statusInfo['class']) !!}
                        {!! $detailItem('Urgency', $currentHistoryItem['urgency']) !!}
                        {!! $detailItem('Date Logged', \Carbon\Carbon::parse($currentHistoryItem['log_date'])->format('F j, Y')) !!}
                        {!! $detailItem('Logged By', $currentHistoryItem['logged_by']) !!}
                        {!! $detailItem('Ticket Number', $currentHistoryItem['ticket_number']) !!}
                        {!! $detailItem('Contact Number', $currentHistoryItem['contact_number']) !!}
                    </div>
                </div>

                {{-- Description Card --}}
                <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h5 class="font-bold text-lg text-gray-900 mb-4">Problem Description</h5>
                    <p class="text-gray-700 leading-relaxed">
                        {{ $currentHistoryItem['problem'] }}
                    </p>
                </div>

                {{-- Log Details (Only shows if 'Completed') --}}
                @if($currentHistoryItem['status'] === 'Completed')
                <div class="bg-white rounded-lg border border-gray-200 p-5 shadow-sm">
                    <h5 class="font-bold text-lg text-gray-900 mb-4">Log Details</h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-4">
                        {!! $detailItem('Completion Date', \Carbon\Carbon::parse($currentHistoryItem['completion_date'])->format('F j, Y')) !!}
                        {!! $detailItem('Cost', 'P ' . number_format($currentHistoryItem['cost'], 2)) !!}
                    </div>
                </div>
                @endif


                {{-- 3. Action Buttons --}}
                <div class="flex space-x-3 pt-4">
                    {{-- Only show 'Mark In Progress' if status is 'Pending' --}}
                    @if($currentHistoryItem['status'] === 'Pending')
                    <button
                        type="button"
                        wire:click="markInProgress"
                        class="flex-1 py-3 px-4 rounded-lg font-semibold text-white bg-[#1080FC] hover:bg-[#0e74e3] transition-colors focus:outline-none focus:ring-2 focus:ring-[#1080FC] focus:ring-offset-2"
                    >
                        Mark In Progress
                    </button>
                    @endif

                    {{-- Only show 'Move to Completed' if status is 'Ongoing' --}}
                    @if($currentHistoryItem['status'] === 'Ongoing')
                    <button
                        type="button"
                        wire:click="markCompleted"
                        class="flex-1 py-3 px-4 rounded-lg font-semibold text-white bg-[#070589] hover:bg-[#05046a] transition-colors focus:outline-none focus:ring-2 focus:ring-[#070589] focus:ring-offset-2"
                    >
                        Move to Completed
                    </button>
                    @endif
                </div>

            </div>
        </div>
    @else
        {{-- Empty State (Unchanged) --}}
        <div class="flex items-center justify-center h-full">
            <div class="text-center max-w-md p-6">
                <div class="inline-flex items-center justify-center w-24 h-24 bg-blue-100 rounded-full mb-6">
                    
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No History Item Selected</h3>
                <p class="text-gray-600 text-lg mb-6">
                    Please select a maintenance history item from the list to view its details, status, and assigned personnel.
                </p>
                <div class="flex items-center justify-center gap-2 text-blue-600">
                    <svg class="w-6 h-6 animate-bounce -rotate-90" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12" />
                    </svg>
                    <span class="font-medium">Select an item from the left</span>
                </div>
            </div>
        </div>
    @endif
</div>

{{-- Custom Scrollbar Styles (Unchanged) --}}
@push('styles')
<style>
    .custom-scrollbar::-webkit-scrollbar { width: 8px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #0039C6; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #002A8F; }
</style>
@endpush
