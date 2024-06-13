<?php

namespace App\Services;

use App\Models\Availability;
use App\Models\Room;
use Carbon\Carbon;
use Exception;

class AvailabilityService
{
    /**
     * @throws Exception
     */
    public function createAvailabilities(Room $room, string $startDate, string $endDate, float $price): void
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        if ($start->gt($end)) {
            throw new Exception('Start date must be before or equal to end date.');
        }

        while ($start->lte($end)) {
            Availability::create([
                'room_id' => $room->id,
                'date' => $start->toDateString(),
                'price' => $price,
                'is_available' => true,
            ]);
            $start->addDay();
        }
    }
}
