<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

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

    /**
     * Get the ratings associated with the user.
     */
    public function ratings()
    {
        return $this->morphToMany(Rating::class, 'rateable');
    }

    /**
     * Get the monuments associated with the user.
     */
    public function monuments()
    {
        return $this->belongsToMany(Monument::class);
    }

    /**
     * Get the location records associated with the user.
     */
    public function locations()
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get the events associated with the user.
     */
    public function events()
    {
        return $this->belongsToMany(Event::class);
    }

    /**
     * Get the achievements associated with the user.
     */
    public function achievements()
    {
        return $this->belongsToMany(Achievement::class);
    }

    /**
     * Get the sub-achievements associated with the user.
     */
    public function subAchievements()
    {
        return $this->belongsToMany(SubAchievement::class);
    }

    /**
     * Get the comments associated with the user.
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the likes associated with the user.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Get the blog entries associated with the user.
     */
    public function blogEntries()
    {
        return $this->hasMany(BlogEntry::class);
    }

    /**
     * Get the roles associated with the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Get the saves associated with the user.
     */
    public function saves()
    {
        return $this->morphToMany(Save::class, 'saveable');
    }

    /**
     * Get the routes associated with the user.
     */
    public function routes()
    {
        return $this->belongsToMany(Route::class);
    }

    /**
     * Get the stops associated with the user.
     */
    public function stops()
    {
        return $this->belongsToMany(Stop::class);
    }
}
