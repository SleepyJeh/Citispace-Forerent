<div
    x-data="{ show: false }"
    x-show="show"
    @open-create-maintenance-modal.window="show = true; $wire.dispatch('reset-modal')"
    @close-modal.window="show = false"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center"
    style="display: none;" {{-- Prevents flicker on load --}}
>
    {{-- Backdrop (Click to close) --}}
    <div class="fixed inset-0 bg-black bg-opacity-40 transition-opacity" @click="show = false"></div>

    {{-- Modal Container --}}
    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="transition ease-in duration-200 transform"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative bg-white rounded-3xl shadow-xl max-w-lg w-full mx-4 overflow-hidden z-50 font-['Poppins']"
    >
        {{-- Header --}}
        <div class="bg-[#2B66F5] p-6 text-white flex justify-between items-center">
            <h3 class="text-xl font-bold">New Request</h3>
            <button @click="show = false" class="text-white hover:bg-white/20 rounded-full p-1 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        {{-- Form Body --}}
        <div class="p-6 space-y-6">

            {{-- Urgency Select --}}
            <div>
                <label for="urgency" class="block text-sm font-bold text-[#070642] mb-2">Urgency Level</label>
                <select
                    wire:model="urgency"
                    id="urgency"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#2B66F5] bg-gray-50 text-[#070642] font-medium appearance-none"
                    style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%202000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23070642%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E'); background-repeat: no-repeat; background-position: right 1rem center; background-size: 0.75em;"
                >
                    <option value="Low">Low - Minor issue, no rush</option>
                    <option value="Normal">Normal - Standard repair needed</option>
                    <option value="High">High - Affects daily living</option>
                    <option value="Emergency">Emergency - Safety hazard</option>
                </select>
                @error('urgency') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Problem Description Textarea --}}
            <div>
                <label for="problem" class="block text-sm font-bold text-[#070642] mb-2">Issue Description</label>
                <textarea
                    wire:model="problem"
                    id="problem"
                    rows="5"
                    class="w-full border border-gray-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#2B66F5] bg-gray-50 resize-none placeholder-gray-400"
                    placeholder="Please describe the issue in detail (at least 10 characters)..."
                ></textarea>
                @error('problem') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

                {{-- Helper text --}}
                <p class="text-xs text-gray-400 mt-2 flex items-center gap-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Please provide as much detail as possible to help us resolve it faster.
                </p>
            </div>
        </div>

        {{-- Footer Actions --}}
        <div class="p-6 border-t border-gray-100 flex justify-end gap-4 bg-gray-50">
            <button
                @click="show = false"
                type="button"
                class="px-6 py-2.5 rounded-full font-bold text-gray-500 hover:bg-gray-200 transition-colors"
            >
                Cancel
            </button>
            <button
                wire:click="save"
                wire:loading.attr="disabled"
                type="button"
                class="px-6 py-2.5 rounded-full font-bold text-white bg-[#2B66F5] hover:bg-[#1a4fd1] transition-colors flex items-center gap-2 disabled:opacity-50"
            >
                <span wire:loading.remove>Submit Request</span>
                <span wire:loading class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Submitting...
                </span>
            </button>
        </div>
    </div>
</div>
