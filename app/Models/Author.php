<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Author extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_surname',
        'second_surname',
        'date_of_birth',
        'date_of_death',
        'location',
        'country',
        'description',
        'image',
        'video',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];

    public function monuments(): BelongsToMany
    {
        return $this->belongsToMany(Monument::class);
    }

    public function saves(): MorphToMany
    {
        return $this->morphToMany(Save::class, 'saveable');
    }
}
