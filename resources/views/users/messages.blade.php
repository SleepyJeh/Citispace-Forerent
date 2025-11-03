@extends ('layouts.app')

@section('content')
<div class="flex flex-row min-h-screen">
    <!-- Navigations -->
    <livewire:navbars.side-bar />

    <section id="main-container" class="flex-1 h-screen flex flex-col overflow-hidden">
        <div class="flex-shrink-0 bg-white z-30">
            <livewire:layouts.top-bar />
        </div>

        <div class="flex-1 overflow-y-auto min-h-full">
            <div id="pm-container" class="w-full h-full rounded-tl-4xl bg-[#F4F7FC] flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16">
                <div class="p-8 font-body">

                    <div class="mb-8">
                        <h1 class="text-2xl font-semibold text-primary mb-1">MESSAGE</h1>
                        <p class="text-gray-600 text-sm">View and send messages</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
