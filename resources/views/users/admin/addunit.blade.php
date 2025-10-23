@extends ('layouts.app')

@section('content')

{{-- This is the new main layout container from property.blade.php --}}
<div class="flex flex-row h-screen overflow-hidden">
    
    {{-- Sidebar (copied from property.blade.php) --}}
    <nav class="w-0 md:w-64 flex-shrink-0 h-full overflow-y-auto bg-white">
        @include('livewire.layouts.adminnav')
    </nav>

    {{-- This is the new main content area shell from property.blade.php --}}
    <section id="main-container" class="flex-1 h-full flex flex-col overflow-hidden">
        
        {{-- Top Bar (copied from property.blade.php) --}}
        <div class="flex-shrink-0 bg-white z-30">
            <livewire:layouts.top-bar />
        </div>

        {{-- Scrollable content area (copied from property.blade.php) --}}
        <div class="flex-1 overflow-y-auto">
            
            {{-- This is the inner container, styled like property.blade.php's "pm-container" --}}
            {{-- It uses the same padding and background classes for consistency --}}
            <div id="add-container" class="w-full min-h-full rounded-tl-4xl bg-[#F4F7FC] flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16">

                {{-- Header (content from addunit, structure from property) --}}
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mt-6 mb-6">
                    <div class="flex flex-col">
                        <span id="main-header" class="header-title text-2xl md:text-3xl text-blue-900 font-bold">ADD NEW UNIT</span>
                        <span class="sub-header text-sm md:text-base text-gray-600">Fill in the details to predict rental price</span>
                    </div>
                    {{-- No "Add Unit" button is needed here --}}
                </div>

                {{-- Greeting (from original addunit) --}}
                @include('livewire.layouts.admingreeting')

                {{-- Main Livewire Component (from original addunit) --}}
                {{-- Added a margin-top for spacing, consistent with property.blade.php --}}
                <div class="mt-4">
                    <livewire:layouts.add-unit />
                </div>

            </div>
        </div>
    </section>
</div>

@endsection

{{-- Script push (from original addunit, placed after the section) --}}
@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
