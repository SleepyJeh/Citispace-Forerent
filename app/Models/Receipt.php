<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'receipt_id';

    protected $fillable = [
        'reference_no', 'billing_id', 'manager_id', 'purpose', 'date_issued'
    ];

    protected $casts = [
        'date_issued' => 'date',
    ];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'billing_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'user_id');
    }
}
