<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class EntradaBlog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'título',
        'contenido',
        'descripción',
        'imagen_principal',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function comentarios(): MorphMany
    {
        return $this->morphMany(Comentario::class, 'comentarioable');
    }

    public function meGustas(): MorphMany
    {
        return $this->morphMany(MeGusta::class, 'megustumable');
    }

    public function imagens(): MorphMany
    {
        return $this->morphMany(Imagen::class, 'imagenable');
    }

    public function calificacions(): MorphMany
    {
        return $this->morphMany(Calificacion::class, 'calificacionable');
    }

    public function categorias(): BelongsToMany
    {
        return $this->belongsToMany(Categoria::class);
    }

    public function etiquetas(): BelongsToMany
    {
        return $this->belongsToMany(Etiqueta::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function guardas(): MorphToMany
    {
        return $this->morphToMany(Guarda::class, 'guardaable');
    }
}
