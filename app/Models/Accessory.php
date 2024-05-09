<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Accessory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sex_id',
        'category',
        'subcategory',
        'url',
        'url_selection',
    ];

    public function sex(): BelongsTo
    {
        return $this->belongsTo(Sex::class);
    }
}
