@extends ('layouts.app')

@section('content')
<div class="flex flex-row">
    <nav class="w-0 md:w-60">
        @include('livewire.layouts.adminnav')
    </nav>

    <section class="flex-1 mt-25 ml-4 min-h-screen">
        {{-- The main content container controls the horizontal padding for consistent alignment --}}
        <div id="add-container" class="w-full h-full pl-20 pr-20 pt-6 pb-6 rounded-tl-4xl bg-[#F4F7FC] flex flex-col gap-4">
            <div class="flex flex-col mt-6">
                <span id="main-header" class="header-title text-3xl text-blue-900">ADD NEW UNIT</span>
                <span class="sub-header">Fill in the details to predict rental price</span>
            </div>

            @include('livewire.layouts.admingreeting')

            {{-- Livewire component takes full width and inherits the padding of the container above --}}
            <livewire:layouts.add-unit   />

        </div>
    </section>
</div>



@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
@endsection