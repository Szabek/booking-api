<?php

namespace App\Services;

use App\Models\Availability;
use App\Models\Reservation;
use DateInterval;
use DatePeriod;
use DateTime;
use Exception;
use Illuminate\Support\Facades\DB;

class ReservationService
{
    /**
     * @throws Exception
     */
    public function createReservation(array $data): Reservation
    {
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $roomId = $data['roomId'];
        $guests = $data['guests'];

        $availabilities = Availability::where('room_id', $roomId)
            ->whereBetween('date', [$startDate, $endDate])
            ->where('is_available', true)
            ->get();

        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            (new DateTime($endDate))->modify('+1 day')
        );

        $totalDays = iterator_count($period);

        if ($availabilities->count() !== $totalDays) {
            throw new Exception('Not enough vacancies for the selected period.');
        }

        return DB::transaction(function () use ($availabilities, $data, $roomId, $startDate, $endDate, $guests) {
            $totalPrice = 0;

            foreach ($availabilities as $availability) {
                $totalPrice += $availability->price;
                $availability->update(['is_available' => false]);
            }

            return Reservation::create([
                'room_id' => $roomId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'guests' => $guests,
                'total_price' => $totalPrice,
                'user_id' => $data['userId'],
            ]);
        });
    }
}
