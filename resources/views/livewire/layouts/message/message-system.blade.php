<div class="bg-white rounded-[20px] shadow-sm flex h-full overflow-hidden border border-slate-200 font-sans relative">

    {{-- ================================================= --}}
    {{-- PANE 1: CHAT LIST (Always Visible) --}}
    {{-- ================================================= --}}
    <div class="w-[300px] xl:w-[340px] flex-shrink-0 flex flex-col border-r border-slate-100">

        <div class="p-6 pb-2">
            <h2 class="text-[#0C0B50] font-bold text-base mb-4">CHATS</h2>

            {{-- Search Bar --}}
            <div class="relative mb-6">
                <input
                    type="text"
                    placeholder="Search"
                    wire:model.live="search"
                    class="w-full bg-[#F8F9FB] border border-slate-200 rounded-lg py-2 pl-4 pr-10 text-xs focus:outline-none focus:ring-1 focus:ring-blue-500 placeholder-slate-400"
                >
                <svg class="w-4 h-4 text-slate-400 absolute right-3 top-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>

            {{-- Tabs --}}
            <div class="flex gap-6 border-b border-slate-100 mb-2">

                {{-- TAB 1: OWNERS (Role: landlord) --}}
                <button
                    wire:click="$set('activeTab', 'landlord')"
                    class="pb-2 text-sm font-bold transition-all relative {{ $activeTab === 'landlord' ? 'text-[#0C0B50]' : 'text-slate-400' }}"
                >
                    Owner
                    @if($activeTab === 'landlord') <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#0C0B50] rounded-t-full"></div> @endif
                </button>

                {{-- TAB 2: MANAGERS (Role: manager) --}}
                <button
                    wire:click="$set('activeTab', 'manager')"
                    class="pb-2 text-sm font-bold transition-all relative {{ $activeTab === 'manager' ? 'text-[#0C0B50]' : 'text-slate-400' }}"
                >
                    Manager
                    @if($activeTab === 'manager') <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#0C0B50] rounded-t-full"></div> @endif
                </button>
            </div>
        </div>

        {{-- Dynamic Chat List --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar px-3 space-y-1">
            @foreach($chats as $chat)
                <button
                    {{-- FIX 1: Use $chat->user_id instead of $chat['id'] --}}
                    wire:click="selectChat({{ $chat->user_id }})"
                    {{-- FIX 2: Use $selectedUserId instead of $selectedChatId --}}
                    class="w-full flex items-center p-3 rounded-xl transition-colors {{ $selectedUserId === $chat->user_id ? 'bg-blue-50' : 'hover:bg-slate-50' }}"
                >
                    <div class="relative">
                        {{-- FIX 3: Access properties with -> arrow syntax --}}
                        <img src="{{ $chat->profile_img ?? 'https://ui-avatars.com/api/?name=' . $chat->first_name }}" class="w-10 h-10 rounded-full object-cover border border-slate-100">

                        @if($chat->unread_count > 0)
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-blue-600 text-white text-[9px] font-bold flex items-center justify-center rounded-full border-2 border-white">{{ $chat->unread_count }}</div>
                        @endif
                    </div>
                    <div class="ml-3 text-left flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-0.5">
                            <h4 class="text-xs font-bold text-[#0C0B50] truncate">{{ $chat->first_name }} {{ $chat->last_name }}</h4>
                            <span class="text-[9px] text-slate-400">{{ $chat->last_time }}</span>
                        </div>
                        <p class="text-[10px] text-slate-500 truncate {{ $chat->unread_count > 0 ? 'font-bold text-slate-700' : '' }}">
                            {{ $chat->last_message }}
                        </p>
                    </div>
                </button>
            @endforeach
        </div>
    </div>


    {{-- ================================================= --}}
    {{-- PANE 2: CONVERSATION --}}
    {{-- ================================================= --}}
    <div class="flex-1 flex flex-col bg-white transition-all duration-300">

        @if($activeChatUser)
            {{-- Header --}}
            <div
                wire:click="toggleProfile"
                class="h-16 px-6 flex items-center border-b border-slate-50 shadow-sm z-10 cursor-pointer hover:bg-slate-50 transition-colors"
            >
                <img src="{{ $activeChatUser->profile_img ?? 'https://ui-avatars.com/api/?name=' . $activeChatUser->first_name }}" class="w-9 h-9 rounded-full object-cover">
                <div class="ml-3 flex-1">
                    <h3 class="text-[#0C0B50] font-bold text-sm">{{ $activeChatUser->first_name }} {{ $activeChatUser->last_name }}</h3>
                    <p class="text-[10px] text-slate-500">{{ ucfirst($activeChatUser->role) }}</p>
                </div>
                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>

            {{-- Messages Area --}}
            <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-6 bg-white">
                @forelse($activeMessages as $msg)
                    <div class="flex w-full {{ $msg->sender_id === auth()->id() ? 'justify-end' : 'justify-start' }}">

                        {{-- Avatar (Them) --}}
                        @if($msg->sender_id !== auth()->id())
                            <img src="{{ $activeChatUser->profile_img ?? 'https://ui-avatars.com/api/?name=' . $activeChatUser->first_name }}" class="w-8 h-8 rounded-full mr-2 self-start mt-1">
                        @endif

                        <div class="flex flex-col max-w-[65%] {{ $msg->sender_id === auth()->id() ? 'items-end' : 'items-start' }}">
                            <div class="px-5 py-3 text-sm rounded-2xl shadow-sm
                                {{ $msg->sender_id === auth()->id()
                                    ? 'bg-[#C8D9FD] text-[#0C0B50] rounded-br-none'
                                    : 'bg-[#0C0A84] text-white rounded-bl-none'
                                }}">

                                @if($msg->type === 'file')
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                                        <a href="{{ Storage::url($msg->file_path) }}" target="_blank" class="underline italic hover:text-blue-800">{{ $msg->message }}</a>
                                    </div>
                                @else
                                    {{ $msg->message }}
                                @endif
                            </div>
                            <span class="text-[9px] text-slate-300 mt-1 px-1">{{ $msg->created_at->format('g:i A') }}</span>
                        </div>

                        {{-- Avatar (Me) --}}
                        @if($msg->sender_id === auth()->id())
                            <div class="w-8 h-8 ml-2 rounded-full bg-slate-200 border border-white flex items-center justify-center overflow-hidden self-start mt-1">
                                <span class="text-[9px] font-bold text-slate-500">Me</span>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="flex h-full items-center justify-center text-slate-400 text-xs">
                        No messages yet. Say hello!
                    </div>
                @endforelse
            </div>

             {{-- INPUT AREA  #C8D9FD --}}
             <div class="p-4 bg-white border-t border-slate-50">

                {{-- 1. ATTACHMENT PREVIEW (Shows only if file is selected) --}}
                @if($attachment)
                    <div class="flex items-center gap-2 mb-3 px-1 animate-in slide-in-from-bottom-2 fade-in duration-200">
                        <div class="relative flex items-center gap-3 bg-slate-100 rounded-xl p-2 pr-4 shadow-sm border border-slate-200">

                            {{-- Image Preview or File Icon --}}
                            @if(Str::startsWith($attachment->getMimeType(), 'image/'))
                                <img src="{{ $attachment->temporaryUrl() }}" class="w-10 h-10 object-cover rounded-lg border border-slate-200">
                            @else
                                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-slate-400 border border-slate-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                </div>
                            @endif

                            {{-- Filename --}}
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-slate-700 truncate max-w-[150px]">{{ $attachment->getClientOriginalName() }}</span>
                                <span class="text-[10px] text-slate-400">Ready to send</span>
                            </div>

                            {{-- Remove Button (X) --}}
                            <button
                                type="button"
                                wire:click="$set('attachment', null)"
                                class="absolute -top-2 -right-2 bg-white text-slate-400 hover:text-red-500 rounded-full p-0.5 shadow-md border border-slate-200 transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </div>
                @endif

                {{-- 2. INPUT FORM --}}
                <form
                    wire:submit.prevent="sendMessage"
                    class="flex items-center bg-white border border-slate-200 rounded-full px-2 py-1.5 shadow-sm focus-within:ring-2 focus-within:ring-blue-100 transition-all"
                >
                    <input
                        type="text"
                        wire:model.live="messageInput"
                        placeholder="Type a message here"
                        class="flex-1 border-none focus:ring-0 text-sm px-4 placeholder-slate-400 text-slate-700 bg-transparent"
                    >

                    <div class="flex items-center gap-1 pr-1">
                        {{-- Hidden File Input --}}
                        <input type="file" id="file-upload" class="hidden" wire:model="attachment">

                        {{-- Paperclip Icon --}}
                        <button type="button" onclick="document.getElementById('file-upload').click()" class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                        </button>

                        {{-- Send Button --}}
                        <button type="submit" class="p-2 bg-[#E6F0FF] text-[#0C0B50] rounded-full hover:bg-blue-100 active:scale-95 transition-transform">
                            <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </button>
                    </div>
                </form>
            </div>

        @else
            <div class="flex-1 flex flex-col items-center justify-center text-slate-400">
                <p>Select a conversation to start messaging.</p>
            </div>
        @endif
    </div>


    {{-- ================================================= --}}
    {{-- PANE 3: PROFILE (Right) --}}
    {{-- ================================================= --}}
    @if($showProfile && $activeChatUser)
        <div class="w-[280px] flex-shrink-0 bg-white border-l border-slate-100 flex flex-col p-6 overflow-y-auto custom-scrollbar animate-in slide-in-from-right duration-300">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-[#0C0B50] font-bold text-sm">Account Information</h3>
                <button wire:click="toggleProfile" class="text-slate-400 hover:text-red-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="flex flex-col items-center mb-8">
                <div class="p-1 rounded-full border border-blue-100 mb-3">
                    <img src="{{ $activeChatUser->profile_img ?? 'https://ui-avatars.com/api/?name=' . $activeChatUser->first_name }}" class="w-20 h-20 rounded-full object-cover">
                </div>
                <h2 class="text-[#0C0B50] font-bold text-base">{{ $activeChatUser->first_name }} {{ $activeChatUser->last_name }}</h2>
                <p class="text-xs text-blue-500 font-medium">{{ ucfirst($activeChatUser->role) }}</p>
            </div>

            <div class="space-y-4 mb-8">
                <div class="flex justify-between">
                    <span class="text-xs text-slate-400">Email</span>
                    <span class="text-xs font-bold text-slate-800">{{ $activeChatUser->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-xs text-slate-400">Contact</span>
                    <span class="text-xs font-bold text-slate-800">{{ $activeChatUser->contact }}</span>
                </div>
            </div>
        </div>
    @endif

</div>
