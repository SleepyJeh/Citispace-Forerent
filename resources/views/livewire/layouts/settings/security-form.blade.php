<div
    class="flex flex-col items-end w-full"
    x-data="{
        showCurrent: false,
        showNew: false,
        showConfirm: false,
        password: @entangle('password').live,
        requirements: {
            length: false,
            number: false,
            special: false,
            capital: false
        },
        validatePassword() {
            this.requirements.length = this.password.length >= 8;
            this.requirements.number = /[0-9]/.test(this.password);
            this.requirements.special = /[\W_]/.test(this.password);
            this.requirements.capital = /[A-Z]/.test(this.password);
        }
    }"
    x-init="$watch('password', () => validatePassword())"
>

    <div class="w-full bg-white rounded-[25px] shadow-sm p-10 md:p-14 border border-slate-100">

        <div class="space-y-6">

            {{-- 1. CURRENT PASSWORD --}}
            <div class="relative w-full">
                <input
                    :type="showCurrent ? 'text' : 'password'"
                    wire:model="current_password"
                    id="current_password_input"
                    autocomplete="off"
                    class="peer w-full h-14 border border-gray-400 rounded-lg pl-4 pr-12 pt-4 pb-1 outline-none text-gray-800 placeholder-transparent focus:border-[#0C0B50] focus:ring-1 focus:ring-[#0C0B50] transition-all bg-transparent z-10 relative"
                    placeholder=" "
                />
                <label for="current_password_input" class="absolute left-4 top-4 text-gray-500 text-sm transition-all duration-200 pointer-events-none peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-[#0C0B50] peer-focus:bg-white peer-focus:px-1 peer-not-placeholder-shown:-top-2.5 peer-not-placeholder-shown:text-xs peer-not-placeholder-shown:bg-white peer-not-placeholder-shown:px-1 z-10">
                    Current Password
                </label>
                <button type="button" @click="showCurrent = !showCurrent" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0C0B50] z-50 cursor-pointer p-2 focus:outline-none">
                    <svg x-show="!showCurrent" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="showCurrent" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
                @error('current_password') <span class="text-xs text-red-500 mt-1 ml-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 2. NEW PASSWORD --}}
            <div class="relative w-full">
                <input
                    :type="showNew ? 'text' : 'password'"
                    wire:model.live="password"
                    id="new_password_input"
                    autocomplete="new-password"
                    class="peer w-full h-14 border border-gray-400 rounded-lg pl-4 pr-12 pt-4 pb-1 outline-none text-gray-800 placeholder-transparent focus:border-[#0C0B50] focus:ring-1 focus:ring-[#0C0B50] transition-all bg-transparent z-10 relative"
                    placeholder=" "
                />
                <label for="new_password_input" class="absolute left-4 top-4 text-gray-500 text-sm transition-all duration-200 pointer-events-none peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-[#0C0B50] peer-focus:bg-white peer-focus:px-1 peer-not-placeholder-shown:-top-2.5 peer-not-placeholder-shown:text-xs peer-not-placeholder-shown:bg-white peer-not-placeholder-shown:px-1 z-10">
                    New Password
                </label>
                <button type="button" @click="showNew = !showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0C0B50] z-50 cursor-pointer p-2 focus:outline-none">
                    <svg x-show="!showNew" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="showNew" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
                @error('password') <span class="text-xs text-red-500 mt-1 ml-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- 3. CHECKLIST (JavaScript-driven validation) --}}
            <div class="bg-gray-50 rounded-lg p-4 text-xs space-y-2 border border-slate-100 transition-all duration-300">
                <p class="font-bold text-gray-700 mb-2">Your password must contain:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2">

                    {{-- Length Rule --}}
                    <div class="flex items-center gap-2 transition-all" :class="requirements.length ? 'text-green-600 font-bold' : 'text-slate-500'">
                        <span x-show="requirements.length" class="text-green-600">✓</span>
                        <span x-show="!requirements.length" class="text-red-500">✗</span>
                        <span>A minimum of 8 characters</span>
                    </div>

                    {{-- Special Char Rule --}}
                    <div class="flex items-center gap-2 transition-all" :class="requirements.special ? 'text-green-600 font-bold' : 'text-slate-500'">
                        <span x-show="requirements.special" class="text-green-600">✓</span>
                        <span x-show="!requirements.special" class="text-red-500">✗</span>
                        <span>At least 1 special character</span>
                    </div>

                    {{-- Number Rule --}}
                    <div class="flex items-center gap-2 transition-all" :class="requirements.number ? 'text-green-600 font-bold' : 'text-slate-500'">
                        <span x-show="requirements.number" class="text-green-600">✓</span>
                        <span x-show="!requirements.number" class="text-red-500">✗</span>
                        <span>At least one number</span>
                    </div>

                    {{-- Capital Rule --}}
                    <div class="flex items-center gap-2 transition-all" :class="requirements.capital ? 'text-green-600 font-bold' : 'text-slate-500'">
                        <span x-show="requirements.capital" class="text-green-600">✓</span>
                        <span x-show="!requirements.capital" class="text-red-500">✗</span>
                        <span>At least one uppercase letter</span>
                    </div>
                </div>
            </div>

            {{-- 4. CONFIRM PASSWORD --}}
            <div class="relative w-full">
                <input
                    :type="showConfirm ? 'text' : 'password'"
                    wire:model="password_confirmation"
                    id="confirm_password_input"
                    autocomplete="new-password"
                    class="peer w-full h-14 border border-gray-400 rounded-lg pl-4 pr-12 pt-4 pb-1 outline-none text-gray-800 placeholder-transparent focus:border-[#0C0B50] focus:ring-1 focus:ring-[#0C0B50] transition-all bg-transparent z-10 relative"
                    placeholder=" "
                />
                <label for="confirm_password_input" class="absolute left-4 top-4 text-gray-500 text-sm transition-all duration-200 pointer-events-none peer-placeholder-shown:top-4 peer-placeholder-shown:text-base peer-focus:-top-2.5 peer-focus:text-xs peer-focus:text-[#0C0B50] peer-focus:bg-white peer-focus:px-1 peer-not-placeholder-shown:-top-2.5 peer-not-placeholder-shown:text-xs peer-not-placeholder-shown:bg-white peer-not-placeholder-shown:px-1 z-10">
                    Confirm New Password
                </label>
                <button type="button" @click="showConfirm = !showConfirm" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#0C0B50] z-50 cursor-pointer p-2 focus:outline-none">
                    <svg x-show="!showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                    <svg x-show="showConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
            </div>

        </div>
    </div>

    <div class="mt-6">
        <button
            wire:click="updatePassword"
            class="bg-[#0C0B50] hover:bg-[#1a196e] text-white font-bold py-3 px-16 rounded-xl shadow-md transition-transform active:scale-95 text-sm"
        >
            Save
        </button>
    </div>

</div>
