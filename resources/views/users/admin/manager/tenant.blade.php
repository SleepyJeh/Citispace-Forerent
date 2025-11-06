@extends ('layouts.app')

@section('content')
<div class="flex flex-row h-screen overflow-hidden">
    <!-- Navigations -->
    <livewire:navbars.side-bar />

    <section id="main-container" class="flex-1 h-full flex flex-col overflow-hidden">

        <div class="flex-shrink-0 bg-white z-30">
            <livewire:layouts.top-bar />
        </div>

        <div class="flex-1 overflow-y-auto">

            <div id="pm-container" class="w-full min-h-full rounded-tl-4xl bg-[#F4F7FC] flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16 gap-6">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex flex-col">
                        <span id="main-header" class="header-title text-2xl md:text-3xl text-blue-900 font-bold">TENANT MANAGEMENT</span>
                        <span class="sub-header text-sm md:text-base text-gray-600">Track tenant information and leases</span>
                    </div>

                    <button class="bg-blue-900 hover:bg-blue-950 text-white font-semibold px-6 py-2.5 rounded-lg flex items-center space-x-2 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        <span>Add Tenant</span>
                    </button>
                </div>

                @include('livewire.layouts.admingreeting')

                {{-- Building Cards Section --}}
                <div class="mt-6">
                    <livewire:layouts.building-cards-section
                        :show-add-button="false"
                        title="Properties"
                        empty-state-title="No properties available"
                        empty-state-description="Properties will appear here once added to the system"
                    />
                </div>

                {{-- Tenant Management Section --}}
                <div class="mt-6">
                    <div class="w-full">
                        <div class="flex flex-col lg:flex-row gap-6 h-[calc(100vh-400px)] min-h-[600px]">
                            {{-- Left Panel: Tenant Navigation --}}
                            <div class="lg:w-1/3">
                                <livewire:layouts.tenant-navigation />
                            </div>

                            {{-- Right Panel: Tenant Detail --}}
                            <div class="lg:w-2/3">
                                <livewire:layouts.tenant-detail />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('buildingSelected', (event) => {
            console.log('Building selected in tenant page:', event.buildingId);
            // Add tenant-specific logic here
            // For example: filter tenants by building, show building details, etc.
        });

        // Listen for property creation to refresh the list
        Livewire.on('propertyCreated', (propertyId) => {
            console.log('Property created:', propertyId);
            // Refresh the building cards
            Livewire.dispatch('refresh-property-list');
        });

        // Listen for tenant selection if needed
        Livewire.on('tenantSelected', (event) => {
            console.log('Tenant selected:', event.tenantId);
            // Add any additional tenant selection logic here
        });
    });
</script>
@endpush

@endsection
