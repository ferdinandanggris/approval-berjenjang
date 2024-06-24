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
        'is_approve_by_hr',
        'is_approve_by_officer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
