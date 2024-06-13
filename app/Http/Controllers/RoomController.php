<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\AccommodationObject;
use App\Models\Room;
use App\Services\AvailabilityService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class RoomController extends Controller
{
    use ApiResponse;

    protected AvailabilityService $availabilityService;

    public function __construct(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function index($accommodationObjectId): JsonResponse
    {
        $accommodationObject = AccommodationObject::findOrFail($accommodationObjectId);
        $rooms = $accommodationObject->rooms;
        return $this->success(RoomResource::collection($rooms), 'Rooms fetched successfully.');
    }

    public function store(StoreRoomRequest $request, $accommodationObjectId): JsonResponse
    {
        $accommodationObject = AccommodationObject::findOrFail($accommodationObjectId);
        $data = $request->validated();

        $room = $accommodationObject->rooms()->create([
            'name' => $data['name'],
            'description' => $data['description'],
            'capacity' => $data['capacity'],
            'base_price' => $data['basePrice'],
            'accommodation_object_id' => $accommodationObjectId,
        ]);

        $this->availabilityService->createAvailabilities($room, $data['availabilityStartDate'], $data['availabilityEndDate'], $data['basePrice']);

        return $this->success(new RoomResource($room), 'Room created successfully', 201);
    }

    public function show($id): JsonResponse
    {
        $room = Room::findOrFail($id);
        return $this->success(new RoomResource($room), 'Room fetched successfully.');
    }

    public function update(UpdateRoomRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $room = Room::findOrFail($id);
        $room->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'capacity' => $data['capacity'],
            'base_price' => $data['basePrice'],
        ]);

        return $this->success(new RoomResource($room), 'Room updated successfully');
    }

    public function destroy($id): JsonResponse
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return $this->success(null, 'Room deleted successfully');
    }
}
