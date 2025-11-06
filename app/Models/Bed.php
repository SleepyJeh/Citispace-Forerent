<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bed extends Model
{
    use HasFactory;

    protected $primaryKey = 'bed_id';

    protected $fillable = [
        'unit_id',
        'bed_number',
        'status'
    ];

    /**
     * Relationship with unit
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    /**
     * Relationship with leases
     */
    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class, 'bed_id', 'bed_id');
    }
}