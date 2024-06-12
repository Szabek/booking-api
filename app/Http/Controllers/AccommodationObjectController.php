<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccommodationObjectRequest;
use App\Http\Requests\UpdateAccommodationObjectRequest;
use App\Http\Resources\AccommodationObjectResource;
use App\Models\AccommodationObject;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class AccommodationObjectController extends Controller
{
    use ApiResponse;

    public function index(): JsonResponse
    {
        $objects = AccommodationObject::all();
        return $this->success(AccommodationObjectResource::collection($objects), 'Accommodation objects fetched successfully.');
    }

    public function store(StoreAccommodationObjectRequest $request): JsonResponse
    {
        $data = $request->validated();

        $accommodationObject = AccommodationObject::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'type' => $data['type'],
            'address' => $data['address'],
            'city' => $data['city'],
            'postal_code' => $data['postalCode'],
            'country' => $data['country'],
        ]);
        return $this->success(new AccommodationObjectResource($accommodationObject), 'Accommodation object created successfully', 201);
    }

    public function show($id): JsonResponse
    {
        $object = AccommodationObject::findOrFail($id);
        return $this->success(new AccommodationObjectResource($object), 'Accommodation object fetched successfully.');
    }

    public function update(UpdateAccommodationObjectRequest $request, $id): JsonResponse
    {
        $data = $request->validated();

        $accommodationObject = AccommodationObject::findOrFail($id);
        $accommodationObject->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'type' => $data['type'],
            'address' => $data['address'],
            'city' => $data['city'],
            'postal_code' => $data['postalCode'],
            'country' => $data['country'],
        ]);

        return $this->success(new AccommodationObjectResource($accommodationObject), 'Accommodation object updated successfully');
    }

    public function destroy($id): JsonResponse
    {
        $object = AccommodationObject::findOrFail($id);
        $object->delete();
        return $this->success(null, 'Accommodation object deleted successfully');
    }
}
