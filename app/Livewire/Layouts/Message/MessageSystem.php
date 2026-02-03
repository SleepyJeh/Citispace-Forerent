<?php

namespace App\Livewire\Layouts\Message;

use Livewire\Component;

class MessageSystem extends Component
{
    public $activeTab = 'owner'; // 'owner' or 'tenant'
    public $search = '';
    public $selectedChatId = 1;
    public $messageInput = '';

    // Mock Data to match your Image
    public $chats = [
        [
            'id' => 1,
            'name' => 'Nikol Candel',
            'role' => 'Tenant',
            'avatar' => 'https://ui-avatars.com/api/?name=Nikol+Candel&background=random',
            'last_msg' => 'See you later!',
            'time' => '1:03 PM',
            'unread' => 2,
            'date' => 'Friday',
            'unit' => 'Unit 101',
            'tenant_id' => 'Tnt-001'
        ],
        [
            'id' => 2,
            'name' => 'Adam Jay',
            'role' => 'Tenant',
            'avatar' => 'https://ui-avatars.com/api/?name=Adam+Jay&background=random',
            'last_msg' => 'Thanks for the update.',
            'time' => '10:00 AM',
            'unread' => 0,
            'date' => '29/03/25',
            'unit' => 'Unit 202',
            'tenant_id' => 'Tnt-002'
        ],
        [
            'id' => 3,
            'name' => 'Leira Marie',
            'role' => 'Owner',
            'avatar' => 'https://ui-avatars.com/api/?name=Leira+Marie&background=random',
            'last_msg' => 'Contract signed.',
            'time' => 'Yesterday',
            'unread' => 0,
            'date' => '29/03/25',
            'unit' => 'N/A',
            'tenant_id' => 'Own-005'
        ],
    ];

    public $messages = [
        ['id' => 1, 'sender' => 'them', 'text' => 'Hello! I have a question about the maintenance fee.', 'time' => '1:00 PM'],
        ['id' => 2, 'sender' => 'me', 'text' => 'Hi Nikol, sure. What would you like to know?', 'time' => '1:03 PM'],
        ['id' => 3, 'sender' => 'them', 'text' => 'Is it included in the rent this month?', 'time' => '1:05 PM'],
        ['id' => 4, 'sender' => 'them', 'text' => 'Also, the light in the hallway is flickering.', 'time' => '1:06 PM'],
    ];

    public function selectChat($id)
    {
        $this->selectedChatId = $id;
    }

    public function sendMessage()
    {
        if (trim($this->messageInput) === '') return;

        $this->messages[] = [
            'id' => count($this->messages) + 1,
            'sender' => 'me',
            'text' => $this->messageInput,
            'time' => now()->format('g:i A')
        ];

        $this->messageInput = '';
    }

    public function render()
    {
        // Find the active user details based on selection
        $activeChatUser = collect($this->chats)->firstWhere('id', $this->selectedChatId);

        return view('livewire.layouts.message.message-system', [
            'activeChatUser' => $activeChatUser
        ]);
    }
}
