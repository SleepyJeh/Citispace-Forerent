@extends('layouts.app')

@section('header-title', 'PROPERTY MANAGER')
@section('header-subtitle', 'View and record property or unit')

@section('content')

    {{-- Admin Greeting --}}
    @include('livewire.layouts.dashboard.admingreeting')

    {{-- Success Message --}}
    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    {{-- Manager Details Content --}}
    <div id="units-container" class="flex flex-col lg:flex-row gap-6 h-full">

        {{-- Sidebar List --}}
        <div id="unit-navigation-sidebar" class="w-full lg:w-[30%] flex-shrink-0 h-[750px]">
            <livewire:layouts.managers.manager-navigation />
        </div>

        {{-- Detail Card --}}
        <div id="unit-detail-card" class="w-full lg:w-[70%] h-[750px]">
            <livewire:layouts.managers.manager-detail />
        </div>
    </div>

    {{-- Modals --}}
    <livewire:layouts.managers.add-manager-modal modal-id="manager-dashboard" />

@endsection
