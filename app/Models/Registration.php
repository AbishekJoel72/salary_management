<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
   protected $table = 'registrations';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'configuration_password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'configuration_password',
    ];
}
