<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'property_id';

    /**
     * Indicates if the model should be timestamped.
     * Your migration does not have timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'building_name',
        'address',
        'total_units',
        'prop_description',
    ];

    /**
     * Get the user (owner) that owns the property.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the units for the property.
     */
    public function units()
    {
        return $this->hasMany(Unit::class, 'property_id', 'property_id');
    }
}