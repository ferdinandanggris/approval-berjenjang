<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApplication extends Model
{
    use HasFactory;

    protected $table = 'leave_applications';
    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'end_date',
        'status',
        'reason',
        'is_approve_hr',
        'hr_id',
        'is_approve_officer',
        'officer_id',
        'hr_reason',
        'officer_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hr()
    {
        return $this->belongsTo(User::class, 'hr_id');
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }
}
