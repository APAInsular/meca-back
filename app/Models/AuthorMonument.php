<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthorMonument extends Model
{
    use HasFactory;

    protected $table = 'author_monument';

    protected $fillable = [
        'author_id',
        'monument_id',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function monument(): BelongsTo
    {
        return $this->belongsTo(Monument::class);
    }
}
