<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class AddTenantForm extends Form
{
    #[Validate('nullable|in:Female,Male, Co-ed')]
    public string $dormType = '';

    #[Validate('required|string|max:100')]
    public string $term = '';

    #[Validate('required|in:Morning,Night')]
    public string $shift = '';

    #[Validate('required|date')]
    public string $startDate = '';

    #[Validate('nullable|boolean')]
    public bool $autoRenewContract = false;

    #[Validate('required|date')]
    public string $moveInDate = '';

    #[Validate('required|numeric|min:0')]
    public $monthlyRate = '';

    #[Validate('required|numeric|min:0')]
    public $securityDeposit = '';

    #[Validate('required|in:Paid,Pending,Overdue')]
    public string $paymentStatus = '';

    #[Validate('nullable|string|max:255')]
    public string $registration = '';

    /**
     * Custom validation messages
     */
    public function messages(): array
    {
        return [
            'dormType.in' => 'Please select a valid dorm type.',
            'term.required' => 'Term is required.',
            'shift.required' => 'Please select a shift.',
            'shift.in' => 'Please select a valid shift.',
            'startDate.required' => 'Start date is required.',
            'startDate.date' => 'Please enter a valid start date.',
            'moveInDate.required' => 'Move-in date is required.',
            'moveInDate.date' => 'Please enter a valid move-in date.',
            'monthlyRate.required' => 'Monthly rate is required.',
            'monthlyRate.numeric' => 'Monthly rate must be a number.',
            'monthlyRate.min' => 'Monthly rate cannot be negative.',
            'securityDeposit.required' => 'Security deposit is required.',
            'securityDeposit.numeric' => 'Security deposit must be a number.',
            'securityDeposit.min' => 'Security deposit cannot be negative.',
            'paymentStatus.required' => 'Please select a payment status.',
            'paymentStatus.in' => 'Please select a valid payment status.',
        ];
    }

    /**
     * Reset form to initial state
     */
    public function reset(...$properties): void
    {
        if (empty($properties)) {
            $this->dormType = '';
            $this->term = '';
            $this->shift = '';
            $this->startDate = '';
            $this->autoRenewContract = false;
            $this->moveInDate = '';
            $this->monthlyRate = '';
            $this->securityDeposit = '';
            $this->paymentStatus = '';
            $this->registration = '';
        } else {
            parent::reset(...$properties);
        }
    }
}
