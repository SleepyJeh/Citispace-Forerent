@extends('layouts.app')

@section('header-title', 'PAYMENT DOCUMENTATION')
@section('header-subtitle', 'Rental payment record')

@section('content')

    @include('livewire.layouts.dashboard.admingreeting')

    {{--  Payment Component --}}
    <livewire:layouts.financials.payment-receipts />

@endsection
