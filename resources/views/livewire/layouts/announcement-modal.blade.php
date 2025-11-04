<div>
    {{-- Main Announcement Form Modal --}}
    @if($showModal && !$showConfirmation)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

            {{-- Modal panel --}}
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white px-8 pt-8 pb-6">
                    {{-- Header --}}
                    <div class="border-b border-gray-300 pb-4 mb-6">
                        <h3 class="text-3xl font-bold text-blue-900" id="modal-title">Announcement</h3>
                    </div>

                    {{-- Form Fields --}}
                    <div class="space-y-6">
                        {{-- Headline --}}
                        <div>
                            <label class="block text-lg font-bold text-blue-900 mb-3">Headline</label>
                            <input
                                type="text"
                                wire:model="headline"
                                placeholder="Add title summarizing the key message"
                                class="w-full px-4 py-3 border-2 border-blue-800 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400"
                            />
                            @error('headline')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Details --}}
                        <div>
                            <label class="block text-lg font-bold text-blue-900 mb-3">Details</label>
                            <textarea
                                wire:model="details"
                                rows="6"
                                placeholder="Add a message"
                                class="w-full px-4 py-3 border-2 border-blue-800 rounded-lg focus:ring-2 focus:ring-blue-600 focus:border-transparent placeholder-gray-400 resize-none"
                            ></textarea>
                            @error('details')
                                <span class="text-red-600 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Footer with Save Button --}}
                <div class="bg-white px-8 pb-8 flex justify-end">
                    <button
                        wire:click="save"
                        type="button"
                        class="px-12 py-3 bg-blue-900 text-white text-base font-semibold rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900 transition-colors">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Confirmation Modal --}}
    @if($showConfirmation)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            {{-- Background overlay --}}
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            {{-- Modal panel --}}
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-8 py-12">
                    {{-- Content --}}
                    <div class="text-center mb-8">
                        <h3 class="text-3xl font-bold text-blue-900 mb-4">Post Announcement?</h3>
                        <p class="text-gray-600 text-base">
                            Your announcement will be saved and will be visible to everyone immediately. Do you want to proceed?
                        </p>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-4">
                        <button
                            wire:click="cancelConfirmation"
                            type="button"
                            class="flex-1 px-6 py-3 bg-blue-200 text-blue-900 text-base font-semibold rounded-lg hover:bg-blue-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Cancel
                        </button>
                        <button
                            wire:click="confirmPost"
                            type="button"
                            class="flex-1 px-6 py-3 bg-blue-900 text-white text-base font-semibold rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900 transition-colors">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('open-announcement-modal', () => {
            @this.call('openModal');
        });
    });
</script>
@endpush
