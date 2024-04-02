<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Ruta extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'ciudad',
        'distancia',
        'tiempo',
        'estado',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'distancia' => 'float',
    ];

    public function obras(): BelongsToMany
    {
        return $this->belongsToMany(Obra::class);
    }

    public function eventos(): BelongsToMany
    {
        return $this->belongsToMany(Evento::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function paradas(): HasMany
    {
        return $this->hasMany(Parada::class);
    }

    public function calificacions(): MorphMany
    {
        return $this->morphMany(Calificacion::class, 'calificacionable');
    }

    public function guardas(): MorphToMany
    {
        return $this->morphToMany(Guarda::class, 'guardaable');
    }
}
