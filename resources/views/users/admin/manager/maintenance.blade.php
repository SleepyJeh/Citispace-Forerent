@extends('layouts.app')

@section('header-title', 'MAINTENANCE')
@section('header-subtitle', 'Track and manage property maintenance')

@section('content')
<div class="space-y-6">

    {{-- 1. Top Section: Projected Maintenance Cost & Prediction Chart --}}
    {{-- This loads the blade you provided: projected-maintenance-cost.blade.php --}}
    <livewire:layouts.maintenance.projected-maintenance-cost />

    {{-- 2. Bottom Section: Maintenance History --}}
    <div class="flex flex-col h-[800px]"> {{-- Fixed height ensures the scrollbars in children work --}}

        <h2 class="text-xl font-bold text-slate-800 mb-4">Maintenance History</h2>

        {{-- The Master-Detail Layout Wrapper --}}
        <div class="flex flex-col lg:flex-row gap-6 h-full">

            {{-- Left Column: History List (30% width) --}}
            <div class="w-full lg:w-1/3 h-full overflow-hidden">
                <livewire:layouts.maintenance.maintenance-history-list />
            </div>

            {{-- Right Column: Details Panel (70% width) --}}
            <div class="w-full lg:w-2/3 h-full overflow-hidden">
                <livewire:layouts.maintenance.maintenance-history-detail />
            </div>

        </div>
    </div>
</div>
@endsection
