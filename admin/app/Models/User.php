<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\ListBooks;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'profile_picture',
        'phone',
        'status', // Allow mass assignment of status
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function books()
    {
        return $this->hasMany(ListBooks::class, 'publisher_id', 'id');
    }
}
