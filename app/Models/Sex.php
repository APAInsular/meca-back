<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sex extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
    ];

    public function avatars(): HasMany
    {
        return $this->hasMany(Avatar::class);
    }

    public function hair(): HasMany
    {
        return $this->hasMany(Hair::class);
    }

    public function pant(): HasMany
    {
        return $this->hasMany(Pant::class);
    }

    public function body(): HasMany
    {
        return $this->hasMany(Body::class);
    }

    public function shoe(): HasMany
    {
        return $this->hasMany(Shoe::class);
    }

    public function tshirt(): HasMany
    {
        return $this->hasMany(Tshirt::class);
    }

    public function accessory(): HasMany
    {
        return $this->hasMany(Accessory::class);
    }
}
