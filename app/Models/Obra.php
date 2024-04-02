<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Obra extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'titulo',
        'tipo',
        'fecha_creacion',
        'imagen_principal',
        'latitud',
        'longitud',
        'significado',
        'estilo_id',
        'q_r_id',
        'direccion_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'fecha_creacion' => 'date',
        'latitud' => 'decimal',
        'longitud' => 'decimal',
        'estilo_id' => 'integer',
        'q_r_id' => 'integer',
        'direccion_id' => 'integer',
    ];

    public function autors(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function comentarios(): MorphMany
    {
        return $this->morphMany(Comentario::class, 'comentarioable');
    }

    public function paradas(): MorphMany
    {
        return $this->morphMany(Parada::class, 'paradaable');
    }

    public function imagens(): MorphMany
    {
        return $this->morphMany(Imagen::class, 'imagenable');
    }

    public function calificacions(): MorphMany
    {
        return $this->morphMany(Calificacion::class, 'calificacionable');
    }

    public function estilo(): BelongsTo
    {
        return $this->belongsTo(Estilo::class);
    }

    public function qR(): BelongsTo
    {
        return $this->belongsTo(QR::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class);
    }

    public function guardas(): MorphToMany
    {
        return $this->morphToMany(Guarda::class, 'guardaable');
    }
}
