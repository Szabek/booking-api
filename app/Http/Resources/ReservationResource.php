<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
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
            'roomId' => $this->room_id,
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,
            'guests' => $this->guests,
            'totalPrice' => $this->total_price,
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
