<?php

namespace App\Livewire\Layouts\Message;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageSystem extends Component
{
    use WithFileUploads;

    // UPDATED: Default to 'manager' (since we removed tenant)
    public $activeTab = 'manager';

    public $search = '';
    public $selectedUserId = null;
    public $messageInput = '';
    public $showProfile = false;
    public $attachment;

    public function mount()
    {
        $firstChat = $this->getChatsProperty()->first();
        if ($firstChat) {
            $this->selectedUserId = $firstChat->user_id;
        }
    }

    public function getChatsProperty()
    {
        $myId = Auth::id();

        return User::where('user_id', '!=', $myId)
            ->where(function ($q) use ($myId) {
                $q->whereHas('sentMessages', fn($q) => $q->where('receiver_id', $myId))
                    ->orWhereHas('receivedMessages', fn($q) => $q->where('sender_id', $myId));
            })
            // This now filters by 'landlord' or 'manager' based on the new tabs
            ->where('role', $this->activeTab)
            ->when($this->search, fn($q) => $q->where('first_name', 'like', "%$this->search%"))
            ->get()
            ->map(function ($user) use ($myId) {
                $lastMsg = Message::where(function ($q) use ($user, $myId) {
                    $q->where('sender_id', $user->user_id)->where('receiver_id', $myId);
                })
                    ->orWhere(function ($q) use ($user, $myId) {
                        $q->where('sender_id', $myId)->where('receiver_id', $user->user_id);
                    })
                    ->latest()
                    ->first();

                $user->last_message = $lastMsg ? $lastMsg->message : 'No messages';
                $user->last_time = $lastMsg ? $lastMsg->created_at->format('g:i A') : '';
                $user->last_message_raw = $lastMsg ? $lastMsg->created_at : null;

                $user->unread_count = Message::where('sender_id', $user->user_id)
                    ->where('receiver_id', $myId)
                    ->where('is_read', false)
                    ->count();

                return $user;
            })
            ->sortByDesc('last_message_raw')
            ->values();
    }

    // ... (Rest of the functions: getMessagesProperty, sendMessage, etc. stay the same) ...

    public function getMessagesProperty()
    {
        if (!$this->selectedUserId) return [];

        return Message::where(function ($q) {
            $q->where('sender_id', Auth::id())->where('receiver_id', $this->selectedUserId);
        })
            ->orWhere(function ($q) {
                $q->where('sender_id', $this->selectedUserId)->where('receiver_id', Auth::id());
            })
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function selectChat($userId)
    {
        $this->selectedUserId = $userId;
        $this->showProfile = false;

        Message::where('sender_id', $userId)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);
    }

    public function sendMessage()
    {
        if (trim($this->messageInput) === '' && !$this->attachment) return;

        $data = [
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUserId,
            'message' => $this->messageInput,
            'created_at' => now(),
            'is_read' => false
        ];

        if ($this->attachment) {
            $path = $this->attachment->store('chat-attachments', 'public');
            $data['type'] = 'file';
            $data['file_path'] = $path;
            $data['message'] = $this->attachment->getClientOriginalName();
            $this->attachment = null;
        }

        Message::create($data);
        $this->reset('messageInput');
    }

    public function toggleProfile()
    {
        $this->showProfile = !$this->showProfile;
    }

    public function render()
    {
        $activeChatUser = User::find($this->selectedUserId);

        return view('livewire.layouts.message.message-system', [
            'chats' => $this->getChatsProperty(),
            'activeMessages' => $this->getMessagesProperty(),
            'activeChatUser' => $activeChatUser
        ]);
    }
}
