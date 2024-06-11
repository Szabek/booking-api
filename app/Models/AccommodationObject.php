<?php

namespace App\Models;

use App\Enums\AccommodationType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccommodationObject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'address',
        'city',
        'postal_code',
        'country'
    ];

    protected $casts = [
        'type' => AccommodationType::class,
    ];
    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
}
