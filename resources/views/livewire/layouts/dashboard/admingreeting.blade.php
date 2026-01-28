<div class="relative w-full h-32 bg-gradient-to-br from-blue-950 via-blue-600 to-blue-950 rounded-2xl shadow-xl overflow-hidden">
    <!-- Glowing orb effect -->
    <div class="absolute -top-20 -right-20 w-full h-64 bg-blue-500 rounded-full opacity-30 blur-3xl"></div>

    <!-- Content -->
    <div class="relative z-10 p-6 flex items-center h-full">
        <p class="text-white text-lg font-medium">Hello, {{ auth()->check() ? auth()->user()->first_name : 'Guest' }}!</p>
    </div>
</div>
