<div class="max-w-md mx-auto mt-20 p-6 bg-white shadow rounded">
    <h1 class="text-2xl font-bold mb-6 text-center">Login</h1>

    @if (session('error'))
        <div class="p-3 bg-red-200 text-red-800 rounded mb-3">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="p-3 bg-green-200 text-green-800 rounded mb-3">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="login" class="space-y-4">
        <div>
            <label class="block font-medium">Email</label>
            <input type="email" wire:model.lazy="email" class="border p-2 w-full rounded">
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block font-medium">Password</label>
            <input type="password" wire:model.lazy="password" class="border p-2 w-full rounded">
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center space-x-2">
            <input type="checkbox" wire:model="remember" id="remember">
            <label for="remember" class="text-sm">Remember me</label>
        </div>

        <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded w-full">
            Login
        </button>
    </form>
</div>
