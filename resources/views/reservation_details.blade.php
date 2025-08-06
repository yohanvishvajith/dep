@extends('layouts.app')
@section('title', 'Reservation Details - Car Rental')
@section('content')

<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('user.reservations') }}" 
           class="inline-flex items-center text-[#F53003] dark:text-[#FF4433] hover:text-[#d12a00] dark:hover:text-[#e53e2e] transition-colors duration-200">
            
         
        </a>
    </div>

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Reservation Details</h1>
        <p class="text-[#706f6c] dark:text-[#A1A09A]">Reservation #{{ $reservation->reservation_id }}</p>
    </div>

    <div class="grid lg:grid-cols-2 gap-8">
        <!-- Vehicle Information -->
        <div class="bg-white dark:bg-[#161615] rounded-xl shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden">
            <!-- Vehicle Image -->
            <div class="relative">
                @if($reservation->vehicle && $reservation->vehicle->images && $reservation->vehicle->images->count() > 0)
                    <img src="{{ asset('storage/' . $reservation->vehicle->images->first()->url) }}" 
                         alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}"
                         class="w-full h-64 object-cover">
                @else
                    <div class="w-full h-64 bg-gradient-to-br from-[#dbdbd7] to-[#e3e3e0] dark:from-[#3E3E3A] dark:to-[#161615] flex items-center justify-center">
                        <i class="fas fa-car text-4xl text-[#706f6c] dark:text-[#A1A09A]"></i>
                    </div>
                @endif
                
                <!-- Status Badge -->
                <div class="absolute top-4 right-4">
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                            'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                            'completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                        ];
                    @endphp
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                        {{ ucfirst($reservation->status) }}
                    </span>
                </div>
            </div>

            <!-- Vehicle Details -->
            <div class="p-6">
                <h2 class="text-2xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">
                    {{ $reservation->vehicle->brand ?? 'N/A' }} {{ $reservation->vehicle->model ?? 'N/A' }}
                </h2>
                
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Year:</span>
                        <span class="ml-2 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->vehicle->year ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Color:</span>
                        <span class="ml-2 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->vehicle->color ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Fuel Type:</span>
                        <span class="ml-2 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->vehicle->fuel_type ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Seats:</span>
                        <span class="ml-2 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->vehicle->seats ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Engine:</span>
                        <span class="ml-2 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->vehicle->engine ?? 'N/A' }}</span>
                    </div>
                    <div>
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Daily Rate:</span>
                        <span class="ml-2 font-medium text-[#F53003] dark:text-[#FF4433]">Rs.{{ number_format($reservation->vehicle->daily_rate ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reservation Information -->
        <div class="space-y-6">
            <!-- Booking Details -->
            <div class="bg-white dark:bg-[#161615] rounded-xl shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] p-6">
                <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Booking Details</h3>
                
                <div class="space-y-4">
                    <div class="flex items-center">
                        <i class="fas fa-calendar-alt text-[#F53003] dark:text-[#FF4433] w-5 mr-3"></i>
                        <div>
                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Check-in Date</div>
                            <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->start_date->format('l, F j, Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <i class="fas fa-calendar-check text-[#F53003] dark:text-[#FF4433] w-5 mr-3"></i>
                        <div>
                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Check-out Date</div>
                            <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->end_date->format('l, F j, Y') }}</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <i class="fas fa-clock text-[#F53003] dark:text-[#FF4433] w-5 mr-3"></i>
                        <div>
                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Duration</div>
                            <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->start_date->diffInDays($reservation->end_date)+1 }} days</div>
                        </div>
                    </div>
                    
                    <div class="flex items-center">
                        <i class="fas fa-calendar-plus text-[#F53003] dark:text-[#FF4433] w-5 mr-3"></i>
                        <div>
                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Booked On</div>
                            <div class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->created_at->format('F j, Y \a\t g:i A') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cost Breakdown -->
            <div class="bg-white dark:bg-[#161615] rounded-xl shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] p-6">
                <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Cost Breakdown</h3>
                
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Daily Rate:</span>
                        <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Rs.{{ number_format($reservation->vehicle->daily_rate ?? 0, 2) }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-[#706f6c] dark:text-[#A1A09A]">Number of Days:</span>
                        <span class="font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->start_date->diffInDays($reservation->end_date)+1 }}</span>
                    </div>
                    
                    <div class="border-t border-[#e3e3e0] dark:border-[#3E3E3A] pt-3">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Total Cost:</span>
                            <span class="text-2xl font-bold text-[#F53003] dark:text-[#FF4433]">Rs.{{ number_format($reservation->total_cost, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($reservation->status === 'pending')
                <div class="bg-white dark:bg-[#161615] rounded-xl shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] p-6">
                    <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        <button onclick="cancelReservation({{ $reservation->reservation_id }})" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                            <i class="fas fa-times mr-2"></i>
                            Cancel Reservation
                        </button>
                        
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] text-center">
                            You can cancel this reservation since it's still pending confirmation.
                        </p>
                    </div>
                </div>
            @elseif($reservation->status === 'confirmed')
                <div class="bg-green-50 dark:bg-green-900/20 rounded-xl border border-green-200 dark:border-green-700 p-6">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-green-800 dark:text-green-200">Reservation Confirmed</h3>
                            <p class="text-sm text-green-600 dark:text-green-300">Your reservation has been confirmed. Please arrive on time for pickup.</p>
                        </div>
                    </div>
                </div>
            @elseif($reservation->status === 'completed')
                <div class="bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-700 p-6">
                    <div class="flex items-center">
                        <i class="fas fa-flag-checkered text-blue-600 dark:text-blue-400 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-blue-800 dark:text-blue-200">Reservation Completed</h3>
                            <p class="text-sm text-blue-600 dark:text-blue-300">Thank you for choosing our service! We hope you had a great experience.</p>
                        </div>
                    </div>
                </div>
            @elseif($reservation->status === 'cancelled')
                <div class="bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-200 dark:border-red-700 p-6">
                    <div class="flex items-center">
                        <i class="fas fa-times-circle text-red-600 dark:text-red-400 text-xl mr-3"></i>
                        <div>
                            <h3 class="text-lg font-semibold text-red-800 dark:text-red-200">Reservation Cancelled</h3>
                            <p class="text-sm text-red-600 dark:text-red-300">This reservation has been cancelled.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function cancelReservation(reservationId) {
        if (confirm('Are you sure you want to cancel this reservation? This action cannot be undone.')) {
            fetch(`/reservations/${reservationId}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Failed to cancel reservation. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        }
    }
</script>

@endsection
