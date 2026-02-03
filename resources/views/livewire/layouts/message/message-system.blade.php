<div class="bg-white rounded-[20px] shadow-sm flex h-full overflow-hidden border border-slate-200 font-sans">

    {{-- CHAT LIST  --}}
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
                <button
                    wire:click="$set('activeTab', 'owner')"
                    class="pb-2 text-sm font-bold transition-all relative {{ $activeTab === 'owner' ? 'text-[#0C0B50]' : 'text-slate-400' }}"
                >
                    Owner
                    @if($activeTab === 'owner') <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#0C0B50] rounded-t-full"></div> @endif
                </button>
                <button
                    wire:click="$set('activeTab', 'tenant')"
                    class="pb-2 text-sm font-bold transition-all relative {{ $activeTab === 'tenant' ? 'text-[#0C0B50]' : 'text-slate-400' }}"
                >
                    Tenant
                    @if($activeTab === 'tenant') <div class="absolute bottom-0 left-0 w-full h-[3px] bg-[#0C0B50] rounded-t-full"></div> @endif
                </button>
            </div>
        </div>

        {{-- List --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar px-3 space-y-1">
            @foreach($chats as $chat)
                <button
                    wire:click="selectChat({{ $chat['id'] }})"
                    class="w-full flex items-center p-3 rounded-xl transition-colors {{ $selectedChatId === $chat['id'] ? 'bg-blue-50' : 'hover:bg-slate-50' }}"
                >
                    <div class="relative">
                        <img src="{{ $chat['avatar'] }}" class="w-10 h-10 rounded-full object-cover border border-slate-100">
                        @if($chat['unread'] > 0)
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-blue-600 text-white text-[9px] font-bold flex items-center justify-center rounded-full border-2 border-white">{{ $chat['unread'] }}</div>
                        @endif
                    </div>
                    <div class="ml-3 text-left flex-1 min-w-0">
                        <div class="flex justify-between items-center mb-0.5">
                            <h4 class="text-xs font-bold text-[#0C0B50] truncate">{{ $chat['name'] }}</h4>
                            <span class="text-[9px] text-slate-400">{{ $chat['date'] }}</span>
                        </div>
                        <p class="text-[10px] text-slate-500 truncate">{{ $chat['last_msg'] }}</p>
                    </div>
                </button>
            @endforeach
        </div>
    </div>


     {{--  CONVERSATION --}}
     <div class="flex-1 flex flex-col bg-white">

        {{-- Header --}}
        <div class="h-16 px-6 flex items-center border-b border-slate-50 shadow-sm z-10">
            <img src="{{ $activeChatUser['avatar'] }}" class="w-9 h-9 rounded-full object-cover">
            <div class="ml-3">
                <h3 class="text-[#0C0B50] font-bold text-sm">{{ $activeChatUser['name'] }}</h3>
                <p class="text-[10px] text-slate-500">{{ $activeChatUser['role'] }}</p>
            </div>
        </div>

        {{-- Messages --}}
        <div class="flex-1 overflow-y-auto custom-scrollbar p-6 space-y-6 bg-white">
            <div class="text-center mb-4">
                <span class="text-[10px] text-slate-400">March 6, 2025</span>
            </div>

            @foreach($messages as $msg)
                <div class="flex w-full {{ $msg['sender'] === 'me' ? 'justify-end' : 'justify-start' }}">
                    {{-- Avatar for Them --}}
                    @if($msg['sender'] === 'them')
                        <img src="{{ $activeChatUser['avatar'] }}" class="w-8 h-8 rounded-full mr-2 self-start mt-1">
                    @endif

                    <div class="flex flex-col max-w-[65%] {{ $msg['sender'] === 'me' ? 'items-end' : 'items-start' }}">
                        {{-- Bubble --}}
                        <div class="px-5 py-3 text-sm rounded-2xl shadow-sm
                            {{ $msg['sender'] === 'me'
                                ? 'bg-[#C8D9FD] text-[#0C0B50] rounded-br-none'
                                : 'bg-[#0C0A84] text-white rounded-bl-none'
                            }}">
                            {{ $msg['text'] }}
                        </div>
                        <span class="text-[9px] text-slate-300 mt-1 px-1">{{ $msg['time'] }}</span>
                    </div>

                    {{-- Avatar for Me --}}
                    @if($msg['sender'] === 'me')
                        <div class="w-8 h-8 ml-2 rounded-full bg-slate-200 border border-white flex items-center justify-center overflow-hidden self-start mt-1">
                            <span class="text-[9px] font-bold text-slate-500">Me</span>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Input Footer --}}
        <div class="p-4 bg-white border-t border-slate-50">
            <div class="flex items-center bg-white border border-slate-200 rounded-full px-2 py-1.5 shadow-sm">
                <input
                    type="text"
                    wire:model="messageInput"
                    wire:keydown.enter="sendMessage"
                    placeholder="Type a message here"
                    class="flex-1 border-none focus:ring-0 text-sm px-4 placeholder-slate-400 text-slate-700 bg-transparent"
                >
                <div class="flex items-center gap-1 pr-1">
                    <button class="p-2 text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg></button>
                    <button wire:click="sendMessage" class="p-2 bg-[#E6F0FF] text-[#0C0B50] rounded-full hover:bg-blue-100"><svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg></button>
                </div>
            </div>
        </div>
    </div>

    {{-- PROFILE  --}}
    <div class="w-[280px] flex-shrink-0 bg-white border-l border-slate-100 flex flex-col p-6 overflow-y-auto custom-scrollbar">
        <h3 class="text-[#0C0B50] font-bold text-sm mb-6">Account Information</h3>

        <div class="flex flex-col items-center mb-8">
            <div class="p-1 rounded-full border border-blue-100 mb-3">
                <img src="{{ $activeChatUser['avatar'] }}" class="w-20 h-20 rounded-full object-cover">
            </div>
            <h2 class="text-[#0C0B50] font-bold text-base">{{ $activeChatUser['name'] }}</h2>
            <p class="text-xs text-blue-500 font-medium">{{ $activeChatUser['role'] }}</p>
        </div>

        <div class="space-y-4 mb-8">
            <div class="flex justify-between">
                <span class="text-xs text-slate-400">Unit Number</span>
                <span class="text-xs font-bold text-slate-800">{{ $activeChatUser['unit'] }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-xs text-slate-400">Tenant ID</span>
                <span class="text-xs font-bold text-slate-800">{{ $activeChatUser['tenant_id'] }}</span>
            </div>
            <div>
                <span class="text-xs text-slate-400 block mb-1">Address</span>
                <p class="text-xs font-bold text-slate-800 leading-relaxed">Taguig, 1634 Metro Manila, Philippines</p>
            </div>
        </div>

        <div>
            <h4 class="text-[#0C0B50] font-bold text-sm mb-3">Media</h4>
            <div class="flex gap-6 border-b border-slate-100 mb-4">
                <button class="text-xs font-bold text-[#0C0B50] pb-1 border-b-2 border-[#0C0B50]">Images</button>
                <button class="text-xs font-medium text-slate-400 pb-1">Documents</button>
            </div>
            <div class="grid grid-cols-3 gap-2">
                @for($i = 0; $i < 9; $i++)
                    <div class="aspect-square bg-slate-100 rounded-lg overflow-hidden">
                        <img src="https://picsum.photos/seed/{{ $i + 20 }}/100/100" class="w-full h-full object-cover opacity-80 hover:opacity-100 transition-opacity">
                    </div>
                @endfor
            </div>
        </div>
    </div>

</div>
