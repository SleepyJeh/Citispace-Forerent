<div class="w-full">

    {{-- Stepper Navigation Container (Centered with max-width) --}}
    <div class="max-w-4xl mx-auto">
        <ol class="flex items-center w-full pt-4 pb-12">
            @foreach ($steps as $step => $label)
                @php
                    $isActive = $currentStep == $step;
                    $isComplete = $currentStep > $step;
                    $isLast = $step == count($steps);
                @endphp

               <li class="flex items-center flex-1
                    {{ $isLast ? '' : "after:content-[''] after:w-full after:h-0.5 after:border-b after:inline-block" }}
                    {{ $isComplete ? 'text-[#0030C5] after:border-[#0030C5]' : 'text-gray-500 after:border-[#D4D4D4]' }}">

                    {{-- Step Circle and Label Container --}}
                    <div class="flex flex-col items-center">
                        {{-- Circle --}}
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-2
                            {{ $isActive ? 'bg-[#0030C5] border-[#0030C5]' : ($isComplete ? 'bg-[#0030C5] border-transparent' : 'bg-white border-[#D4D4D4]') }}
                            text-base font-semibold
                            {{ $isActive ? 'text-white' : ($isComplete ? 'text-white' : 'text-gray-500') }}
                            transition-colors duration-300">
                            {{ $step }}
                        </div>

                        {{-- Label --}}
                        <span class="mt-2 text-sm text-center transition-colors duration-300 whitespace-nowrap
                            {{ $isActive ? 'text-[#0030C5] font-semibold' : 'text-gray-500' }}">
                            {{ $label }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>

    {{-- Step Content Container --}}
    <div id="form_container" class="bg-white p-6 rounded-2xl shadow-xl min-h-[400px] border border-gray-200">
        @if ($currentStep == 1)
            @include('components.layouts.stepper1')
        @elseif ($currentStep == 2)
            @include('components.layouts.stepper2')
        @elseif ($currentStep == 3)
            @include('components.layouts.stepper3')
        @elseif ($currentStep == 4)
            @include('components.layouts.stepper4')
        @endif
    </div>
</div>
