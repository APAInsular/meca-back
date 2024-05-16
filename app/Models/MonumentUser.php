<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MonumentUser extends Pivot
{
    protected $table = 'monument_user';

    protected $fillable = [
        'monument_id',
        'user_id',
    ];
}
