<?php

use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use App\Services\AvailabilityService;
use App\Services\ReservationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AvailabilityService $availabilityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->availabilityService = new AvailabilityService();
    }

    public function test_create_reservation()
    {
        $service = new ReservationService();
        $room = Room::factory()->create(['capacity' => 2]);
        $user = User::factory()->create();

        $startDate = '2024-06-15';
        $endDate = '2024-06-16';
        $guests = 2;
        $price = 100.00;

        $this->availabilityService->createAvailabilities($room, $startDate, $endDate, $price);

        $data = [
            'startDate' => $startDate,
            'endDate' => $endDate,
            'roomId' => $room->id,
            'guests' => $guests,
            'userId' => $user->id,
        ];

        $reservation = $service->createReservation($data);

        $this->assertInstanceOf(Reservation::class, $reservation);
        $this->assertDatabaseHas('reservations', [
            'room_id' => $room->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_create_reservation_with_no_availability()
    {
        $this->expectException(Exception::class);

        $service = new ReservationService();
        $room = Room::factory()->create(['capacity' => 2]);
        $user = User::factory()->create();

        $data = [
            'startDate' => '2024-06-15',
            'endDate' => '2024-06-16',
            'roomId' => $room->id,
            'guests' => 2,
            'userId' => $user->id,
        ];

        $service->createReservation($data);
    }
}
