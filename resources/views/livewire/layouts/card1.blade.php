<div class="{{ $bgColor }} {{ $textColor }} rounded-2xl p-6 shadow-lg">
    <div class="text-sm font-medium opacity-90 mb-2">
        {{ $title }}
    </div>
    <div class="text-3xl font-bold mb-1">
        {{ $value }}
    </div>
    @if($subtitle)
        <div class="text-xs opacity-75">
            {{ $subtitle }}
        </div>
    @endif
</div>