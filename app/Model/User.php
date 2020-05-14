<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const GENDER = ['female' => 0, 'male' => 1];

    use Notifiable;

    protected $table = 'users';

    protected $fillable = ['email',  'password'];

    protected $hidden = ['password',  'remember_token'];
}


