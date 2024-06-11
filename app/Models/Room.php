<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'accommodation_object_id',
        'name',
        'description',
        'capacity',
        'base_price'
    ];

    public function accommodationObject(): BelongsTo
    {
        return $this->belongsTo(AccommodationObject::class);
    }
}
