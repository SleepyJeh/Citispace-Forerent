@props(['isHeader' => false]) 

<td {{ $attributes->merge(['class' => 'py-3 md:py-5 pl-4 ' . ($isHeader ? 'text-blue-900 font-bold text-sm md:text-base' : 'text-blue-900 font-medium')]) }}>
    {{ $slot }}
</td>
