<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lease extends Model
{
    use HasFactory;

    protected $primaryKey = 'lease_id';

    protected $fillable = [
        'tenant_id',
        'bed_id',
        'status',
        'term',
        'auto_renew',
        'start_date',
        'end_date',
        'contract_rate',
        'advance_amount',
        'security_deposit',
        'move_in'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'move_in' => 'date',
        'auto_renew' => 'boolean',
        'contract_rate' => 'decimal:2',
        'advance_amount' => 'decimal:2',
        'security_deposit' => 'decimal:2',
    ];

    /**
     * Relationship with tenant (user)
     */
    public function tenant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'tenant_id', 'user_id');
    }

    /**
     * Relationship with bed
     */
    public function bed(): BelongsTo
    {
        return $this->belongsTo(Bed::class, 'bed_id', 'bed_id');
    }

    /**
     * Relationship with billing
     */
    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class, 'lease_id', 'lease_id');
    }
}