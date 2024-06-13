<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Availability extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'date',
        'price',
        'is_available',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }
}
