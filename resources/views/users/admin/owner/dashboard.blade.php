@extends ('layouts.app')

@section('content')

<div class="flex flex-row h-screen overflow-hidden">
    <nav class="w-0 md:w-64 flex-shrink-0 h-full overflow-y-auto bg-white">
        <livewire:navbars.side-bar />
    </nav>

    <section id="main-container" class="flex-1 h-full flex flex-col overflow-hidden">
        <div class="flex-shrink-0 bg-white z-30">
            <livewire:layouts.top-bar />
        </div>

        <div class="flex-1 overflow-y-auto ml-8">
            <div id="manager-container" class="w-full min-h-full rounded-tl-4xl bg-[#F4F7FC] flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16 gap-6">

                {{-- Header Section --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-col">
                        <span id="main-header" class="header-title text-2xl md:text-3xl text-blue-900 font-bold">DASHBOARD</span>
                        <span class="sub-header text-sm md:text-base text-gray-600">Centralized rental property management overview</span>
                    </div>
                </div>

                {{-- Admin Greeting --}}
                @include('livewire.layouts.admingreeting')

                {{-- Success Message --}}
                @if (session()->has('message'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                {{-- Dashboard Component --}}
                <livewire:layouts.dashboard />

            </div>
        </div>
    </section>
</div>

@endsection
