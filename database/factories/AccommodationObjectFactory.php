<?php

namespace Database\Factories;

use App\Models\AccommodationObject;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccommodationObjectFactory extends Factory
{
    protected $model = AccommodationObject::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'description' => $this->faker->sentence,
            'type' => $this->faker->randomElement(['hotel', 'guesthouse']),
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
        ];
    }
}
