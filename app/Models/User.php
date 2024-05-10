<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nickname',
        'name',
        'first_surname',
        'second_surname',
        'profile_picture',
        'email',
        'password',
        'confirm_password',
        'nationality',
        'date_of_birth',
        'location',
        'postal_code',
        'points',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relación: Usuario tiene un autor
    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function monuments(): BelongsToMany
    {
        return $this->belongsToMany(Monument::class);
    }

    public function ratings(): BelongsToMany
    {
        return $this->belongsToMany(Rating::class);
    }

    // Relación: Usuario tiene una dirección
    public function addresses(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    // Relación: Usuario realiza comentarios
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    // Relación: Usuario realiza me gusta
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    // Relación: Usuario realiza una entrada completa
    public function blogEntries(): HasMany
    {
        return $this->hasMany(BlogEntry::class);
    }

    // Relación: Usuario completa un logro
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(Achievement::class);
    }

    // Relación: Usuario tiene un rol
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    // Relación: Usuario participa en un evento
    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }

    // Relación: Usuario realiza una parada
    public function stops(): HasMany
    {
        return $this->hasMany(Stop::class);
    }

    // Relación: Usuario realiza una ruta
    public function routes(): HasMany
    {
        return $this->hasMany(Route::class);
    }

    // Relación: Usuario tinen un avatar
    public function avatars(): HasOne
    {
        return $this->hasOne(Avatar::class);
    }

    // Relación: Usuario guarda una ruta
    public function savedRoutes(): BelongsToMany
    {
        return $this->belongsToMany(Route::class, 'saved_routes');
    }

    // Relación: Usuario guarda una obra
    public function savedMonuments(): BelongsToMany
    {
        return $this->belongsToMany(Monument::class, 'saved_monuments');
    }

    // Relación polimórfica: Usuario tiene un autor, entrada de blog o evento
    public function favoriteable(): MorphTo
    {
        return $this->morphTo();
    }

}
