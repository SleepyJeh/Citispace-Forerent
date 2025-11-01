@extends ('layouts.app')

@section('content')

<div class="flex flex-row h-screen overflow-hidden">
    <nav class="w-0 md:w-64 flex-shrink-0 h-full overflow-y-auto bg-white">
        @include('livewire.layouts.adminnav')
    </nav>

    <section id="main-container" class="flex-1 h-full flex flex-col overflow-hidden">

        <div class="flex-shrink-0 bg-white z-30">
            <livewire:layouts.top-bar />
        </div>

        <div class="flex-1 overflow-y-auto">
            <div id="pm-container" class="w-full min-h-full rounded-tl-4xl bg-[#F4F7FC] flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mt-6 mb-6">
                    <div class="flex flex-col">
                        <span id="main-header" class="header-title text-2xl md:text-3xl text-blue-900 font-bold">PROPERTY MANAGEMENT</span>
                        <span class="sub-header text-sm md:text-base text-gray-600">View and record property or unit</span>
                    </div>
                    <div>
                        <x-ui.button-add href="{{ url('/users/admin/add-unit') }}" text="Add Unit" />
                    </div>
                </div>

                <div id="main-layout-container" class="flex flex-col lg:flex-row gap-6 mb-8">

                    <div class="w-full lg:w-[70%] flex flex-col gap-8">

                        @include('livewire.layouts.admingreeting')

                        <div>
                            <span class="com-header text-lg md:text-xl text-blue-900 font-bold mb-4">BUILDINGS</span>
                            <div id="building-sort" class="flex gap-4 overflow-x-auto pb-4 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                                <livewire:layouts.Buildings
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                                <livewire:layouts.Buildings
                                    image="https://media.istockphoto.com/id/1467597986/photo/professionally-landscaped-garden-flower-bed.jpg?s=2048x2048&w=is&k=20&c=EkSeVR74NXBQAgY7xgrUt27JP1sIJk51L3vUKT7RmvQ="
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                                <livewire:layouts.Buildings
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                                <livewire:layouts.Buildings
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                                <livewire:layouts.Buildings
                                    title="Building 1"
                                    address="3360 Ibarra St., Palanan, Makati" />
                            </div>
                        </div>

                        <div class="w-full">
                            <livewire:layouts.unit-accordion />
                        </div>

                    </div>

                    <div class="w-full lg:w-[30%] flex-shrink-0">
                        <livewire:layouts.stats-sidebar />
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>

@endsection
