<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'unit_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'property_id',
        'manager_id',
        'floor_number',
        'occupants',
        'bed_type',
        'room_type',
        'room_cap',
        'unit_cap',
        'price',
        'amenities',
    ];

    /**
     * Get the property that this unit belongs to.
     */
    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'property_id');
    }

    public function beds()
    {
        return $this->hasMany(Bed::class, 'unit_id', 'unit_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'user_id');
    }
}
