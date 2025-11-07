<div>
    <!-- Modal Overlay -->
    @if($isOpen)
        <div wire:click.self="close" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
            <div class="relative w-full max-w-3xl bg-gray-50 rounded-2xl shadow-xl overflow-hidden max-h-[90vh] flex flex-col" @click.stop>
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-6 border-b border-gray-200 flex-shrink-0">
                    <div>
                        <h2 class="text-xl font-bold text-[#001B5E] uppercase">
                            {{ $tenantId ? 'Edit Tenant' : 'Add New Tenant' }}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ $tenantId ? 'Update tenant information and lease details.' : 'Fill in the details to add new tenant.' }}
                        </p>
                    </div>
                    <button
                        wire:click="close"
                        type="button"
                        class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                        <x-icons.close />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal Body - Scrollable -->
                <div class="flex-1 overflow-y-auto p-6">
                    <form wire:submit.prevent="save" class="space-y-6">

                        <!-- White Container Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                            <!-- Profile Information Section -->
                            <div class="mb-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <x-icons.profile />
                                    <h3 class="text-base font-semibold text-gray-900">Profile Information</h3>
                                </div>

                                <div class="flex items-start gap-6">
                                    <!-- Profile Picture Upload -->
                                    <div class="flex flex-col items-center text-center flex-shrink-0">
                                        <label for="profilePicture-{{ $modalId }}" class="cursor-pointer relative group">
                                            @if ($profilePicture)
                                                @if(is_string($profilePicture))
                                                    <!-- Existing image from database -->
                                                    <img src="{{ Storage::url($profilePicture) }}" alt="Profile Preview" class="w-24 h-24 rounded-full object-cover shadow-md border-4 border-[#001B5E]">
                                                @else
                                                    <!-- New uploaded image -->
                                                    <img src="{{ $profilePicture->temporaryUrl() }}" alt="Profile Preview" class="w-24 h-24 rounded-full object-cover shadow-md border-4 border-[#001B5E]">
                                                @endif
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
                                    <div class="flex-1 flex flex-col gap-4">
                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- First Name -->
                                            <div class="relative">
                                                <input
                                                    wire:model.defer="userForm.firstName"
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
                                                @error('userForm.firstName')
                                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <!-- Last Name -->
                                            <div class="relative">
                                                <input
                                                    wire:model.defer="userForm.lastName"
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
                                                @error('userForm.lastName')
                                                <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <hr class="my-6 border-gray-200 border-dashed">

                            <!-- Contact Information Section -->
                            <div class="mb-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                    </svg>
                                    <h3 class="text-base font-semibold text-gray-900">Contact Information</h3>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div class="relative">
                                        <!-- Input -->
                                        <input
                                            wire:model.defer="userForm.phoneNumber"
                                            type="text"
                                            id="phone-{{ $modalId }}"
                                            class="block pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] pr-2.5 pl-16"
                                            placeholder=" "
                                        />

                                        <!-- Fixed +63 prefix -->
                                        <div class="absolute top-4 left-0 px-3 flex items-center space-x-2 pointer-events-none">
                                            <span class="text-sm text-gray-500">+63</span>
                                            <span class="border-l border-gray-300 h-5"></span>
                                        </div>

                                        <!-- Label -->
                                        <label
                                            for="phone-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1">
                                            Phone Number
                                        </label>

                                        @error('userForm.phoneNumber')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="relative">
                                        <input
                                            wire:model.defer="userForm.email"
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
                                        @error('userForm.email')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @else
                                            <p class="text-xs text-gray-500 mt-1">
                                                Login credentials will be sent to this email
                                            </p>
                                            @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <hr class="my-6 border-gray-200 border-dashed">

                            <!-- Rent Details Section -->
                            <div class="mb-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    <h3 class="text-base font-semibold text-gray-900">Rent Details</h3>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <!-- Building Name -->
                                    <div class="relative">
                                        <select
                                            wire:model.live="selectedBuilding"
                                            id="building-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer"
                                        >
                                            <option value="">Select Building</option>
                                            @foreach($buildings as $building)
                                                <option value="{{ $building['property_id'] }}">{{ $building['building_name'] }}</option>
                                            @endforeach
                                        </select>
                                        <label
                                            for="building-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Building Name
                                        </label>
                                        <svg class="absolute right-3 top-4 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        @error('selectedBuilding')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Floor Number -->
                                    <div class="relative">
                                        <select
                                            wire:model.live="selectedFloor"
                                            id="floor-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer"
                                            @if(!$selectedBuilding) disabled @endif
                                        >
                                            <option value="">Select Floor</option>
                                            @foreach($availableFloors as $floor)
                                                <option value="{{ $floor['id'] }}">{{ $floor['number'] }}</option>
                                            @endforeach
                                        </select>
                                        <label
                                            for="floor-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Floor Number
                                        </label>
                                        <svg class="absolute right-3 top-4 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        @error('selectedFloor')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Dorm Type (Occupants) -->
                                    <select
                                        wire:model.live="tenantForm.dormType"
                                        id="occupants-{{ $modalId }}"
                                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer"
                                    >
                                        <option value="">Select Dorm Type</option>
                                        <option value="Female">All Female</option>
                                        <option value="Male">All Male</option>
                                        <option value="Co-ed">Mixed</option>
                                    </select>

                                    <!-- Unit Number -->
                                    <div class="relative">
                                        <select
                                            wire:model.live="selectedUnit"
                                            id="unit-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer"
                                            @if(!$selectedFloor) disabled @endif
                                        >
                                            <option value="">Select Unit</option>
                                            @foreach($availableUnits as $unit)
                                                <option value="{{ $unit['id'] }}">{{ $unit['number'] }}</option>
                                            @endforeach
                                        </select>
                                        <label
                                            for="unit-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Unit Number
                                        </label>
                                        <svg class="absolute right-3 top-4 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        @error('selectedUnit')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Bed Number -->
                                    <div class="relative">
                                        <select
                                            wire:model.defer="selectedBed"                                            id="bedNumber-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer"
                                            @if(!$selectedUnit) disabled @endif
                                        >
                                            <option value="">Select Bed</option>
                                            @foreach($availableBeds as $bed)
                                                <option value="{{ $bed['id'] }}">{{ $bed['number'] }}</option>
                                            @endforeach
                                        </select>
                                        <label
                                            for="selectedBed-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Bed Number
                                        </label>
                                        <svg class="absolute right-3 top-4 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        @error('tenantForm.selectedBed')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Term -->
                                    <div class="relative">
                                        <input
                                            wire:model.defer="tenantForm.term"
                                            type="text"
                                            id="term-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer"
                                            placeholder=" "
                                        />
                                        <label
                                            for="term-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                                        >
                                            Term (Months)
                                        </label>
                                        @error('tenantForm.term')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Shift -->
                                    <div class="relative">
                                        <select
                                            wire:model.defer="tenantForm.shift"
                                            id="shift-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer"
                                        >
                                            <option value="">Select Shift</option>
                                            <option value="Morning">Day</option>
                                            <option value="Night">Night</option>
                                        </select>
                                        <label
                                            for="shift-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Shift
                                        </label>
                                        <svg class="absolute right-3 top-4 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        @error('tenantForm.shift')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Start Date -->
                                    <div class="relative">
                                        <input
                                            wire:model.defer="tenantForm.startDate"
                                            type="date"
                                            id="startDate-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer"
                                            placeholder=" "
                                        />
                                        <label
                                            for="startDate-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Start Date
                                        </label>
                                        @error('tenantForm.startDate')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Auto Renew Contract Checkbox -->
                                <div class="flex items-center">
                                    <input
                                        wire:model.defer="tenantForm.autoRenewContract"
                                        type="checkbox"
                                        id="autoRenew-{{ $modalId }}"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2"
                                    />
                                    <label for="autoRenew-{{ $modalId }}" class="ml-2 text-sm text-gray-900">
                                        Auto Renew Contract
                                    </label>
                                </div>
                            </div>

                            <!-- Divider -->
                            <hr class="my-6 border-gray-200 border-dashed">

                            <!-- Move In Details Section -->
                            <div>
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    <h3 class="text-base font-semibold text-gray-900">Move In Details</h3>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <!-- Move In Date -->
                                    <div class="relative">
                                        <input
                                            wire:model.defer="tenantForm.moveInDate"
                                            type="date"
                                            id="moveInDate-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer"
                                            placeholder=" "
                                        />
                                        <label
                                            for="moveInDate-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Move In Date
                                        </label>
                                        @error('tenantForm.moveInDate')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Monthly Rate -->
                                    <div class="relative">
                                        <input
                                            wire:model.defer="tenantForm.monthlyRate"
                                            type="number"
                                            step="0.01"
                                            id="monthlyRate-{{ $modalId }}"
                                            class="block pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] pr-2.5 pl-10"
                                            placeholder="{{$this->unitPrice}}"
                                        />

                                        <!-- Peso Symbol -->
                                        <div class="absolute top-4 left-3 pointer-events-none">
                                            <span class="text-sm text-gray-500">₱</span>
                                        </div>

                                        <label
                                            for="monthlyRate-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Monthly Rate
                                        </label>
                                        @error('tenantForm.monthlyRate')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Security Deposit -->
                                    <div class="relative">
                                        <input
                                            wire:model.defer="tenantForm.securityDeposit"
                                            type="number"
                                            step="0.01"
                                            id="securityDeposit-{{ $modalId }}"
                                            class="block pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] pr-2.5 pl-10"
                                            placeholder=" "
                                        />

                                        <!-- Peso Symbol -->
                                        <div class="absolute top-4 left-3 pointer-events-none">
                                            <span class="text-sm text-gray-500">₱</span>
                                        </div>

                                        <label
                                            for="securityDeposit-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Security Deposit
                                        </label>
                                        @error('tenantForm.securityDeposit')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <!-- Payment Status -->
                                    <div class="relative">
                                        <select
                                            wire:model.defer="tenantForm.paymentStatus"
                                            id="paymentStatus-{{ $modalId }}"
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer"
                                        >
                                            <option value="">Select Payment Status</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Overdue">Overdue</option>
                                        </select>
                                        <label
                                            for="paymentStatus-{{ $modalId }}"
                                            class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] start-1"
                                        >
                                            Payment Status
                                        </label>
                                        <svg class="absolute right-3 top-4 w-4 h-4 text-gray-400 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                        @error('tenantForm.paymentStatus')
                                        <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Registration -->
                                <div class="relative mt-4">
                                    <input
                                        wire:model.defer="tenantForm.registration"
                                        type="text"
                                        id="registration-{{ $modalId }}"
                                        class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer"
                                        placeholder=" "
                                    />
                                    <label
                                        for="registration-{{ $modalId }}"
                                        class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-1"
                                    >
                                        Registration
                                    </label>
                                    @error('tenantForm.registration')
                                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-center pt-2">
                            <button
                                type="submit"
                                class="px-20 py-2.5 bg-[#070589] text-white text-sm font-semibold rounded-lg hover:bg-[#001445] focus:ring-4 focus:ring-blue-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                                wire:loading.attr="disabled"
                            >
                                <span wire:loading.remove wire:target="save">Save</span>
                                <span wire:loading wire:target="save">Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
