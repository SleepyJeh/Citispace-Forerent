<div>
    <!-- Modal Overlay -->
    @if($isOpen)
        <div wire:click.self="close" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-gray-900/50 backdrop-blur-sm">
            <div class="relative w-full max-w-3xl bg-gray-50 rounded-2xl shadow-xl overflow-hidden max-h-[90vh] flex flex-col" @click.stop>
                <!-- Modal Header -->
                <div class="flex items-start justify-between p-6 border-b border-gray-200 flex-shrink-0">
                    <div>
                        <h2 class="text-xl font-bold text-[#001B5E] uppercase">Transfer Tenant</h2>
                        <p class="mt-1 text-sm text-gray-600">Select the new location and move-in details for the tenant.</p>
                    </div>
                    <button wire:click="close" type="button" class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                        <x-icons.close />
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>

                <!-- Modal Body - Scrollable -->
                <div class="flex-1 overflow-y-auto p-6">
                    <form wire:submit.prevent="save" class="space-y-6">

                        <!-- White Container Card -->
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">

                            <!-- Rent Details Section -->
                            <div class="mb-6">
                                <div class="flex items-center gap-2 mb-4">
                                    <svg class="w-5 h-5 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                                    </svg>
                                    <h3 class="text-base font-semibold text-gray-900">Rent Details</h3>
                                </div>

                                <div class="grid grid-cols-2 gap-4 mb-4">

                                    <!-- Building -->
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
                                        <label for="building-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Building Name</label>
                                        @error('selectedBuilding') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Floor -->
                                    <div class="relative">
                                        <select
                                            wire:model.live="selectedFloor"
                                            id="floor-{{ $modalId }}"
                                            @if(!$selectedBuilding) disabled @endif
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            <option value="">Select Floor</option>
                                            @foreach($availableFloors as $floor)
                                                <option value="{{ $floor['id'] }}">{{ $floor['number'] }}</option>
                                            @endforeach
                                        </select>
                                        <label for="floor-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Floor</label>
                                        @error('selectedFloor') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                        <div wire:loading wire:target="selectedBuilding" class="text-xs text-gray-500 mt-1">Loading floors...</div>
                                    </div>

                                    <!-- Dorm Type -->
                                    <div class="relative">
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
                                        <label for="occupants-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Dorm Type (Optional)</label>
                                        @error('tenantForm.dormType') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Unit -->
                                    <div class="relative">
                                        <select
                                            wire:model.live="selectedUnit"
                                            id="unit-{{ $modalId }}"
                                            @if(!$selectedFloor) disabled @endif
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            <option value="">Select Unit</option>
                                            @foreach($availableUnits as $unit)
                                                <option value="{{ $unit['id'] }}">{{ $unit['number'] }}</option>
                                            @endforeach
                                        </select>
                                        <label for="unit-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Unit</label>
                                        @error('selectedUnit') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                        <div wire:loading wire:target="selectedFloor,tenantForm.dormType" class="text-xs text-gray-500 mt-1">Loading units...</div>
                                    </div>

                                    <!-- Bed -->
                                    <div class="relative">
                                        <select
                                            wire:model.live="selectedBed"
                                            id="bedNumber-{{ $modalId }}"
                                            @if(!$selectedUnit) disabled @endif
                                            class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed"
                                        >
                                            <option value="">Select Bed</option>
                                            @foreach($availableBeds as $bed)
                                                <option value="{{ $bed['id'] }}">{{ $bed['number'] }}</option>
                                            @endforeach
                                        </select>
                                        <label for="bedNumber-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Bed Number</label>
                                        @error('selectedBed') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                        <div wire:loading wire:target="selectedUnit" class="text-xs text-gray-500 mt-1">Loading beds...</div>
                                    </div>

                                    <!-- Term -->
                                    <div class="relative">
                                        <input wire:model.defer="tenantForm.term" type="text" id="term-{{ $modalId }}" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
                                        <label for="term-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 start-1">Term (Months)</label>
                                        @error('tenantForm.term') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Shift -->
                                    <div class="relative">
                                        <select wire:model.defer="tenantForm.shift" id="shift-{{ $modalId }}" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer">
                                            <option value="">Select Shift</option>
                                            <option value="Morning">Day</option>
                                            <option value="Night">Night</option>
                                        </select>
                                        <label for="shift-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Shift</label>
                                        @error('tenantForm.shift') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Start Date -->
                                    <div class="relative">
                                        <input wire:model.defer="tenantForm.startDate" type="date" id="startDate-{{ $modalId }}" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
                                        <label for="startDate-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Start Date</label>
                                        @error('tenantForm.startDate') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                </div>

                                <!-- Auto Renew Contract Checkbox -->
                                <div class="flex items-center mt-4">
                                    <input wire:model.defer="tenantForm.autoRenewContract" type="checkbox" id="autoRenew-{{ $modalId }}" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2" />
                                    <label for="autoRenew-{{ $modalId }}" class="ml-2 text-sm text-gray-900">Auto Renew Contract</label>
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
                                        <input wire:model.defer="tenantForm.moveInDate" type="date" id="moveInDate-{{ $modalId }}" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
                                        <label for="moveInDate-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Move In Date</label>
                                        @error('tenantForm.moveInDate') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Monthly Rate -->
                                    <div class="relative">
                                        <input wire:model.defer="tenantForm.monthlyRate" type="number" step="0.01" id="monthlyRate-{{ $modalId }}" class="block pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer pr-2.5 pl-10" placeholder=" " />
                                        <div class="absolute top-4 left-3 pointer-events-none"><span class="text-sm text-gray-500">₱</span></div>
                                        <label for="monthlyRate-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Monthly Rate</label>
                                        @error('tenantForm.monthlyRate') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Security Deposit -->
                                    <div class="relative">
                                        <input wire:model.defer="tenantForm.securityDeposit" type="number" step="0.01" id="securityDeposit-{{ $modalId }}" class="block pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer pr-2.5 pl-10" placeholder=" " />
                                        <div class="absolute top-4 left-3 pointer-events-none"><span class="text-sm text-gray-500">₱</span></div>
                                        <label for="securityDeposit-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Security Deposit</label>
                                        @error('tenantForm.securityDeposit') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Payment Status -->
                                    <div class="relative">
                                        <select wire:model.defer="tenantForm.paymentStatus" id="paymentStatus-{{ $modalId }}" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer cursor-pointer">
                                            <option value="">Select Payment Status</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Pending">Pending</option>
                                            <option value="Overdue">Overdue</option>
                                        </select>
                                        <label for="paymentStatus-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] start-1">Payment Status</label>
                                        @error('tenantForm.paymentStatus') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Registration -->
                                    <div class="relative col-span-2">
                                        <input wire:model.defer="tenantForm.registration" type="text" id="registration-{{ $modalId }}" class="block px-2.5 pb-2.5 pt-4 w-full text-sm text-gray-900 bg-transparent rounded-lg border border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-[#0030C5] peer" placeholder=" " />
                                        <label for="registration-{{ $modalId }}" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 bg-white px-2 peer-focus:text-[#0030C5] peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 start-1">Registration</label>
                                        @error('tenantForm.registration') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                </div>
                            </div>

                        </div>

                        <!-- Save Button -->
                        <div class="flex justify-center pt-2">
                            <button type="submit" class="px-20 py-2.5 bg-[#070589] text-white text-sm font-semibold rounded-lg hover:bg-[#001445] focus:ring-4 focus:ring-blue-300 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="save">Transfer</span>
                                <span wire:loading wire:target="save">Processing...</span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif
</div>
