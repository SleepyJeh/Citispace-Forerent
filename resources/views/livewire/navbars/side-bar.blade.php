<nav class="w-0 md:w-64 flex-shrink-0 h-full overflow-y-auto bg-white">
    <aside id="sidebar-multi-level-sidebar"
           class="h-full bg-white border-r border-gray-200"
           aria-label="Sidebar">
        <div class="h-full px-3 py-6 overflow-y-auto flex flex-col">
            <!-- Logo -->
            <a href="{{ route($navigations['dashboard']['route']) }}" class="flex items-center justify-center mb-8 h-8 p-8">
                <x-icons.logo />
            </a>

            <!-- Main Navigation -->
            <ul class="space-y-2 font-medium flex-1">
                @foreach($navigations as $key => $navigation)
                    @if(isset($navigation['children']))
                        <!-- Nav with Dropdown -->
                        <li>
                            <button type="button"
                                    class="flex items-center w-full p-3 rounded-lg {{ $this->getActiveClass(null) }}"
                                    data-collapse-toggle="{{ Str::slug($navigation['label']) }}-dropdown"
                                    aria-controls="{{ Str::slug($navigation['label']) }}-dropdown">
                                <x-dynamic-component :component="$navigation['icon']" class="w-5 h-5 text-gray-500" />
                                <span class="flex-1 ms-3 text-left">{{ $navigation['label'] }}</span>
                                <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="m1 1 4 4 4-4" />
                                </svg>
                            </button>

                            <!-- Sub Navigation -->
                            <ul id="{{ Str::slug($navigation['label']) }}-dropdown" class="hidden py-2 space-y-2">
                                @foreach ($navigation['children'] as $child)
                                    <li>
                                        <a href="{{ route($navigation['route'], $child['query'] ?? []) }}"
                                           class="flex items-center w-full p-2 pl-11 rounded-lg">
                                            {{ $child['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <!-- Regular Nav -->
                        <li>
                            <a href="{{ route($navigation['route']) }}"
                               class="flex items-center p-3 text-gray-700 rounded-lg {{ $this->getActiveClass($navigation['route']) }}">
                                <x-dynamic-component :component="$navigation['icon']" />
                                <span class="ms-3">{{ $navigation['label'] }}</span>
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>

            <!-- Divider -->
            <div class="border-t border-gray-200 my-4"></div>

            <!-- Others Section -->
            <p class="px-3 mb-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">
                Others
            </p>

            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('settings') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group">
                        <x-icons.settings />
                        <span class="ms-3">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="flex items-center p-3 text-gray-700 rounded-lg hover:bg-[#DFE8FC] hover:text-[#070642] group">
                        <x-icons.logout />
                        <span class="ms-3">Log Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</nav>
