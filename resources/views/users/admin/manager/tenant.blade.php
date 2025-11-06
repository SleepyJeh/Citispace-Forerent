@extends('layouts.app')

@section('content')
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <livewire:navbars.side-bar />

        <!-- Main Section -->
        <section id="main-container" class="flex flex-col flex-1 overflow-hidden">

            <!-- Top Bar -->
            <div class="flex-shrink-0 bg-white z-30">
                <livewire:layouts.top-bar />
            </div>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto bg-[#F4F7FC]">
                <div id="pm-container" class="w-full min-h-full rounded-tl-4xl flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16 gap-6">

                    <!-- Header -->
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex flex-col">
                            <span id="main-header" class="header-title text-2xl md:text-3xl text-blue-900 font-bold">TENANT MANAGEMENT</span>
                            <span class="sub-header text-sm md:text-base text-gray-600">Track tenant information and leases</span>
                        </div>
                        <div>
                            <button
                                type="button"
                                onclick="Livewire.dispatch('openAddTenantModal_tenant-dashboard')"
                                class="inline-flex items-center gap-x-2 rounded-full bg-[#152C73] px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-[#152C73]/90 focus:outline-none focus:ring-2 focus:ring-[#152C73] focus:ring-offset-2 transition-colors"
                            >
                                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                </svg>
                                Add Tenant
                            </button>
                        </div>
                    </div>

                    @include('livewire.layouts.admingreeting')

                    <livewire:layouts.building-list />

                    <!-- Main Content -->
                    <div class="flex flex-col gap-6 min-h-0">
                        <!-- Top Row: Navigation + Details -->
                        <div class="flex flex-col lg:flex-row gap-6 flex-1 min-h-0">
                            <!-- Tenant Navigation -->
                            <div class="w-full lg:w-[30%] h-full min-h-0">
                                <div class="h-full bg-white rounded-2xl shadow-md overflow-hidden">
                                    <livewire:layouts.tenant-navigation />
                                </div>
                            </div>

                            <!-- Tenant Details -->
                            <div class="w-full lg:w-[70%] h-full min-h-0">
                                <div class="h-full bg-white rounded-2xl shadow-md overflow-hidden">
                                    <livewire:layouts.tenant-detail />
                                </div>
                            </div>
                        </div>

                        <!-- Bottom Row: Previous Tenants Table -->
                        <div class="flex-shrink-0">
                            <livewire:layouts.previous-tenants-table />
                        </div>
                    </div>

                    <!-- Add Tenant Modal -->
                    <livewire:layouts.add-tenant-modal modalId="tenant-dashboard" />

                </div>
            </div>
        </section>
    </div>
@endsection
