<?php

namespace CompraVenta;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

// OBTENIENDO LAS VARIABLES A TOMAR DE LA TABLA

class User extends Authenticatable
{
    use HasRoles;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}