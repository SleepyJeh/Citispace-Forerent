@extends('layouts.app')

@section('content')
{{-- 
  This main div creates the two-column layout.
  - 'flex' for the columns.
  - 'min-h-screen' to fill the page height.
  - 'bg-white' for the default background (for mobile).
--}}
<div class="flex min-h-screen bg-white">
    
    <div class="w-full md:w-full flex flex-1 flex-col justify-center p-8 sm:p-12">
        {{-- 
          We place the Livewire component here.
          The form's content (logo, inputs) is inside this component.
          I've modified the component code below to fit this new layout.
        --}}
        <livewire:actions.login-form />
    </div>

    <div class="hidden flex-1 md:flex justify-center items-center">
        {{-- This div is purely decorative. --}}
        <div class=" w-full h-full max-w-3/4 max-h-3/4 bg-[var(--color-primary)] rounded-[var(--border-action)]">
          
        </div>
    </div>
</div>
@endsection