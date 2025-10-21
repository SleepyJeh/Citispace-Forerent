@props([
    'href' => '#', // Default href to '#'
    'text' => 'Add Item' // Default text
])

<a href="{{ $href }}"
   {{ $attributes->merge(['class' => 'inline-flex items-center justify-center gap-2 px-4 py-2 text-sm font-bold text-white bg-[#003CC1] rounded-lg shadow-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all']) }}>

    {{-- Plus Icon SVG --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
    </svg>

    {{-- Button Text --}}
    <span>{{ $text }}</span>
</a>