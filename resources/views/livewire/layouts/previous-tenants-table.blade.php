<div class="w-full">
    {{-- Header --}}
    <div class="bg-blue-500 text-white rounded-t-3xl px-6 py-4">
        <h2 class="text-xl font-semibold">
            Previous Tenants
            @if($selectedBedId)
                <span class="text-sm font-normal opacity-90">(for selected bed)</span>
            @endif
        </h2>
    </div>

    {{-- Table Container --}}
    <div class="bg-white rounded-b-3xl border-2 border-blue-500 border-t-0 overflow-hidden">
        {{-- Fixed Table Header --}}
        <div class="grid grid-cols-5 gap-4 px-6 py-4 text-sm font-semibold text-gray-700 border-b bg-gray-50 sticky top-0 z-10">
            <div>Unit Number</div>
            <div>Tenant Name</div>
            <div>Move In</div>
            <div>Move Out</div>
            <div>Monthly Rent</div>
        </div>

        {{-- Scrollable Table Body --}}
        <div class="max-h-[40vh] overflow-y-auto custom-scrollbar divide-y">
            @forelse($tenants ?? [] as $tenant)
                <div class="grid grid-cols-5 gap-4 px-6 py-4 bg-blue-50 hover:bg-blue-100 transition-colors">
                    <div class="font-semibold text-blue-900">{{ $tenant->unit_number }}</div>
                    <div class="text-blue-900">{{ $tenant->tenant_name }}</div>
                    <div class="text-blue-900">{{ \Carbon\Carbon::parse($tenant->move_in)->format('F j, Y') }}</div>
                    <div class="text-blue-900">{{ \Carbon\Carbon::parse($tenant->move_out)->format('F Y') }}</div>
                    <div class="text-blue-900">{{ $tenant->monthly_rent }}</div>
                </div>
            @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    @if($selectedBedId)
                        No previous tenants found for this bed
                    @else
                        No previous tenants found. Select a bed to view its previous tenants.
                    @endif
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('styles')
    <style>
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
