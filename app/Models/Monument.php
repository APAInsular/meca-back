<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Monument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'type',
        'creation_date',
        'main_image',
        'latitude',
        'longitude',
        'meaning',
        'style_id',
        'q_r_id',
        'address_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'creation_date' => 'date',
        'latitude' => 'decimal',
        'longitude' => 'decimal',
        'style_id' => 'integer',
        'q_r_id' => 'integer',
        'address_id' => 'integer',
    ];

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function stops(): MorphMany
    {
        return $this->morphMany(Stop::class, 'stopable');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function ratings(): MorphMany
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    public function style(): BelongsToMany
    {
        return $this->belongsToMany(Style::class);
    }

    public function qR(): BelongsTo
    {
        return $this->belongsTo(QR::class);
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function saves(): MorphToMany
    {
        return $this->morphToMany(Save::class, 'saveable');
    }
}
