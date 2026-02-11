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

    public $activeTab = ''; // Will be set dynamically
    public $allowedTabs = []; // To control which tabs are visible

    public $search = '';
    public $selectedUserId = null;
    public $messageInput = '';
    public $showProfile = false;
    public $attachment;

    public function mount()
    {
        $userRole = Auth::user()->role;

        // 1. Determine which tabs (roles) this user can see
        match ($userRole) {
            'landlord' => $this->allowedTabs = ['manager', 'tenant'],
            'manager'  => $this->allowedTabs = ['landlord', 'tenant'],
            'tenant'   => $this->allowedTabs = ['landlord', 'manager'],
            default    => $this->allowedTabs = ['manager'],
        };

        // 2. Set default active tab to the first allowed role
        $this->activeTab = $this->allowedTabs[0];

        // 3. Select first chat automatically
        $firstChat = $this->getChatsProperty()->first();
        if ($firstChat) {
            $this->selectedUserId = $firstChat->user_id;
        }
    }

    // Function to switch tabs (e.g., from "Managers" to "Tenants")
    public function setTab($tabName)
    {
        if (in_array($tabName, $this->allowedTabs)) {
            $this->activeTab = $tabName;
            $this->selectedUserId = null; // Reset selection when switching tabs
        }
    }

    public function getChatsProperty()
    {
        $myId = Auth::id();

        return User::where('user_id', '!=', $myId)
            // Filter users based on the currently selected tab (Role)
            ->where('role', $this->activeTab)
            ->where(function ($q) use ($myId) {
                // Logic: Users I have chatted with OR users matching the role
                // You might want to remove the 'whereHas' check if you want to list ALL users of that role
                // For now, let's list ALL users of that role so you can start new chats
                $q->where('first_name', 'like', "%$this->search%")
                    ->orWhere('last_name', 'like', "%$this->search%");
            })
            ->get();
    }

    // ... (Keep selectChat, sendMessage, toggleProfile, render as they were) ...
    public function selectChat($userId)
    { /* ... */
    }
    public function sendMessage()
    { /* ... */
    }
    public function toggleProfile()
    { /* ... */
    }

    public function render()
    {
        return view('livewire.layouts.message.message-system', [
            'chats' => $this->getChatsProperty(),
            'activeMessages' => $this->selectedUserId ? Message::where(function ($q) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $this->selectedUserId);
            })->orWhere(function ($q) {
                $q->where('sender_id', $this->selectedUserId)->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'asc')->get() : [],

            'activeChatUser' => $this->selectedUserId ? User::find($this->selectedUserId) : null,
        ]);
    }
}
