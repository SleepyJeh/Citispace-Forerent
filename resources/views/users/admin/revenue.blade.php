@extends ('components.layouts.app')

@section('content')
<div class=" flex flex-row">
    <!-- Navigation -->
    <nav class=" w-0 md:w-60">
        @include('components.layouts.adminnav')
    </nav>

    <section class=" flex-1 mt-8 ml-4 min-h-screen">
        <div class=" w-full h-full pl-12 pr-18 pt-6 rounded-tl-4xl bg-gray-200 flex flex-col gap-4">
            <div class=" flex flex-col">
                <span class=" font-extrabold text-2xl text-blue-900">REVENUE</span>
                <span>View and record property or unit</span>
            </div>
            @include('components.layouts.admingreeting')
            <div class=" flex flex-row gap-2 w-full">
                <div class=" flex-1">
                    <livewire:Card1
                        title="Total Income"
                        value="₱ 120,000"
                        subtitle="4% higher from last month" />
                </div>
                <div class=" flex-1">
                    <livewire:Card1
<<<<<<< HEAD
                    bgColor="bg-red-900"
                    title="Total Expenses"
                    value="₱ 120,000"
                    subtitle="4% higher from last month" />
=======
                        title="Total Expenses"
                        value="₱ 120,000"
                        subtitle="4% higher from last month" />
>>>>>>> 8841e49e0510e642e4989bfe31c8a855a81a5a5e
                </div>
                <div class=" flex-1">
                    <livewire:Card1
                        title="Net Operating Income"
                        value="₱ 120,000"
                        subtitle="4% higher from last month" />
                </div>
            </div>
            <div>
                <!-- display chart here -->
            </div>
        </div>
    </section>
</div>