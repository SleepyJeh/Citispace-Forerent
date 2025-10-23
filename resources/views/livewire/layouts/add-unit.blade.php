<div>
   
    {{-- 💡 REVISED STEPPER DESIGN --}}
    {{-- This stepper is rebuilt to exactly match your new image --}}
    <ol class="flex items-start justify-between w-full pt-4 pb-12 px-4 md:px-8">
        @foreach ($steps as $step => $label)
            @php
                $isActive = $currentStep == $step;
                $isLast = $step == count($steps);
            @endphp
    
            <li class="flex flex-col items-center flex-shrink-0">
                <div class="flex items-center justify-center w-8 h-8 rounded-full
                    {{ $isActive ? 'bg-[#070642] text-white' : 'bg-gray-200 text-gray-700' }}">
                    <span class="font-medium">{{ $step }}</span>
                </div>
                <span class="mt-2 text-sm text-center
                    {{ $isActive ? 'text-[#070642] font-bold' : 'text-gray-400 font-normal' }}">
                    {{ $label }}
                </span>
            </li>
    
            @if(!$isLast)
                {{-- This line is pushed down 1rem (mt-4) to align with the center of the 2rem (h-8) circle --}}
                <li class="flex-auto h-0.5 bg-gray-200 mt-4 mx-2"></li>
            @endif
        @endforeach
    </ol>
    {{-- END REVISED STEPPER --}}


    
    <div class="bg-white rounded-xl shadow-lg border border-gray-200">
        {{-- This 3-step logic remains correct --}}
        @if ($currentStep == 1)
            @include('livewire.layouts.stepper1')
        @elseif ($currentStep == 2)
            @include('livewire.layouts.stepper2')
        @elseif ($currentStep == 3)
            @include('livewire.layouts.stepper3')
        @endif
    </div>
</div>
