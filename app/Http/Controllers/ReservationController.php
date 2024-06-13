<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Services\ReservationService;
use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use ApiResponse;

    protected ReservationService $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function index(): JsonResponse
    {
        $reservations = Reservation::with('user')->get();
        return $this->success(ReservationResource::collection($reservations), 'Reservations fetched successfully.');
    }

    public function userReservations(): JsonResponse
    {
        $reservations = Reservation::where('user_id', Auth::id())->with('user')->get();
        return $this->success(ReservationResource::collection($reservations), 'User reservations fetched successfully.');
    }

    public function store(StoreReservationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['userId'] = $request->user()->id;

        try {
            $reservation = $this->reservationService->createReservation($data);
            return $this->success(new ReservationResource($reservation), 'Reservation created successfully.', 201);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), null, 422);
        }
    }
}
