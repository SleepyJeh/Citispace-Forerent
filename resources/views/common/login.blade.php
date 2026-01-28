@extends('layouts.guest')
@section('content')
<div class="flex min-h-screen bg-white relative z-50">

    {{-- Left Side: Login Form --}}
    <div class="w-full md:w-1/2 flex flex-1 flex-col justify-center p-8 sm:p-12 bg-white">
        <livewire:actions.login-form />
    </div>

    {{-- Right Side: Image/Pattern --}}
    <div class="hidden md:flex md:w-1/2 justify-center items-center bg-blue-50 relative overflow-hidden">
        <div class="w-full h-full p-12">
            <svg class="w-full h-full" viewBox="0 0 1409 918" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect width="1409" height="918" fill="#F4F7FC"/>
                <path d="M52.5666 71.1602L69.1707 83.4063L69.1707 110.519L54.0836 110.519C54.0836 110.519 47.0824 110.519 46.2091 94.6596C45.7564 86.4386 52.5666 71.1602 52.5666 71.1602Z" fill="#001C64"/>
            </svg>
        </div>
    </div>

</div>
@endsection
