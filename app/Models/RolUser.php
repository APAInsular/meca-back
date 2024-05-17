<?php

// app/Models/RolUser.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolUser extends Model
{
    protected $table = 'rol_user';
    public $timestamps = false;

    protected $fillable = [
        'rol_id',
        'user_id',
    ];
}
