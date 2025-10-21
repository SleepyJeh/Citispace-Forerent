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

                @include('livewire.layouts.admingreeting')

                <span class="com-header text-lg md:text-xl text-blue-900 font-bold mb-4">BUILDINGS</span>

                <div id="building-sort" class="flex gap-4 overflow-x-auto pb-4 mb-8 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
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
                    <livewire:layouts.Buildings
                        title="Building 1"
                        address="3360 Ibarra St., Palanan, Makati" />
                    <livewire:layouts.Buildings
                        title="Building 1"
                        address="3360 Ibarra St., Palanan, Makati" />
                </div>

                <div id="units-container" class="flex flex-col lg:flex-row gap-6 mb-8">
                    {{-- MODIFIED: Added h-[750px] --}}
                    <div id="unit-navigation-sidebar" class="w-full lg:w-[30%] flex-shrink-0 h-[750px]">
                        <livewire:layouts.unit-navigation />
                    </div>

                    {{-- MODIFIED: Added h-[750px] --}}
                    <div id="unit-detail-card" class="w-full lg:w-[70%] h-[750px]">
                        <livewire:layouts.unit-detail />
                    </div>
                </div>

                <div id="list-container" class="relative w-full max-w-[65%]" x-data="{
                    activeTab: 'vacant',
                    currentPage: 1,
                    itemsPerPage: 3,
                    get totalPages() {
                        return 3;
                    }
                }">
                    <div id="whole-list" class="flex relative z-10 mb-[-30px]">
                        <button
                            id="vacant-sort"
                            @click="activeTab = 'vacant'; currentPage = 1;"
                            :class="activeTab === 'vacant' ? 'bg-[#003CC1] text-white' : 'bg-transparent text-gray-400'"
                            class="py-6 px-10 text-xl font-bold transition-all hover:text-white relative overflow-hidden -translate-y-7 text-left"
                            style="width: calc(50% + 8px); clip-path: path('M 0,38 L 0,78 L 376,78 C 364.412,75.767 354.354,68.22 349.052,57.371 L 331.886,22.245 C 325.512,9.202 312.262,0.93 297.744,0.93 L 38,0.93 C 17.013,0.93 0,17.943 0,38.93 Z'); border-top-left-radius: 28px;">
                            Current Vacant
                        </button>

                        <button
                            id="expiring-sort"
                            @click="activeTab = 'expiration'; currentPage = 1;"
                            :class="activeTab === 'expiration' ? 'bg-[#0039C6] text-white' : 'bg-transparent text-gray-400'"
                            class="py-6 px-10 text-xl font-bold transition-all hover:text-white relative overflow-hidden -translate-y-7"
                            style="width: 55%; clip-path: path('M 78.2559,0.929688 C 63.7382,0.929688 50.4886,9.20169 44.1143,22.2451 L 26.9482,57.3711 C 21.6463,68.22 11.5881,75.7673 0,78 L 450,78 L 450,38.9297 C 450,17.9429 433,0.929688 412,0.929688 L 78.2559,0.929688 Z'); border-top-right-radius: 28px;">
                            Upcoming Lease Expiration
                        </button>
                    </div>

                    <div class="relative">
                        <div id="static-blue"
                            class="bg-[#003CC1] pt-12 md:pt-15 pb-10 px-4 md:px-8 transition-all duration-300"
                            :class="activeTab === 'vacant' ? 'rounded-tl-none rounded-tr-[40px]' : 'rounded-tr-none rounded-tl-[40px]'">
                            <div class="absolute bottom-0 left-0 right-0 h-20 bg-white rounded-t-[40px]"></div>
                        </div>

                        <div id="card-container" class="relative -mt-16 bg-white rounded-[32px] shadow-xl p-4 md:p-8 z-20">
                            <div class="min-h-[400px] md:h-[560px] overflow-y-auto pr-2 md:pr-4 custom-scrollbar">

                                <template x-if="activeTab === 'vacant'">
                                    <div class="flex flex-col gap-4">
                                        <div x-show="currentPage === 1">
                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 101"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                price="₱ 72,000"
                                                vacantSince="June 28, 2025"
                                                leaseType="Monthly"
                                                condition="Move-In Ready"
                                                subtitle="186 days"
                                                lostRevenue="₱ 72,000" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 102"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                price="₱ 68,000"
                                                vacantSince="July 15, 2025"
                                                leaseType="Monthly"
                                                condition="Move-In Ready"
                                                subtitle="173 days"
                                                lostRevenue="₱ 68,000" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 103"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                price="₱ 75,000"
                                                vacantSince="May 20, 2025"
                                                leaseType="Monthly"
                                                condition="Move-In Ready"
                                                subtitle="215 days"
                                                lostRevenue="₱ 75,000" />
                                        </div>

                                        <div x-show="currentPage === 2">
                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 104"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                price="₱ 65,000"
                                                vacantSince="August 1, 2025"
                                                leaseType="Monthly"
                                                condition="Move-In Ready"
                                                subtitle="156 days"
                                                lostRevenue="₱ 65,000" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 105"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                price="₱ 80,000"
                                                vacantSince="April 10, 2025"
                                                leaseType="Monthly"
                                                condition="Move-In Ready"
                                                subtitle="245 days"
                                                lostRevenue="₱ 80,000" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 106"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                price="₱ 70,000"
                                                vacantSince="July 30, 2025"
                                                leaseType="Monthly"
                                                condition="Move-In Ready"
                                                subtitle="158 days"
                                                lostRevenue="₱ 70,000" />
                                        </div>

                                        <div x-show="currentPage === 3">
                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 107"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                price="₱ 85,000"
                                                vacantSince="March 15, 2025"
                                                leaseType="Monthly"
                                                condition="Move-In Ready"
                                                subtitle="271 days"
                                                lostRevenue="₱ 85,000" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 108"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                price="₱ 62,000"
                                                vacantSince="August 10, 2025"
                                                leaseType="Monthly"
                                                condition="Move-In Ready"
                                                subtitle="147 days"
                                                lostRevenue="₱ 62,000" />
                                        </div>
                                    </div>
                                </template>

                                <template x-if="activeTab === 'expiration'">
                                    <div class="flex flex-col gap-4">
                                        <div x-show="currentPage === 1">
                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 201"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                tenant="John Doe Balona"
                                                price="₱ 72,000"
                                                vacantSince="June 28, 2025"
                                                leaseType="Monthly"
                                                condition="Expiring Soon"
                                                subtitle="20 days remaining" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 202"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                tenant="Maria Santos"
                                                price="₱ 68,000"
                                                vacantSince="July 15, 2025"
                                                leaseType="Monthly"
                                                condition="Expiring Soon"
                                                subtitle="15 days remaining" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 203"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                tenant="Robert Cruz"
                                                price="₱ 75,000"
                                                vacantSince="May 20, 2025"
                                                leaseType="Monthly"
                                                condition="Expiring Soon"
                                                subtitle="25 days remaining" />
                                        </div>

                                        <div x-show="currentPage === 2">
                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 204"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                tenant="Angela Reyes"
                                                price="₱ 65,000"
                                                vacantSince="August 1, 2025"
                                                leaseType="Monthly"
                                                condition="Expiring Soon"
                                                subtitle="10 days remaining" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 205"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                tenant="Michael Torres"
                                                price="₱ 80,000"
                                                vacantSince="April 10, 2025"
                                                leaseType="Monthly"
                                                condition="Expiring Soon"
                                                subtitle="30 days remaining" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 206"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                tenant="Jennifer Lopez"
                                                price="₱ 70,000"
                                                vacantSince="July 30, 2025"
                                                leaseType="Monthly"
                                                condition="Expiring Soon"
                                                subtitle="12 days remaining" />
                                        </div>

                                        <div x-show="currentPage === 3">
                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 207"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                tenant="David Mendoza"
                                                price="₱ 85,000"
                                                vacantSince="March 15, 2025"
                                                leaseType="Monthly"
                                                condition="Expiring Soon"
                                                subtitle="35 days remaining" />

                                            <livewire:layouts.listing-card
                                                unitNumber="Unit 208"
                                                address="Taguig, 1634 Metro Manila, Philippines"
                                                tenant="Patricia Garcia"
                                                price="₱ 62,000"
                                                vacantSince="August 10, 2025"
                                                leaseType="Monthly"
                                                condition="Expiring Soon"
                                                subtitle="8 days remaining" />
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div class="flex justify-center items-center gap-2 mt-6 md:mt-8">
                                <button
                                    @click="currentPage = currentPage - 1"
                                    x-show="currentPage > 1"
                                    class="p-2 w-8 h-8 md:w-10 md:h-10 border-2 border-[#0039C6] bg-[#0039C6] text-white rounded-lg hover:bg-[#002A8F] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div class="flex gap-2">
                                    <template x-for="page in totalPages" :key="page">
                                        <button
                                            @click="currentPage = page"
                                            :class="currentPage === page ? 'bg-[#0039C6] text-white' : 'border-2 border-gray-300 text-gray-700 hover:bg-gray-100'"
                                            class="py-2 px-3 md:px-4 w-8 h-8 md:w-10 md:h-10 flex items-center justify-center font-bold rounded-lg transition-colors text-sm md:text-base"
                                            x-text="page"></button>
                                    </template>
                                </div>

                                <button
                                    @click="currentPage = currentPage + 1"
                                    x-show="currentPage < totalPages"
                                    class="p-2 w-8 h-8 md:w-10 md:h-10 border-2 border-[#0039C6] bg-[#0039C6] text-white rounded-lg hover:bg-[#002A8F] transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@push('styles')
<style>
    /* Custom Scrollbar Styling */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #0039C6;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #002A8F;
    }
</style>
@endpush

@endsection