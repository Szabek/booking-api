<?php

use App\Models\Room;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AvailabilityServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AvailabilityService $availabilityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->availabilityService = new AvailabilityService();
    }

    public function test_create_availabilities()
    {
        $room = Room::factory()->create();
        $startDate = '2024-06-15';
        $endDate = '2024-06-20';
        $price = 100.00;

        $this->availabilityService->createAvailabilities($room, $startDate, $endDate, $price);

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        while ($start->lte($end)) {
            $this->assertDatabaseHas('availabilities', [
                'room_id' => $room->id,
                'date' => $start->toDateString(),
                'price' => $price,
                'is_available' => true,
            ]);

            $start->addDay();
        }
    }

    public function test_create_availabilities_with_invalid_dates()
    {
        $this->expectException(Exception::class);

        $room = Room::factory()->create();
        $startDate = '2024-06-20';
        $endDate = '2024-06-15';
        $price = 100.00;

        $this->availabilityService->createAvailabilities($room, $startDate, $endDate, $price);
    }
}
