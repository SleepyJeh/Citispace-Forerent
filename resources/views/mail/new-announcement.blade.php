@php
    // Brand colors (consistent with your dashboard)
    $primaryColor = '#2563EB';   // Blue-600
    $secondaryColor = '#1E3A8A'; // Blue-900
    $backgroundColor = '#F4F7FC'; // Light neutral background
@endphp

<x-mail::message>
    {{-- Greeting --}}
    @if(!empty($intro))
        <p style="font-size: 16px; color: {{ $secondaryColor }}; margin-bottom: 20px; white-space: pre-line;">
            {{ $intro }}
        </p>
    @endif

    {{-- Property & Announcement --}}
    <h1 style="color: {{ $secondaryColor }}; font-size: 22px; margin-bottom: 6px;">🏢 {{ $propertyName }}</h1>
    <h2 style="color: {{ $primaryColor }}; font-size: 20px; margin-bottom: 12px;">{{ $title }}</h2>

    <p style="color: #1f2937; font-size: 15px; line-height: 1.7; margin-bottom: 24px;">
        {{ $description }}
    </p>

    <hr style="border: none; border-top: 1px solid #e5e7eb; margin: 24px 0;">

    {{-- Role-Specific Guidance --}}
    <x-mail::panel>
        @if(strtolower($recipientRole) === 'manager')
            As a valued manager, please ensure this update is communicated to your team and residents.
            Should you require further clarification, kindly reach out to the property administrator.
        @elseif(strtolower($recipientRole) === 'tenant')
            This announcement is shared to keep you informed and updated.
            For additional information, you may contact your building’s management office.
        @else
            This notice applies across all managed properties.
            Please check your portal for more updates or contact your property manager for assistance.
        @endif
    </x-mail::panel>

    {{-- CTA Button --}}
    <x-mail::button :url="route('home')"
                    style="background-color: {{ $primaryColor }}; border-color: {{ $primaryColor }}; text-transform: uppercase; font-weight: 600;">
        View Announcement
    </x-mail::button>

    {{-- Footer --}}
    <div style="margin-top: 36px; border-top: 1px solid #E5E7EB; padding-top: 16px; color: {{ $secondaryColor }}; font-size: 14px; line-height: 1.7;">
        Sincerely,<br>
        <strong style="font-size: 15px;">{{ config('app.name') }}</strong><br>
        <em>Modern solutions for seamless property management</em>
    </div>
</x-mail::message>
