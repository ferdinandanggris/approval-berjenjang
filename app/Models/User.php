<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    const ROLES = [
        'officer' => [
            'id' => 'officer',
            'name' => 'Officer'
        ],
        'employee' => [
            'id' => 'employee',
            'name' => 'Employee'
        ],
        'finance' => [
            'id'  => 'finance',
            'name'=> 'Finance'
        ]
    ];
    const ROLE_OFFICER = 'officer';
    const ROLE_EMPLOYEE = 'employee';
    const ROLE_FINANCE = 'finance';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
