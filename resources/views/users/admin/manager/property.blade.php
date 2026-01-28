@extends('layouts.app')

@section('header-title', 'PROPERTY')
@section('header-subtitle', 'Centralized rental property management overview')

@section('content')

    @include('livewire.layouts.dashboard.admingreeting')

   
    <livewire:layouts.properties.building-cards-section
        :show-add-button="true"
        title="Buildings"
    />

    <div class="mt-6">
        <livewire:layouts.units.unit-accordion />
    </div>

@endsection
