<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'monument_id',
        'user_id',
        'stars',
        'comment'
    ];

    public function obra()
    {
        return $this->belongsTo('App\Models\Monument', 'monument_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
