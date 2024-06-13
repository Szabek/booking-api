<?php

namespace App\Services;

use App\Models\Availability;
use App\Models\Room;
use Carbon\Carbon;

class AvailabilityService
{
    public function createAvailabilities(Room $room, string $startDate, string $endDate, float $price): void
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($start->lte($end)) {
            Availability::create([
                'room_id' => $room->id,
                'date' => $start->toDateString(),
                'price' => $price,
            ]);
            $start->addDay();
        }
    }
}
