<?php

namespace Database\Factories;

use App\Models\AccommodationObject;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'accommodation_object_id' => AccommodationObject::factory(),
            'name' => $this->faker->word,
            'description' => $this->faker->sentence,
            'capacity' => $this->faker->numberBetween(1, 4),
            'base_price' => $this->faker->randomFloat(2, 50, 200),
        ];
    }
}
