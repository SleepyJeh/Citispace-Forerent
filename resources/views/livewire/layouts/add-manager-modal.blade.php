<div>
    <!-- Modal Overlay -->
    @if($isOpen)
    <div
        wire:click.self="close"
        class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm"
        style="display: flex;"
    >
        <div
            class="relative w-full max-w-2xl bg-white rounded-2xl shadow-xl overflow-hidden"
            @click.stop
        >
            <!-- Modal Header -->
            <div class="flex items-start justify-between p-6 border-b border-gray-200">
                <div>
                    <h2 class="text-xl font-bold text-[#001B5E] uppercase">Add New Manager</h2>
                    <p class="mt-1 text-sm text-gray-600">Create an account for the new property manager.</p>
                </div>
                <button
                    wire:click="close"
                    type="button"
                    class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none"
                >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <form wire:submit.prevent="save" class="space-y-6">

                    <!-- Profile Information Section -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 8a3 3 0 100-6 3 3 0 000 6zM3.465 14.493a1.23 1.23 0 00.41 1.412A9.957 9.957 0 0010 18c2.31 0 4.438-.78 6.125-2.095a1.23 1.23 0 00.41-1.412 9.99 9.99 0 00-5.45-5.496 1.502 1.502 0 00-2.17 0 9.99 9.99 0 00-5.45 5.496z" />
                            </svg>
                            <h3 class="text-base font-semibold text-gray-900">Profile Information</h3>
                        </div>

                        <div class="flex items-start gap-6">
                            <!-- Profile Picture Upload -->
                            <div class="flex flex-col items-center text-center flex-shrink-0">
                                <label for="profilePicture-{{ $modalId }}" class="cursor-pointer relative group">
                                    @if ($profilePicture)
                                        <img src="{{ $profilePicture->temporaryUrl() }}" alt="Profile Preview" class="w-24 h-24 rounded-full object-cover shadow-md border-4 border-[#001B5E]">
                                    @else
                                        <div class="w-24 h-24 rounded-full bg-[#001B5E] flex items-center justify-center shadow-md">
                                            <svg class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-white rounded-full flex items-center justify-center shadow-md border border-gray-200 group-hover:bg-gray-50">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                                        </svg>
                                    </div>
                                </label>
                                <input
                                    type="file"
                                    wire:model="profilePicture"
                                    id="profilePicture-{{ $modalId }}"
                                    class="hidden"
                                    accept="image/*"
                                >
                                <span class="mt-2 font-medium text-xs text-gray-900">Profile Picture</span>
                                <span class="text-xs text-gray-500">This will be displayed on your profile</span>
                                @error('profilePicture')
                                    <span class="text-xs text-red-500 mt-1">{{ $message }}</span>
                                @enderror

                                <div wire:loading wire:target="profilePicture" class="mt-2 text-xs text-blue-600">
                                    Uploading...
                                </div>
                            </div>

                            <!-- Name Fields -->
                            <div class="flex-1 grid grid-cols-2 gap-4">
                                <div class="relative">
                                    <input
                                        wire:model.blur="firstName"
                                        type="text"
                                        id="firstName-{{ $modalId }}"
                                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer"
                                        placeholder=" "
                                    />
                                    <label
                                        for="firstName-{{ $modalId }}"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                                    >
                                        First Name
                                    </label>
                                    @error('firstName')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="relative">
                                    <input
                                        wire:model.blur="lastName"
                                        type="text"
                                        id="lastName-{{ $modalId }}"
                                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer"
                                        placeholder=" "
                                    />
                                    <label
                                        for="lastName-{{ $modalId }}"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                                    >
                                        Last Name
                                    </label>
                                    @error('lastName')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <hr class="border-gray-200 border-dashed">

                    <!-- Contact Information Section -->
                    <div>
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                            </svg>
                            <h3 class="text-base font-semibold text-gray-900">Contact Information</h3>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="relative">
                                <input
                                    wire:model.blur="phone"
                                    type="text"
                                    id="phone-{{ $modalId }}"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer pl-12"
                                    placeholder=" "
                                />
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 peer-focus:text-[#0030C5]">+63</span>
                                <label
                                    for="phone-{{ $modalId }}"
                                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-9"
                                >
                                    Phone Number
                                </label>
                                @error('phone')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="relative">
                                <input
                                    wire:model.blur="email"
                                    type="email"
                                    id="email-{{ $modalId }}"
                                    class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer"
                                    placeholder=" "
                                />
                                <label
                                    for="email-{{ $modalId }}"
                                    class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                                >
                                    Email Address
                                </label>
                                @error('email')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                @else
                                    <p class="text-xs text-gray-500 mt-1">Login credentials will be sent to this email.</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <hr class="border-gray-200 border-dashed">

                    <!-- Save Button -->
                    <div class="flex justify-center pt-2">
                        <button
                            type="submit"
                            class="px-20 py-2.5 bg-[#001B5E] text-white text-sm font-semibold rounded-lg hover:bg-[#001445] focus:ring-4 focus:ring-blue-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled"
                        >
                            <span wire:loading.remove wire:target="save">Save</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
