<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory;
    protected $fillable = [
        'name',
        'unique_name',
        'mobile',
        'dob',
        'password',
        'is_admin',
    ];

    protected $hidden = [
        'password',
    ];
}
