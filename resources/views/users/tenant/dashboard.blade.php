@extends('layouts.app')

@section('header-title', 'DASHBOARD')
@section('header-subtitle', 'View a summary of all key property and account information')

@section('content')


    @include('livewire.layouts.dashboard.admingreeting')
    <livewire:layouts.dashboard.announcement-list :is-landlord="true" />
    <livewire:layouts.dashboard.calendar-widget />


@endsection
