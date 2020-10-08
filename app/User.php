<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'ativacao';

    protected $fillable = [
        'name', 'email', 'password', 'supervisor', 'imagem'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
