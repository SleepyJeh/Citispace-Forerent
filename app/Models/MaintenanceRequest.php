<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MaintenanceRequest extends Model
{
    use SoftDeletes, HasFactory;

    protected $primaryKey = 'request_id';

    protected $fillable = [
        'lease_id', 'status', 'logged_by', 'ticket_number',
        'log_date', 'problem', 'urgency'
    ];

    protected $casts = [
        'log_date' => 'date',
    ];

    public function lease()
    {
        return $this->belongsTo(Lease::class, 'lease_id', 'lease_id');
    }

    public function logs()
    {
        return $this->hasMany(MaintenanceLog::class, 'request_id', 'request_id');
    }
}
