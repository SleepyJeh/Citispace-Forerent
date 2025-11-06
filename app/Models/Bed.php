<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bed extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'bed_id';

    protected $fillable = [
        'unit_id', 'bed_number', 'status'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'unit_id');
    }

    public function leases()
    {
        return $this->hasMany(Lease::class, 'bed_id', 'bed_id');
    }
}
