<?php

// app/Models/RolUser.php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleUser extends Pivot
{
    protected $table = 'role_user';
    public $timestamps = false;

    protected $fillable = [
        'rol_id',
        'user_id',
    ];

}
