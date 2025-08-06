<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Vehicle;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::limit(5)->get();
        $vehicles = Vehicle::limit(5)->get();

        if ($users->count() === 0 || $vehicles->count() === 0) {
            $this->command->warn('No users or vehicles found. Please seed users and vehicles first.');
            return;
        }

        $sampleReservations = [
            // Active reservation (confirmed, currently ongoing)
            [
                'start_date' => Carbon::today()->subDays(2),
                'end_date' => Carbon::today()->addDays(3),
                'status' => 'confirmed',
                'total_cost' => 15000.00,
            ],
            // Upcoming reservation (confirmed, starts in future)
            [
                'start_date' => Carbon::today()->addDays(5),
                'end_date' => Carbon::today()->addDays(8),
                'status' => 'confirmed',
                'total_cost' => 22500.00,
            ],
            // Another upcoming reservation
            [
                'start_date' => Carbon::today()->addDays(10),
                'end_date' => Carbon::today()->addDays(12),
                'status' => 'confirmed',
                'total_cost' => 18000.00,
            ],
            // Completed reservation
            [
                'start_date' => Carbon::today()->subDays(15),
                'end_date' => Carbon::today()->subDays(12),
                'status' => 'completed',
                'total_cost' => 12000.00,
            ],
            // Another completed reservation
            [
                'start_date' => Carbon::today()->subDays(25),
                'end_date' => Carbon::today()->subDays(22),
                'status' => 'completed',
                'total_cost' => 9000.00,
            ],
            // Cancelled reservation
            [
                'start_date' => Carbon::today()->addDays(1),
                'end_date' => Carbon::today()->addDays(4),
                'status' => 'cancelled',
                'total_cost' => 18000.00,
            ],
            // Pending reservation
            [
                'start_date' => Carbon::today()->addDays(7),
                'end_date' => Carbon::today()->addDays(9),
                'status' => 'pending',
                'total_cost' => 15000.00,
            ],
        ];

        foreach ($sampleReservations as $index => $reservationData) {
            Reservation::create([
                'user_id' => $users->random()->id,
                'vehicle_id' => $vehicles->random()->vehicle_id,
                'start_date' => $reservationData['start_date'],
                'end_date' => $reservationData['end_date'],
                'status' => $reservationData['status'],
                'total_cost' => $reservationData['total_cost'],
                'created_at' => now()->subDays(rand(1, 30)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Sample reservations created successfully!');
    }
}
