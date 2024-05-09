<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avatar extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sex_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sex(): BelongsTo
    {
        return $this->belongsTo(Sex::class);
    }
}
