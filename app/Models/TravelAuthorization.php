<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelAuthorization extends Model
{
    use HasFactory;
    protected $table = 'travel_authorization';
    protected $fillable = [
        'user_id', // Add this line
        'name',
        'start_date',
        'end_date',
        'status',
        'reason',
        'is_approve_officer',
        'is_approve_hr',
        'is_approve_finance',
        'officer_id',
        'hr_id',
        'finance_id',
        'officer_reason',
        'hr_reason',
        'finance_reason'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function officer()
    {
        return $this->belongsTo(User::class, 'officer_id');
    }

    public function hr()
    {
        return $this->belongsTo(User::class, 'hr_id');
    }

    public function finance(){
        return $this->belongsTo(User::class, 'finance_id');
    }
}
