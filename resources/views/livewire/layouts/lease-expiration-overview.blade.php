
<div class="w-full bg-white rounded-2xl shadow-md">


    <div class="bg-gradient-to-r from-blue-700 to-blue-600 text-white p-4 md:p-6 rounded-t-2xl">
        <h3 class="text-xl lg:text-2xl font-bold">
            Lease Expiration Overview
        </h3>
        <p class="text-sm text-blue-100 mt-1">
            Monitor upcoming lease expiration
        </p>
    </div>

    <div class="p-4 md:p-6 space-y-4">

        <div class="bg-blue-50 rounded-2xl p-4 flex items-center gap-4">
            {{-- Icon --}}
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-blue-600 text-white rounded-lg">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
            </div>
            {{-- Text --}}
            <div>
                <p class="text-sm font-medium text-blue-700">Expiring This Month</p>
                <p class="text-2xl font-bold text-blue-900">{{ $expiringThisMonth }} {{ Str::plural('Unit', $expiringThisMonth) }}</p>
            </div>
        </div>

        <div class="bg-blue-50 rounded-2xl p-4 flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-blue-600 text-white rounded-lg">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008z" />
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-blue-700">Next 30 Days</p>
                <p class="text-2xl font-bold text-blue-900">{{ $expiringNext30Days }} {{ Str::plural('Unit', $expiringNext30Days) }}</p>
            </div>
        </div>

        <div class="bg-blue-50 rounded-2xl p-4 flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-blue-600 text-white rounded-lg">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                </svg>
            </div>

            <div>
                <p class="text-sm font-medium text-blue-700">Next 60 Days</p>
                <p class="text-2xl font-bold text-blue-900">{{ $expiringNext60Days }} {{ Str::plural('Unit', $expiringNext60Days) }}</p>
            </div>
        </div>

        <div class="bg-blue-50 rounded-2xl p-4 flex items-center gap-4">
            <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center bg-blue-600 text-white rounded-lg">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium text-blue-700">45 Days</p>
                <p class="text-2xl font-bold text-blue-900">{{ $avgTurnaroundTime }} Days</p>
            </div>
            <div class="text-sm text-gray-500">
                Avg Time
            </div>
        </div>

    </div>
</div>
