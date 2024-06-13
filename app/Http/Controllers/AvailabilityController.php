<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateAvailabilityPriceRequest;
use App\Http\Requests\UpdateWeeklyAvailabilityPriceRequest;
use App\Models\Availability;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AvailabilityController extends Controller
{
    use ApiResponse;

    public function updatePriceInRange(UpdateAvailabilityPriceRequest $request): JsonResponse
    {
        $data = $request->validated();

        $start = Carbon::parse($data['startDate']);
        $end = Carbon::parse($data['endDate']);

        Availability::where('room_id', $data['room_id'])
            ->whereBetween('date', [$start, $end])
            ->update(['price' => $data['price']]);

        return $this->success(null, 'Prices updated successfully.');
    }

    public function updatePriceOnWeekdays(UpdateWeeklyAvailabilityPriceRequest $request): JsonResponse
    {
        $data = $request->validated();

        $start = Carbon::parse($data['startDate']);
        $end = Carbon::parse($data['endDate']);

        $daysOfWeek = array_map('intval', $data['daysOfWeek']);

        $current = $start;
        while ($current->lte($end)) {
            if (in_array($current->dayOfWeek, $daysOfWeek)) {
                Availability::where('room_id', $data['room_id'])
                    ->whereDate('date', $current->toDateString())
                    ->update(['price' => $data['price']]);
            }
            $current->addDay();
        }

        return $this->success(null, 'Prices updated successfully for specified weekdays.');
    }
}
