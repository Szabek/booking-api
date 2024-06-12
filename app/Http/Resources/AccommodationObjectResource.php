<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccommodationObjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'address' => $this->address,
            'city' => $this->city,
            'postalCode' => $this->postal_code,
            'country' => $this->country,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'rooms' => RoomResource::collection($this->whenLoaded('rooms')),
        ];
    }
}
