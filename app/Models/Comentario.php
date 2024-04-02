<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comentario extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'contenido',
        'imagen_principal',
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    public function meGustas(): MorphMany
    {
        return $this->morphMany(MeGusta::class, 'megustumable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comentable(): MorphTo
    {
        return $this->morphTo();
    }
}
