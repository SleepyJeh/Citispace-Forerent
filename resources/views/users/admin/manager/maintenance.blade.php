@extends('layouts.app')

@section('header-title', 'MAINTENANCE MANAGEMENT')
@section('header-subtitle', 'Monitor costs, track trends, and manage repair tickets')

@section('content')

    {{-- 1. Greeting & Context --}}
    @include('livewire.layouts.dashboard.admingreeting')

    {{-- MAIN CONTAINER --}}
    <div class="space-y-6 mt-6">


            <div class="xl:col-span-2">
                <livewire:layouts.maintenance.projected-maintenance-cost />
            </div>

        </div>


        <div class="flex flex-col lg:flex-row gap-6 h-[750px]">

             <div class="w-full lg:w-1/3 h-full overflow-hidden">
                <livewire:layouts.maintenance.manager-maintenance-list />
            </div>

             <div class="w-full lg:w-2/3 h-full overflow-hidden">
                <livewire:layouts.maintenance.manager-maintenance-detail />
            </div>

        </div>

    </div>

@endsection
