@extends('layouts.app')

{{-- 1. Pass the Title and Subtitle to the Main Layout --}}
@section('header-title', 'SETTINGS')
{{-- Note: I kept your subtitle, but you might want to change it since "View and record property" sounds like the Property page --}}
@section('header-subtitle', 'View and update your profile settings')

@section('content')

    {{-- 2. Tabs Navigation --}}
    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
        <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="settings-tab"
            data-tabs-toggle="#settings-tab-content"
            role="tablist"
            data-tabs-active-classes="text-primary border-primary"
            data-tabs-inactive-classes="text-gray-600 hover:text-primary border-transparent hover:border-gray-300">

            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="personal-info-tab" data-tabs-target="#personal-info" type="button" role="tab" aria-controls="personal-info" aria-selected="true">
                    Personal Information
                </button>
            </li>
            <li class="me-2" role="presentation">
                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="security-tab" data-tabs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">
                    Security
                </button>
            </li>
        </ul>
    </div>

    {{-- 3. Tab Content Areas --}}
    <div id="settings-tab-content">

        {{-- Personal Info Tab --}}
        <div class="p-4 rounded-lg dark:bg-gray-800" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">
            {{-- CRITICAL: Your backend logic is preserved here --}}
            <livewire:actions.settings-form />
        </div>

        {{-- Security Tab --}}
        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="security" role="tabpanel" aria-labelledby="security-tab">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                This is the <strong class="font-medium text-gray-800 dark:text-white">Security</strong> tab.
                You can add your password change form or two-factor authentication settings here.
            </p>
        </div>
    </div>

@endsection
