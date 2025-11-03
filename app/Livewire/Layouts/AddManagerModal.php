<?php

namespace App\Livewire\Layouts;

use App\Livewire\Forms\AddUserForm;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AddManagerModal extends Component
{
    use WithFileUploads;

    public $isOpen = false;
    public $modalId;

    // Profile fields
    public $profilePicture = null;

    public AddUserForm $userForm;
    public $firstName = '';
    public $lastName = '';
    public $phone = '';
    public $email = '';

    // Property assignment fields
    public $selectedBuilding = '';
    public $selectedFloor = '';
    public $selectedUnits = [];

    // Data arrays
    public $buildings = [];
    public $floors = [];
    public $availableUnits = [];

    // Dummy data for demonstration
    private $allBuildings = [
        ['id' => 1, 'name' => 'Ridgewood Tower 3'],
        ['id' => 2, 'name' => 'Sunset Plaza'],
        ['id' => 3, 'name' => 'Ocean View Apartments'],
    ];

    private $buildingFloors = [
        1 => ['15', '16', '17', '18', '19', '20'],
        2 => ['10', '11', '12', '13', '14'],
        3 => ['5', '6', '7', '8', '9'],
    ];

    private $floorUnits = [
        // Building 1
        '1-15' => [
            ['id' => 101, 'number' => 'Unit 101'],
            ['id' => 102, 'number' => 'Unit 102'],
            ['id' => 103, 'number' => 'Unit 103'],
            ['id' => 104, 'number' => 'Unit 104'],
            ['id' => 105, 'number' => 'Unit 105'],
            ['id' => 106, 'number' => 'Unit 106'],
            ['id' => 107, 'number' => 'Unit 107'],
            ['id' => 108, 'number' => 'Unit 108'],
        ],
        '1-16' => [
            ['id' => 201, 'number' => 'Unit 201'],
            ['id' => 202, 'number' => 'Unit 202'],
            ['id' => 203, 'number' => 'Unit 203'],
            ['id' => 204, 'number' => 'Unit 204'],
        ],
        // Building 2
        '2-10' => [
            ['id' => 301, 'number' => 'Unit 301'],
            ['id' => 302, 'number' => 'Unit 302'],
            ['id' => 303, 'number' => 'Unit 303'],
            ['id' => 304, 'number' => 'Unit 304'],
        ],
    ];

    protected function rules()
    {
        return [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => ['required', 'string', 'regex:/^9\d{9}$/'],
            'email' => 'required|email|max:255|unique:users,email',
            'profilePicture' => 'nullable|image|max:2048',
            'selectedBuilding' => 'nullable|string',
            'selectedFloor' => 'nullable|string',
            'selectedUnits' => 'nullable|array',
        ];
    }

    protected $messages = [
        'phone.regex' => 'Please enter a valid phone number starting with 9 (e.g., 9123456789)',
        'phone.required' => 'Phone number is required',
    ];

    public function mount($modalId = null)
    {
        $this->modalId = $modalId ?? uniqid('add_manager_modal_');
        $this->buildings = $this->allBuildings;
    }

    protected function getListeners()
    {
        return [
            "openAddManagerModal_{$this->modalId}" => 'open',
        ];
    }

    public function open()
    {
        $this->resetForm();
        $this->buildings = $this->allBuildings;
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
        $this->resetForm();
        $this->resetValidation();
    }

    public function updatedProfilePicture()
    {
        $this->validate([
            'profilePicture' => 'nullable|image|max:2048',
        ]);
    }

    public function updatedSelectedBuilding($value)
    {
        $this->selectedFloor = '';
        $this->selectedUnits = [];
        $this->availableUnits = [];

        if ($value) {
            // In a real app: $this->floors = Building::find($value)->floors->pluck('number')->toArray();
            $this->floors = $this->buildingFloors[$value] ?? [];
        } else {
            $this->floors = [];
        }
    }

    public function updatedSelectedFloor($value)
    {
        $this->selectedUnits = [];

        if ($this->selectedBuilding && $value) {
            $key = $this->selectedBuilding . '-' . $value;
            // In a real app: $this->availableUnits = Unit::where('building_id', $this->selectedBuilding)->where('floor', $value)->get()->toArray();
            $this->availableUnits = $this->floorUnits[$key] ?? [];
        } else {
            $this->availableUnits = [];
        }
    }

    public function save()
    {
        $this->validate();

        // Generate random password
        $password = Str::random(12);

        // Add +63 prefix to phone number for storage
        $fullPhoneNumber = '+63' . $this->phone;

        // Store profile picture if uploaded
        $profilePicturePath = null;
        if ($this->profilePicture) {
            $profilePicturePath = $this->profilePicture->store('profile-pictures', 'public');
        }

        // Create the manager user
        $user = User::create([
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'phone' => $fullPhoneNumber,
            'email' => $this->email,
            'password' => Hash::make($password),
            'profile_picture' => $profilePicturePath,
            'role' => 'manager',
        ]);

        // Assign properties to manager
        if (!empty($this->selectedUnits)) {
            // In a real app, you would create relationships here
            // $user->units()->attach($this->selectedUnits);
            // or
            // foreach ($this->selectedUnits as $unitId) {
            //     PropertyAssignment::create([
            //         'user_id' => $user->id,
            //         'unit_id' => $unitId,
            //     ]);
            // }
        }

        // TODO: Send email with login credentials
        // Mail::to($this->email)->send(new ManagerCredentialsMail($user, $password));

        session()->flash('message', 'Manager created successfully. Login credentials have been sent to their email.');

        $this->dispatch('managerCreated');
        $this->dispatch('refresh-manager-list');

        $this->close();
    }

    private function resetForm()
    {
        $this->firstName = '';
        $this->lastName = '';
        $this->phone = '';
        $this->email = '';
        $this->profilePicture = null;
        $this->selectedBuilding = '';
        $this->selectedFloor = '';
        $this->selectedUnits = [];
        $this->floors = [];
        $this->availableUnits = [];
    }

    public function render()
    {
        return view('livewire.layouts.add-manager-modal');
    }
}
