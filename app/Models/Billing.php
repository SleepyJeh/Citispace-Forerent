<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billing extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'billing_id';

    protected $fillable = [
        'lease_id', 'billing_date', 'next_billing', 'to_pay', 'amount', 'status'
    ];

    protected $casts = [
        'billing_date' => 'date',
        'next_billing' => 'date',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id', 'lease_id');
    }

    public function receipts()
    {
        return $this->hasMany(Receipt::class, 'billing_id', 'billing_id');
    }
}
