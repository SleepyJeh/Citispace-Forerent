<div>
    {{-- This file ONLY contains the dropdown. Do not put the loop here. --}}
    <select wire:model.live="sort" class="bg-white border border-gray-200 text-gray-700 py-2.5 px-4 pr-8 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none cursor-pointer font-medium">
        <option value="newest">Sort by: Newest</option>
        <option value="oldest">Sort by: Oldest</option>
        <option value="status">Sort by: Status</option>
    </select>
</div>
