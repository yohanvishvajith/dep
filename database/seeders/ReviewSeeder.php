<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Review;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Reservation;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Get some users and vehicles to create reviews for
        $users = User::limit(10)->get();
        $vehicles = Vehicle::limit(5)->get();
        $reservations = Reservation::limit(10)->get();

        $sampleReviews = [
            [
                'comment' => 'Excellent car! Very clean and well-maintained. The booking process was smooth and the pickup was right on time. Highly recommend for anyone looking for a reliable rental.',
                'rating' => 5,
            ],
            [
                'comment' => 'Great experience overall. The car was in good condition and fuel efficient. Customer service was helpful. Only minor issue was a small delay during pickup.',
                'rating' => 4,
            ],
            [
                'comment' => 'Perfect for my weekend trip. Comfortable ride and good mileage. The app made everything easy to manage. Will definitely book again for future trips.',
                'rating' => 4,
            ],
            [
                'comment' => 'Decent car for the price. Could use better cleaning but mechanically sound. Service was professional and transparent about all costs.',
                'rating' => 3,
            ],
            [
                'comment' => 'Outstanding service! The car was spotless and performed excellently throughout my week-long business trip. Will definitely recommend to colleagues.',
                'rating' => 5,
            ],
            [
                'comment' => 'Good value for money. The vehicle was comfortable for our family road trip. Customer support was responsive when we had questions about the route.',
                'rating' => 4,
            ],
            [
                'comment' => 'Smooth rental experience from start to finish. The car had good fuel efficiency and was perfect for city driving. Will use this service again.',
                'rating' => 5,
            ],
            [
                'comment' => 'Vehicle was exactly as described. Clean interior, good performance, and fair pricing. The return process was quick and hassle-free.',
                'rating' => 4,
            ],
            [
                'comment' => 'Had a minor issue with the air conditioning, but customer service quickly resolved it. Overall satisfied with the rental experience.',
                'rating' => 3,
            ],
            [
                'comment' => 'Excellent service and very reliable vehicle. The booking system is user-friendly and the staff is professional. Highly recommended!',
                'rating' => 5,
            ],
        ];

        foreach ($sampleReviews as $index => $reviewData) {
            if ($users->count() > 0 && $vehicles->count() > 0) {
                Review::create([
                    'user_id' => $users->random()->id,
                    'vehicle_id' => $vehicles->random()->vehicle_id,
                    'reservation_id' => $reservations->count() > $index ? $reservations[$index]->reservation_id : null,
                    'comment' => $reviewData['comment'],
                    'rating' => $reviewData['rating'],
                    'is_approved' => true,
                    'created_at' => now()->subDays(rand(1, 30)),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
