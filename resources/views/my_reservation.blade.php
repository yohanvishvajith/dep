@extends('layouts.app')
@section('title', 'My Reservations - Car Rental')
@section('content')

<div class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="reservationData()">
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">My Reservations</h1>
                <p class="text-[#706f6c] dark:text-[#A1A09A]">Track and manage your vehicle bookings</p>
            </div>
            <div class="hidden sm:flex items-center space-x-4">
                <div class="bg-white dark:bg-[#161615] rounded-lg px-4 py-2 shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A]">
                    <span class="text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC]">Total Reservations: </span>
                    <span class="text-lg font-bold text-[#0000ff] dark:text-[#1111ff]" x-text="getFilteredCount()"></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Tabs -->
    <div class="mb-6">
        <div class="border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
            <nav class="flex space-x-8">
                <button @click="activeTab = 'all'" 
                        :class="activeTab === 'all' ? 'border-[#0000ff] text-[#0000ff] dark:border-[#1111ff] dark:text-[#1111ff]' : 'border-transparent text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:border-[#e3e3e0] dark:hover:border-[#3E3E3A]'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    All Reservations
                </button>
                <button @click="activeTab = 'active'" 
                        :class="activeTab === 'active' ? 'border-[#0000ff] text-[#0000ff] dark:border-[#1111ff] dark:text-[#1111ff]' : 'border-transparent text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:border-[#e3e3e0] dark:hover:border-[#3E3E3A]'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Active
                </button>
                <button @click="activeTab = 'upcoming'" 
                        :class="activeTab === 'upcoming' ? 'border-[#0000ff] text-[#0000ff] dark:border-[#1111ff] dark:text-[#1111ff]' : 'border-transparent text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:border-[#e3e3e0] dark:hover:border-[#3E3E3A]'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Upcoming
                </button>
                <button @click="activeTab = 'completed'" 
                        :class="activeTab === 'completed' ? 'border-[#0000ff] text-[#0000ff] dark:border-[#1111ff] dark:text-[#1111ff]' : 'border-transparent text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:border-[#e3e3e0] dark:hover:border-[#3E3E3A]'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Completed
                </button>
                <button @click="activeTab = 'cancelled'" 
                        :class="activeTab === 'cancelled' ? 'border-[#0000ff] text-[#0000ff] dark:border-[#1111ff] dark:text-[#1111ff]' : 'border-transparent text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:border-[#e3e3e0] dark:hover:border-[#3E3E3A]'"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-colors duration-200">
                    Cancelled
                </button>
            </nav>
        </div>
    </div>

    <!-- Reservations Grid -->
    @if($reservations && $reservations->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            @foreach($reservations as $reservation)
                <div class="reservation-card bg-white dark:bg-[#161615] rounded-xl shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1"
                     data-status="{{ $reservation->status }}"
                     x-show="activeTab === 'all' || 
                             (activeTab === 'active' && '{{ $reservation->status }}' === 'confirmed') ||
                             (activeTab === 'upcoming' && '{{ $reservation->status }}' === 'pending') ||
                             (activeTab === 'completed' && '{{ $reservation->status }}' === 'completed') ||
                             (activeTab === 'cancelled' && '{{ $reservation->status }}' === 'cancelled')"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 transform scale-95"
                     x-transition:enter-end="opacity-100 transform scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 transform scale-100"
                     x-transition:leave-end="opacity-0 transform scale-95">
                    
                    <!-- Vehicle Image -->
                    <div class="relative">
                        @if($reservation->vehicle && $reservation->vehicle->images && $reservation->vehicle->images->count() > 0)
                            <img src="{{ asset('storage/' . $reservation->vehicle->images->first()->url) }}" 
                                 alt="{{ $reservation->vehicle->brand }} {{ $reservation->vehicle->model }}"
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-[#dbdbd7] to-[#e3e3e0] dark:from-[#3E3E3A] dark:to-[#161615] flex items-center justify-center">
                                <i class="fas fa-car text-4xl text-[#706f6c] dark:text-[#A1A09A]"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            @php
                                $statusColors = [
                                    'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    'Confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                    'Completed' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                    'Cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                ];
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200' }}">
                                {{ ucfirst($reservation->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-6">
                        <!-- Vehicle Info -->
                        <div class="mb-4">
                            <h3 class="text-lg font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-1">
                                {{ $reservation->vehicle->brand ?? 'N/A' }} {{ $reservation->vehicle->model ?? 'N/A' }}
                            </h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $reservation->vehicle->year ?? 'N/A' }} • {{ $reservation->vehicle->fuel_type ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Reservation Details -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-sm">
                                <i class="fas fa-calendar-alt text-[#0000ff] dark:text-[#1111ff] w-4 mr-2"></i>
                                <span class="text-[#706f6c] dark:text-[#A1A09A]">Check-in:</span>
                                <span class="ml-2 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->start_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-calendar-check text-[#0000ff] dark:text-[#1111ff] w-4 mr-2"></i>
                                <span class="text-[#706f6c] dark:text-[#A1A09A]">Check-out:</span>
                                <span class="ml-2 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->end_date->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center text-sm">
                                <i class="fas fa-clock text-[#0000ff] dark:text-[#1111ff] w-4 mr-2"></i>
                                <span class="text-[#706f6c] dark:text-[#A1A09A]">Duration:</span>
                                <span class="ml-2 font-medium text-[#1b1b18] dark:text-[#EDEDEC]">{{ $reservation->start_date->diffInDays($reservation->end_date)+1 }} days</span>
                            </div>
                        </div>

                        <!-- Total Cost -->
                        <div class="border-t border-[#e3e3e0] dark:border-[#3E3E3A] pt-4 mb-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Total Cost:</span>
                                <span class="text-xl font-bold text-[#0000ff] dark:text-[#1111ff]">Rs.{{ number_format($reservation->total_cost, 2) }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="space-y-2">
                            <a href="{{ route('reservation.details', $reservation->reservation_id) }}" 
                               class="w-full bg-[#0000ff] dark:bg-[#1111ff] text-white text-center py-2 px-4 rounded-lg font-medium hover:bg-[#0000cc] dark:hover:bg-[#0000ee] transition-colors duration-200 block">
                                View Details
                            </a>
                            @if($reservation->status === 'pending')
                                <button onclick="cancelReservation({{ $reservation->reservation_id }})" 
                                        class="w-full px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#706f6c] dark:text-[#A1A09A] rounded-lg hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A] transition-colors duration-200">
                                    Cancel
                                </button>
                            @elseif($reservation->status === 'Completed')
                                @if(!$reservation->review)
                                    <button onclick="openReviewModal({{ $reservation->reservation_id }}, '{{ $reservation->vehicle->brand ?? 'N/A' }} {{ $reservation->vehicle->model ?? 'N/A' }}')" 
                                            class="w-full px-4 py-2 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-lg hover:from-yellow-600 hover:to-orange-600 transition-colors duration-200 flex items-center justify-center gap-2">
                                        <i class="fas fa-star text-sm"></i>
                                        Write Review
                                    </button>
                                @else
                                    <button onclick="openEditReviewModal({{ $reservation->review->id }}, {{ $reservation->reservation_id }}, '{{ $reservation->vehicle->brand ?? 'N/A' }} {{ $reservation->vehicle->model ?? 'N/A' }}', {{ $reservation->review->rating }}, {{ json_encode($reservation->review->comment) }})" 
                                            class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-colors duration-200 flex items-center justify-center gap-2">
                                        <i class="fas fa-edit text-sm"></i>
                                        Edit Review
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="max-w-md mx-auto">
                <div class="bg-gradient-to-br from-[#dbdbd7] to-[#e3e3e0] dark:from-[#3E3E3A] dark:to-[#161615] rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-car text-3xl text-[#706f6c] dark:text-[#A1A09A]"></i>
                </div>
                <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2">No Reservations Found</h3>
                <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6">You haven't made any reservations yet. Start exploring our vehicles to make your first booking.</p>
                <a href="{{ route('showVehicles') }}" 
                   class="inline-flex items-center px-6 py-3 bg-[#0000ff] dark:bg-[#1111ff] text-white font-medium rounded-lg hover:bg-[#0000cc] dark:hover:bg-[#0000ee] transition-colors duration-200">
                    <i class="fas fa-search mr-2"></i>
                    Browse Vehicles
                </a>
            </div>
        </div>
    @endif

    <!-- Filtered Empty State -->
    <div class="text-center py-12" 
         x-show="getFilteredCount() === 0 && {{ $reservations->count() }} > 0" 
         x-cloak>
        <div class="max-w-md mx-auto">
            <div class="bg-gradient-to-br from-[#dbdbd7] to-[#e3e3e0] dark:from-[#3E3E3A] dark:to-[#161615] rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-filter text-3xl text-[#706f6c] dark:text-[#A1A09A]"></i>
            </div>
            <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC] mb-2" x-text="getEmptyStateTitle()"></h3>
            <p class="text-[#706f6c] dark:text-[#A1A09A] mb-6" x-text="getEmptyStateMessage()"></p>
            <button @click="activeTab = 'all'" 
                    class="inline-flex items-center px-6 py-3 bg-[#0000ff] dark:bg-[#1111ff] text-white font-medium rounded-lg hover:bg-[#0000cc] dark:hover:bg-[#0000ee] transition-colors duration-200">
                <i class="fas fa-list mr-2"></i>
                View All Reservations
            </button>
        </div>
    </div>
</div>

<!-- Mobile Stats Card -->
<div class="sm:hidden fixed bottom-4 left-4 right-4 bg-white dark:bg-[#161615] rounded-lg shadow-lg border border-[#e3e3e0] dark:border-[#3E3E3A] p-4">
    <div class="flex items-center justify-between">
        <div class="text-center">
            <div class="text-lg font-bold text-[#0000ff] dark:text-[#1111ff]">{{ $reservations->where('status', 'confirmed')->count() }}</div>
            <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Active</div>
        </div>
        <div class="text-center">
            <div class="text-lg font-bold text-[#0000ff] dark:text-[#1111ff]">{{ $reservations->where('status', 'pending')->count() }}</div>
            <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Pending</div>
        </div>
        <div class="text-center">
            <div class="text-lg font-bold text-[#0000ff] dark:text-[#1111ff]">{{ $reservations->where('status', 'completed')->count() }}</div>
            <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Completed</div>
        </div>
        <div class="text-center">
            <div class="text-lg font-bold text-[#0000ff] dark:text-[#1111ff]">{{ $reservations->count() }}</div>
            <div class="text-xs text-[#706f6c] dark:text-[#A1A09A]">Total</div>
        </div>
    </div>
</div>

<style>
    .reservation-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .reservation-card:hover {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    /* Custom scrollbar for better UX */
    ::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }
    
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    
    /* Dark mode scrollbar */
    @media (prefers-color-scheme: dark) {
        ::-webkit-scrollbar-track {
            background: #3E3E3A;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #6B7280;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #9CA3AF;
        }
    }
    
    /* Animation for filtering */
    [x-cloak] { display: none !important; }
</style>

<script>
// Alpine.js data function
function reservationData() {
    return {
        activeTab: 'all',
        reservations: @json($reservations->pluck('status')),
        
        getFilteredCount() {
            if (this.activeTab === 'all') {
                return this.reservations.length;
            }
            
            const statusMap = {
                'active': 'confirmed',
                'upcoming': 'pending',
                'completed': 'completed',
                'cancelled': 'cancelled'
            };
            
            const targetStatus = statusMap[this.activeTab];
            return this.reservations.filter(status => status === targetStatus).length;
        },
        
        getEmptyStateTitle() {
            const titles = {
                'all': 'No Reservations Found',
                'active': 'No Active Reservations',
                'upcoming': 'No Upcoming Reservations',
                'completed': 'No Completed Reservations',
                'cancelled': 'No Cancelled Reservations'
            };
            return titles[this.activeTab] || 'No Reservations Found';
        },
        
        getEmptyStateMessage() {
            const messages = {
                'all': "You don't have any reservations.",
                'active': "You don't have any active reservations at the moment.",
                'upcoming': "You don't have any upcoming reservations. Book a vehicle to get started!",
                'completed': "You haven't completed any reservations yet.",
                'cancelled': "You don't have any cancelled reservations."
            };
            return messages[this.activeTab] || 'No reservations available.';
        }
    }
}
</script>

<!-- Review Modal -->
<div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4" style="display: none;">
    <div class="bg-white dark:bg-[#161615] rounded-xl shadow-2xl w-full max-w-md mx-auto">
        <div class="p-6">
            <!-- Modal Header -->
            <div class="flex items-center justify-between mb-6">
                <h3 id="reviewModalTitle" class="text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC]">Write a Review</h3>
                <button onclick="closeReviewModal()" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC]">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <!-- Vehicle Name -->
            <div class="mb-4">
                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Vehicle:</p>
                <p id="reviewVehicleName" class="font-semibold text-[#1b1b18] dark:text-[#EDEDEC]"></p>
            </div>
            
            <!-- Review Form -->
            <form id="reviewForm" onsubmit="submitReview(event)">
                <input type="hidden" id="reviewReservationId" name="reservation_id">
                <input type="hidden" id="reviewId" name="review_id" value="">
                <input type="hidden" id="isEdit" name="is_edit" value="false">
                
                <!-- Star Rating -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Rating</label>
                    <div class="flex items-center space-x-1">
                        <button type="button" onclick="setRating(1)" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors">
                            <i class="fas fa-star"></i>
                        </button>
                        <button type="button" onclick="setRating(2)" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors">
                            <i class="fas fa-star"></i>
                        </button>
                        <button type="button" onclick="setRating(3)" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors">
                            <i class="fas fa-star"></i>
                        </button>
                        <button type="button" onclick="setRating(4)" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors">
                            <i class="fas fa-star"></i>
                        </button>
                        <button type="button" onclick="setRating(5)" class="star-btn text-2xl text-gray-300 hover:text-yellow-400 transition-colors">
                            <i class="fas fa-star"></i>
                        </button>
                    </div>
                    <input type="hidden" id="reviewRating" name="rating" required>
                </div>
                
                <!-- Comment -->
                <div class="mb-6">
                    <label for="reviewComment" class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Comment</label>
                    <textarea id="reviewComment" name="comment" rows="4" required
                              class="w-full px-3 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg focus:ring-2 focus:ring-[#0000ff] focus:border-transparent bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] resize-none"
                              placeholder="Share your experience with this vehicle..."></textarea>
                </div>
                
                <!-- Submit Button -->
                <div class="flex space-x-3">
                    <button type="button" onclick="closeReviewModal()" 
                            class="flex-1 px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#706f6c] dark:text-[#A1A09A] rounded-lg hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A] transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" id="reviewSubmitBtn"
                            class="flex-1 bg-gradient-to-r from-[#0000ff] to-[#3333ff] text-white px-4 py-2 rounded-lg hover:from-[#0000cc] hover:to-[#2222cc] transition-colors duration-200">
                        Submit Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Review Modal Functions
let currentRating = 0;
let isEditMode = false;

function openReviewModal(reservationId, vehicleName) {
    isEditMode = false;
    document.getElementById('reviewModalTitle').textContent = 'Write a Review';
    document.getElementById('reviewSubmitBtn').textContent = 'Submit Review';
    document.getElementById('reviewReservationId').value = reservationId;
    document.getElementById('reviewId').value = '';
    document.getElementById('isEdit').value = 'false';
    document.getElementById('reviewVehicleName').textContent = vehicleName;
    const modal = document.getElementById('reviewModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
    resetReviewForm();
}

function openEditReviewModal(reviewId, reservationId, vehicleName, rating, comment) {
    isEditMode = true;
    document.getElementById('reviewModalTitle').textContent = 'Edit Review';
    document.getElementById('reviewSubmitBtn').textContent = 'Update Review';
    document.getElementById('reviewReservationId').value = reservationId;
    document.getElementById('reviewId').value = reviewId;
    document.getElementById('isEdit').value = 'true';
    document.getElementById('reviewVehicleName').textContent = vehicleName;
    
    // Populate existing review data
    currentRating = rating;
    document.getElementById('reviewRating').value = rating;
    document.getElementById('reviewComment').value = comment;
    updateStarDisplay();
    
    const modal = document.getElementById('reviewModal');
    modal.classList.remove('hidden');
    modal.style.display = 'flex';
}

function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.classList.add('hidden');
    modal.style.display = 'none';
    resetReviewForm();
    isEditMode = false;
}

function resetReviewForm() {
    currentRating = 0;
    document.getElementById('reviewRating').value = '';
    document.getElementById('reviewComment').value = '';
    document.getElementById('reviewId').value = '';
    document.getElementById('isEdit').value = 'false';
    updateStarDisplay();
}

function setRating(rating) {
    currentRating = rating;
    document.getElementById('reviewRating').value = rating;
    updateStarDisplay();
}

function updateStarDisplay() {
    const starButtons = document.querySelectorAll('.star-btn');
    starButtons.forEach((button, index) => {
        const star = button.querySelector('i');
        if (index < currentRating) {
            star.className = 'fas fa-star text-yellow-400';
        } else {
            star.className = 'fas fa-star text-gray-300';
        }
    });
}

function submitReview(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const isEdit = formData.get('is_edit') === 'true';
    const reviewId = formData.get('review_id');
    
    const reviewData = {
        rating: formData.get('rating'),
        comment: formData.get('comment')
    };
    
    // Add reservation_id only for new reviews
    if (!isEdit) {
        reviewData.reservation_id = formData.get('reservation_id');
    }
    
    if (!reviewData.rating || reviewData.rating < 1 || reviewData.rating > 5) {
        alert('Please select a rating between 1 and 5 stars.');
        return;
    }
    
    if (!reviewData.comment.trim()) {
        alert('Please write a comment for your review.');
        return;
    }
    
    // Determine URL and method based on edit mode
    const url = isEdit ? `/reviews/${reviewId}` : '{{ route("reviews.store") }}';
    const method = isEdit ? 'PUT' : 'POST';
    
    // Submit review via AJAX
    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(reviewData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            closeReviewModal();
            location.reload(); // Refresh to show the updated review
        } else {
            alert(data.message || `Failed to ${isEdit ? 'update' : 'submit'} review`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert(`An error occurred while ${isEdit ? 'updating' : 'submitting'} your review`);
    });
}

// Close modal when clicking outside
document.getElementById('reviewModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeReviewModal();
    }
});
</script>

@endsection
