<?php
// app/Models/Tenant.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = [
        'name',
        'address',
        'building',
        'unit',
        'contact_number',
        'email',
        'bed_number',
        'lease_start_date',
        'lease_term',
        'is_auto_renew',
        'dorm_type',
        'gender',
        'lease_end_date',
        'shift',
        'move_in_date',
        'security_deposit',
        'monthly_rate',
        'payment_status',
    ];

    protected $casts = [
        'is_auto_renew' => 'boolean',
        'security_deposit' => 'decimal:2',
        'monthly_rate' => 'decimal:2',
        'lease_start_date' => 'date',
        'lease_end_date' => 'date',
        'move_in_date' => 'date',
    ];
}
