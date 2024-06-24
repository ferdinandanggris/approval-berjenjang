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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
