@extends('layouts.app')

{{-- 1. Pass the Title and Subtitle to the Main Layout --}}
@section('header-title', 'MESSAGE')
@section('header-subtitle', 'View and send messages')

@section('content')

    {{-- 2. Your Page Content Starts Here --}}
    {{-- Since the layout handles the background and padding, you just put the specific content here. --}}

    <div class="p-4">
        {{-- You can add your message list or chat component here later --}}
        <p class="text-gray-500">Select a conversation to start messaging.</p>
    </div>

@endsection
