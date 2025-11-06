@extends ('layouts.app')

@section('content')

<div class="flex flex-row h-screen overflow-hidden">
    <livewire:navbars.side-bar />

    <section id="main-container" class="flex-1 h-full flex flex-col overflow-hidden">
        <div class="flex-shrink-0 bg-white z-30">
            <livewire:layouts.top-bar />
        </div>

        <div class="flex-1 overflow-y-auto ml-8">
            <div id="REVENUE-container" class="w-full min-h-full rounded-tl-4xl bg-[#F4F7FC] flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16 gap-6">

                {{-- Success Message Flash --}}
                @if (session()->has('message'))
                    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg relative" role="alert">
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                {{-- Revenue Container Component --}}
                <livewire:layouts.revenue-container />
                <livewire:layouts.revenue-forecast />
                <livewire:layouts.maint-forecast />
            </div>
        </div>
    </section>
</div>

<livewire:layouts.add-manager-modal modal-id="manager-dashboard" />

@endsection
