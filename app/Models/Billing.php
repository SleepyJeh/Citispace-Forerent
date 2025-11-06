<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Billing extends Model
{
    use HasFactory;

    protected $primaryKey = 'billing_id';

    protected $fillable = [
        'lease_id',
        'billing_date',
        'next_billing',
        'to_pay',
        'amount',
        'status'
    ];

    protected $casts = [
        'billing_date' => 'date',
        'next_billing' => 'date',
        'to_pay' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    /**
     * Relationship with lease
     */
    public function lease(): BelongsTo
    {
        return $this->belongsTo(Lease::class, 'lease_id', 'lease_id');
    }

    /**
     * Relationship with transactions
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'billing_id', 'billing_id');
    }
}