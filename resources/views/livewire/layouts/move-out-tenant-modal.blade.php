<div>
    @if($showModal)
        <div
            wire:click.self="close"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm"
        >
            <div
                class="p-8 relative w-full max-w-3xl bg-gray-50 rounded-2xl shadow-xl overflow-hidden max-h-[90vh] flex flex-col"
                @click.stop
            >
                <h2 class="text-3xl font-bold text-center text-blue-900 mb-4">Move Out Tenant?</h2>
                <p class="text-gray-600 text-center mb-4">
                    This action will mark the tenant as moved out and update their lease status. This action cannot be undone.
                </p>
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8">
                    <p class="text-amber-800 text-sm">
                        Please ensure that:
                    <ul class="list-disc list-inside mt-2 space-y-1">
                        <li>All outstanding payments have been settled</li>
                        <li>Keys have been returned</li>
                        <li>Room inspection has been completed</li>
                    </ul>
                    </p>
                </div>

                {{-- Add loading indicator --}}
                <div wire:loading class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-4">
                    <p class="text-blue-800 text-sm text-center">
                        Processing move out... Please wait.
                    </p>
                </div>

                <div class="flex w-full justify-evenly mt-4">
                    <button
                        type="button"
                        class="bg-blue-100 text-blue-900 font-semibold py-2 px-12 rounded-2xl hover:bg-blue-200 transition disabled:opacity-50"
                        wire:click="cancel"
                        wire:loading.attr="disabled"
                    >
                        Cancel
                    </button>
                    <button
                        type="button"
                        class="bg-blue-700 text-white font-semibold py-2 px-12 rounded-2xl hover:bg-blue-800 transition disabled:opacity-50"
                        wire:click="moveOut"
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove>Move Out</span>
                        <span wire:loading>Processing...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- Flash messages --}}
    @if (session()->has('success') || session()->has('error'))
        <div class="fixed bottom-4 right-4 z-50">
            @if (session()->has('success'))
                <div class="bg-green-500 text-white p-4 rounded-lg shadow-lg">
                    {{ session('success') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-500 text-white p-4 rounded-lg shadow-lg">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    @endif
</div>
