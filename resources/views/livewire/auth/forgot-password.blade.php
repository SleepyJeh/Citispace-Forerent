<div class="w-full max-w-md mx-auto">
    {{-- Reusing your Logo SVG --}}
    <svg viewBox="0 0 625 170" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-64 mb-8">
       {{-- ... (Paste the same SVG content from your login.blade.php here) ... --}}
       <path d="M52.5666 71.1602L69.1707 83.4063L69.1707 110.519L54.0836 110.519C54.0836 110.519 47.0824 110.519 46.2091 94.6596C45.7564 86.4386 52.5666 71.1602 52.5666 71.1602Z" fill="#001C64"/>
       {{-- (Shortened for brevity, just copy the full SVG from login) --}}
    </svg>

    <h1 class="text-3xl text-left font-bold mb-2 text-[var(--color-primary)]">Reset Password</h1>
    <p class="text-gray-500 mb-8 text-sm">Enter your email and we'll send you a link to reset your password.</p>

    @if (session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Success!</span> {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="sendResetLink" class="space-y-6">
        {{-- Email Input --}}
        <div>
            <div class="relative">
                <input
                    type="email"
                    id="email"
                    wire:model="email"
                    class="block w-full px-4 pt-4 pb-2.5 font-semibold text-indigo-900 bg-transparent rounded-xl border-2 border-gray-300 shadow-sm appearance-none focus:outline-none focus:border-blue-500 peer"
                    placeholder=" " />
                <label for="email" class="absolute text-sm text-gray-500 duration-300 transform -translate-y-4 scale-75 top-2 z-10 origin-[0] bg-white px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-4 start-4">
                    Email Address
                </label>
            </div>
            @error('email') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="bg-[var(--color-primary)] text-white py-3 px-4 rounded-xl w-full font-semibold shadow-md hover:bg-blue-700 transition-colors">
            Send Reset Link
        </button>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:text-blue-600 font-medium">
                Back to Login
            </a>
        </div>
    </form>
</div>
