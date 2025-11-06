<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'transaction_id';

    protected $fillable = [
        'name', 'reference_number', 'transaction_type', 'category',
        'transaction_date', 'amount', 'is_recurring'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'is_recurring' => 'boolean'
    ];
}
