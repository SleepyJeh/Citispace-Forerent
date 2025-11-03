@extends ('layouts.app')

@section('content')
<div class="flex flex-row min-h-screen">
    <!-- Navigations -->
    <livewire:navbars.side-bar />

    <section id="main-container" class="flex-1 h-screen flex flex-col overflow-hidden">
        <div class="flex-shrink-0 bg-white z-30">
            <livewire:layouts.top-bar />
        </div>

        <div class="flex-1 overflow-y-auto min-h-full">
            <div id="pm-container" class="w-full h-full rounded-tl-4xl bg-[#F4F7FC] flex flex-col px-4 md:px-8 lg:px-18 pt-9 pb-16">
                <div class="p-8 font-body">

                    <div class="mb-8">
                        <h1 class="text-2xl font-semibold text-primary mb-1">SETTINGS</h1>
                        <p class="text-gray-600 text-sm">View and record property or unit</p>
                    </div>

                    <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                        <ul class=" flex flex-wrap -mb-px text-sm font-medium text-center" id="settings-tab"
                            data-tabs-toggle="#settings-tab-content"
                            role="tablist"
                            data-tabs-active-classes="text-primary border-primary"
                            data-tabs-inactive-classes="text-gray-600 hover:text-primary border-transparent hover:border-gray-300">

                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="personal-info-tab" data-tabs-target="#personal-info" type="button" role="tab" aria-controls="personal-info" aria-selected="true">Personal Information</button>
                            </li>
                            <li class="me-2" role="presentation">
                                <button class="inline-block p-4 border-b-2 rounded-t-lg" id="security-tab" data-tabs-target="#security" type="button" role="tab" aria-controls="security" aria-selected="false">Security</button>
                            </li>
                        </ul>
                    </div>

                    <div id="settings-tab-content">

                        <div class="p-4 rounded-lg dark:bg-gray-800" id="personal-info" role="tabpanel" aria-labelledby="personal-info-tab">

                            <livewire:actions.settings-form />

                        </div>

                        <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="security" role="tabpanel" aria-labelledby="security-tab">
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                This is the <strong class="font-medium text-gray-800 dark:text-white">Security</strong> tab.
                                You can add your password change form or two-factor authentication settings here.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
