{{--
  This component shows the list of announcements.
  It's set up with static data from the image.
--}}
<div class="bg-white rounded-lg shadow-sm overflow-hidden flex flex-col">
    {{-- Card Header --}}
    <div class="flex justify-between items-center p-4 bg-blue-900 text-white">
        <h3 class="font-semibold text-lg">Announcement</h3>
        <button class="text-2xl font-light hover:bg-blue-800 rounded-full w-8 h-8 flex items-center justify-center">+</button>
    </div>

    {{-- Card Body --}}
    <div class="p-4 flex-1">
        <ul class="space-y-4">
            {{-- Announcement Item 1 --}}
            <li class="flex items-start gap-4">
                <div class="flex-shrink-0 flex flex-col items-center">
                    <span class="text-xs font-semibold text-gray-500">OCT</span>
                    <span class="text-lg font-bold text-gray-800">1</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Rent Increase Notification</h4>
                    <p class="text-sm text-gray-600">This is a notification that the monthly rent for all units will be increased effective December 1, 2025.</p>
                </div>
            </li>

            {{-- Divider --}}
            <li class="border-t border-gray-200"></li>

            {{-- Announcement Item 2 --}}
            <li class="flex items-start gap-4">
                <div class="flex-shrink-0 flex flex-col items-center">
                    <span class="text-xs font-semibold text-gray-500">OCT</span>
                    <span class="text-lg font-bold text-gray-800">15</span>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900">Rent Increase Notification</h4>
                    <p class="text-sm text-gray-600">This is a notification that the monthly rent for all units will be increased effective December 1, 2025.</p>
                </div>
            </li>
        </ul>
    </div>
</div>
