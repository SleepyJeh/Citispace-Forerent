<div class="relative w-full h-32 bg-gradient-to-r from-blue-950 via-blue-800 to-blue-600 rounded-2xl shadow-xl overflow-hidden">
    
    <!-- Circular ring effects (right side decoration) -->
    <div class="absolute -right-10 top-1/2 -translate-y-1/2 w-48 h-48 border-2 border-blue-400 rounded-full opacity-20"></div>
    <div class="absolute -right-4 top-1/2 -translate-y-1/2 w-36 h-36 border-2 border-blue-400 rounded-full opacity-20"></div>
    <div class="absolute right-4 top-1/2 -translate-y-1/2 w-24 h-24 border-2 border-blue-400 rounded-full opacity-20"></div>

    <!-- Content -->
    <div class="relative z-10 px-8 flex items-center justify-between h-full w-full">
        
        <!-- Left: Greeting -->
        <div class="flex flex-col justify-center">
            <p class="text-blue-300 text-xs font-semibold uppercase tracking-widest mb-1">Property Owner</p>
            <h1 class="text-white text-3xl font-bold leading-tight">
                Welcome Back, 
                <span class="text-cyan-400">{{ auth()->check() ? strtoupper(auth()->user()->first_name) : 'GUEST' }}!</span>
            </h1>
            <p class="text-blue-200 text-sm mt-1">Here's what's happening with your properties today</p>
        </div>

        <!-- Right: Time & Date -->
        <div class="flex flex-col items-end justify-center">
            <p class="text-white text-4xl font-bold" id="greeting-time"></p>
            <p class="text-blue-200 text-sm mt-1" id="greeting-date"></p>
        </div>

    </div>
</div>

<!-- Live clock script -->
<script>
    function updateClock() {
        const now = new Date();
        const time = now.toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit', hour12: true });
        const date = now.toLocaleDateString('en-US', { weekday: 'long', month: 'long', day: 'numeric', year: 'numeric' });
        document.getElementById('greeting-time').textContent = time;
        document.getElementById('greeting-date').textContent = date;
    }
    updateClock();
    setInterval(updateClock, 1000);
</script>