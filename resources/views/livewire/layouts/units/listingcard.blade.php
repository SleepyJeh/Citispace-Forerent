<div class="pl-3">
    <!-- Card Container with Blue Outline -->
    <div class="border-l-thick border-[#0030C5] border-t-1 border-r-1 border-b-1 rounded-2xl p-4 mb-4 bg-white shadow-sm hover:shadow-md transition-shadow">

        <!-- Header Section -->
        <div class="flex flex-col gap-2 mb-4">
            <div class="flex items-center gap-4">
                <h2 class="text-2xl font-bold text-gray-900">{{ $unitNumber }}</h2>

                @if($condition === 'Expiring Soon')
                <!-- Alert Badge for Expiration -->
                <span class="px-3 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800 flex items-center gap-1">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1313_2365)">
                            <path d="M14.4395 11.7651L9.3195 2.80514C9.20786 2.60815 9.04597 2.4443 8.85033 2.33031C8.6547 2.21631 8.43232 2.15625 8.2059 2.15625C7.97947 2.15625 7.7571 2.21631 7.56147 2.33031C7.36583 2.4443 7.20394 2.60815 7.0923 2.80514L1.9723 11.7651C1.85946 11.9606 1.80028 12.1824 1.80078 12.408C1.80128 12.6337 1.86144 12.8552 1.97514 13.0502C2.08885 13.2451 2.25207 13.4065 2.44826 13.518C2.64445 13.6295 2.86664 13.6872 3.0923 13.6851H13.3323C13.5569 13.6849 13.7774 13.6256 13.9718 13.5132C14.1662 13.4007 14.3276 13.2391 14.4398 13.0446C14.552 12.85 14.611 12.6294 14.611 12.4048C14.6109 12.1802 14.5518 11.9596 14.4395 11.7651Z" stroke="#C91C1C" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8.21289 6.00781V8.56781" stroke="#C91C1C" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M8.21289 11.125H8.21989" stroke="#C91C1C" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                    Expiring Soon
                </span>
                @else
                <!-- Checkmark Badge for Vacant -->
                <span class="px-3 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800 flex items-center gap-1">
                    <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8.52344 4.38938L9.89015 5.80682C10.0012 5.91973 10.1506 5.98298 10.3061 5.98298C10.4616 5.98298 10.611 5.91973 10.7221 5.80682L11.9699 4.51264C12.0788 4.39744 12.1398 4.24256 12.1398 4.08125C12.1398 3.91994 12.0788 3.76505 11.9699 3.64985L10.6032 2.23242" stroke="#066E17" stroke-width="0.96525" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.7905 1L6.08594 6.91624" stroke="#066E17" stroke-width="0.96525" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.76822 12.7092C5.57321 12.7092 7.03644 11.1917 7.03644 9.31969C7.03644 7.44771 5.57321 5.93018 3.76822 5.93018C1.96323 5.93018 0.5 7.44771 0.5 9.31969C0.5 11.1917 1.96323 12.7092 3.76822 12.7092Z" stroke="#066E17" stroke-width="0.96525" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ $condition }}
                </span>
                @endif

                <span class="px-3 py-0.5 rounded-full text-sm font-medium bg-blue-50 text-blue-800">
                    {{ $leaseType }}
                </span>
            </div>

            <!-- Address with Location Icon -->
            <div class="flex items-center text-sm text-gray-600">
                <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2 flex-shrink-0">
                    <path d="M10.8306 5.96509C10.8306 9.02004 7.44155 12.2016 6.30351 13.1843C6.19749 13.264 6.06844 13.3071 5.93579 13.3071C5.80314 13.3071 5.67409 13.264 5.56807 13.1843C4.43004 12.2016 1.04102 9.02004 1.04102 5.96509C1.04102 4.66691 1.55671 3.42191 2.47466 2.50396C3.39261 1.58601 4.63762 1.07031 5.93579 1.07031C7.23397 1.07031 8.47897 1.58601 9.39692 2.50396C10.3149 3.42191 10.8306 4.66691 10.8306 5.96509Z" stroke="#747474" stroke-width="0.795401" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M5.9371 7.79999C6.95084 7.79999 7.77264 6.97819 7.77264 5.96445C7.77264 4.95071 6.95084 4.12891 5.9371 4.12891C4.92336 4.12891 4.10156 4.95071 4.10156 5.96445C4.10156 6.97819 4.92336 7.79999 5.9371 7.79999Z" stroke="#747474" stroke-width="0.795401" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-base font-medium text-gray-900">{{ $address ?: $value }}</p>
            </div>

            <!-- Tenant with Tenant Icon (only for Expiring Soon) -->
            @if($condition === 'Expiring Soon')
            <div class="flex items-center text-sm text-gray-600">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-2 flex-shrink-0">
                    <path d="M12.3223 13.2232V11.9704C12.3223 11.3059 12.0584 10.6686 11.5885 10.1987C11.1186 9.72883 10.4813 9.46484 9.81673 9.46484H6.05833C5.39381 9.46484 4.7565 9.72883 4.28661 10.1987C3.81672 10.6686 3.55273 11.3059 3.55273 11.9704V13.2232" stroke="#747474" stroke-width="0.957" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M7.93724 6.96042C9.32105 6.96042 10.4428 5.83862 10.4428 4.45482C10.4428 3.07101 9.32105 1.94922 7.93724 1.94922C6.55344 1.94922 5.43164 3.07101 5.43164 4.45482C5.43164 5.83862 6.55344 6.96042 7.93724 6.96042Z" stroke="#747474" stroke-width="0.957" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="text-base font-medium text-gray-900">{{ $tenant ?? 'N/A' }}</p>
            </div>
            @endif
        </div>

        <!-- Content Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-2">

            <!-- Unit Price -->
            <div class="bg-gray-50 p-3 rounded-lg flex flex-col">
                <div class="flex items-center text-sm font-semibold text-gray-900 mb-1">
                    <svg width="13" height="14" viewBox="0 0 13 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
                        <path d="M11.744 6.37207H1" stroke="#0030C5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.744 3.68652H1" stroke="#0030C5" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.01562 13.087V1.6715C3.01562 1.49341 3.08637 1.32261 3.2123 1.19668C3.33823 1.07075 3.50903 1 3.68712 1H6.37312C7.44168 1 8.46647 1.42448 9.22206 2.18007C9.97764 2.93565 10.4021 3.96044 10.4021 5.029C10.4021 6.09756 9.97764 7.12235 9.22206 7.87793C8.46647 8.63352 7.44168 9.058 6.37312 9.058H3.01562" stroke="#0030C5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Unit Price
                </div>
                <p class="text-xl font-bold text-gray-900">{{ $price }}</p>
                <span class="text-xs text-gray-500 mt-0.5">per month</span>
            </div>

            <!-- For Expiring Soon: Lease Expiration Date -->
            @if($condition === 'Expiring Soon')
            <div class="bg-gray-50 p-3 rounded-lg flex flex-col">
                <div class="flex items-center text-sm font-semibold text-gray-900 mb-1">
                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
                        <path d="M4.33398 1V3.66667" stroke="#0030C5" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9.66602 1V3.66667" stroke="#0030C5" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.6667 2.33398H2.33333C1.59695 2.33398 1 2.93094 1 3.66732V13.0007C1 13.737 1.59695 14.334 2.33333 14.334H11.6667C12.403 14.334 13 13.737 13 13.0007V3.66732C13 2.93094 12.403 2.33398 11.6667 2.33398Z" stroke="#0030C5" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 6.33398H13" stroke="#0030C5" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Lease Expiration Date
                </div>
                <p class="text-xl font-bold text-gray-900">{{ $vacantSince }}</p>
                <div class="text-xs text-gray-500 mt-0.5">
                    Expected end date
                </div>
            </div>

            <!-- Days Until Expiration -->
            <div class="bg-orange-50 p-3 rounded-lg flex flex-col">
                <div class="flex items-center text-sm font-semibold text-orange-800 mb-1">
                    <svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
                        <g clip-path="url(#clip0_1313_2395)">
                            <path d="M7.89258 3.64062V7.21063L10.2726 8.40063" stroke="#FB964F" stroke-width="0.91" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M7.89336 13.1617C11.1795 13.1617 13.8434 10.4978 13.8434 7.21172C13.8434 3.92562 11.1795 1.26172 7.89336 1.26172C4.60726 1.26172 1.94336 3.92562 1.94336 7.21172C1.94336 10.4978 4.60726 13.1617 7.89336 13.1617Z" stroke="#FB964F" stroke-width="0.91" stroke-linecap="round" stroke-linejoin="round" />
                        </g>
                    </svg>
                    Days Until Expiration
                </div>
                <p class="text-xl font-bold text-orange-800">{{ $subtitle ?: '20 days' }}</p>
                <span class="text-xs text-orange-600 mt-0.5">action required</span>
            </div>
            @else
            <!-- For Vacant: Vacant Since Date -->
            <div class="bg-gray-50 p-3 rounded-lg flex flex-col">
                <div class="flex items-center text-sm font-semibold text-gray-900 mb-1">
                    <svg width="14" height="15" viewBox="0 0 14 15" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
                        <path d="M4.33398 1V3.66667" stroke="#0030C5" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M9.66602 1V3.66667" stroke="#0030C5" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.6667 2.33398H2.33333C1.59695 2.33398 1 2.93094 1 3.66732V13.0007C1 13.737 1.59695 14.334 2.33333 14.334H11.6667C12.403 14.334 13 13.737 13 13.0007V3.66732C13 2.93094 12.403 2.33398 11.6667 2.33398Z" stroke="#0030C5" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M1 6.33398H13" stroke="#0030C5" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Vacant Since
                </div>
                <p class="text-xl font-bold text-gray-900 text-[#0939C6]">{{ $vacantSince }}</p>
                <div class="text-xs text-gray-500 mt-0.5">
                    {{ $subtitle ?: '186 days' }}
                </div>
            </div>

            <!-- For Vacant: Lost Revenue -->
            <div class="bg-orange-50 p-3 rounded-lg flex flex-col">
                <div class="flex items-center text-sm font-semibold text-orange-800 mb-1">
                    <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg" class="mr-1">
                        <path d="M8.8 10.36H2.56C2.14626 10.36 1.74947 10.1956 1.45691 9.90309C1.16436 9.61053 1 9.21374 1 8.8V2.56C1 2.14626 1.16436 1.74947 1.45691 1.45691C1.74947 1.16436 2.14626 1 2.56 1H15.04C15.4537 1 15.8505 1.16436 16.1431 1.45691C16.4356 1.74947 16.6 2.14626 16.6 2.56V6.46" stroke="#FB964F" stroke-width="1.014" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M11.9199 11.1396L14.2599 13.4796L16.5999 11.1396" stroke="#FB964F" stroke-width="1.014" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M14.2617 8.7998V13.4798" stroke="#FB964F" stroke-width="1.014" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10.2173 5.50342H7.39062" stroke="#FB964F" stroke-width="0.47112" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M10.2173 4.79688H7.39062" stroke="#FB964F" stroke-width="0.47112" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M7.91992 7.2699V4.26651C7.91992 4.21966 7.93854 4.17472 7.97167 4.14159C8.0048 4.10846 8.04974 4.08984 8.09659 4.08984H8.80327C9.08441 4.08984 9.35403 4.20152 9.55282 4.40032C9.75161 4.59911 9.86329 4.86873 9.86329 5.14986C9.86329 5.431 9.75161 5.70062 9.55282 5.89941C9.35403 6.0982 9.08441 6.20988 8.80327 6.20988H7.91992" stroke="#FB964F" stroke-width="0.47112" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    Lost Revenue
                </div>
                <p class="text-xl font-bold text-orange-800">{{ $lostRevenue }}</p>
                <span class="text-xs text-orange-600 mt-0.5">estimate</span>
            </div>
            @endif
        </div>
    </div>
</div>