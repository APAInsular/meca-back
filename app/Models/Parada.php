<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Parada extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'ruta_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'ruta_id' => 'integer',
    ];

    public function ruta(): BelongsTo
    {
        return $this->belongsTo(Ruta::class);
    }

    public function paradable(): MorphTo
    {
        return $this->morphTo();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
