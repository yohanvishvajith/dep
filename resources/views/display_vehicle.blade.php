@extends('layouts.app')
@section('title', 'Car Rental - Vehicle Details')
@section('content')
<style>
    .vehicle-gallery {
        position: relative;
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e3e3e0;
    }
    
    .main-image {
        width: 100%;
        height: 300px;
        object-fit: cover;
        border-radius: 12px;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 255, 0.1);
    }
    
    .thumbnail-container {
        display: flex;
        gap: 0.75rem;
        overflow-x: auto;
        padding: 0.5rem 0;
        scrollbar-width: thin;
    }
    
    .thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 3px solid #e3e3e0;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        flex-shrink: 0;
    }
    
    .thumbnail:hover {
        border-color: #0000ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 255, 0.2);
    }
    
    .thumbnail.active {
        border-color: #0000ff;
        box-shadow: 0 0 0 2px rgba(0, 0, 255, 0.2);
    }
    
    /* Hide scrollbar but keep functionality */
    .thumbnail-container::-webkit-scrollbar {
        height: 6px;
    }
    
    .thumbnail-container::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 3px;
    }
    
    .thumbnail-container::-webkit-scrollbar-thumb {
        background: #0000ff;
        border-radius: 3px;
    }
    
    .thumbnail-container::-webkit-scrollbar-thumb:hover {
        background: #0000cc;
    }
    
    .vehicle-info {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border: 1px solid #e3e3e0;
        height: fit-content;
    }
    
    .vehicle-badge {
        display: inline-block;
        background: linear-gradient(135deg, #0000ff, #3333ff);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .vehicle-title {
        color: #1b1b18;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 1rem;
        line-height: 1.2;
    }
    
    .price-display {
        background: linear-gradient(135deg, #f8fafc, #e2e8f0);
        border: 2px solid #0000ff;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    
    .price-amount {
        font-size: 2rem;
        font-weight: 800;
        color: #0000ff;
        margin-bottom: 0.25rem;
    }
    
    .price-period {
        color: #64748b;
        font-size: 1rem;
        font-weight: 500;
    }
    
    .feature-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 0.75rem;
        margin-bottom: 1.5rem;
    }
    
    .feature-item {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }
    
    .feature-item:hover {
        background: #f1f5f9;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 255, 0.1);
    }
    
    .feature-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #0000ff, #3333ff);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
    }
    
    .feature-text {
        flex: 1;
    }
    
    .feature-label {
        font-size: 0.75rem;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.25rem;
    }
    
    .feature-value {
        font-weight: 600;
        color: #1e293b;
    }
    
    @media (min-width: 1024px) {
        .vehicle-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            align-items: start;
        }
    }
    
    @media (max-width: 768px) {
        .vehicle-title {
            font-size: 1.75rem;
        }
        
        .price-amount {
            font-size: 1.75rem;
        }
        
        .feature-grid {
            grid-template-columns: 1fr;
        }
        
        .vehicle-info {
            padding: 1rem;
        }
        
        .vehicle-gallery {
            padding: 1rem;
        }
        
        .main-image {
            height: 250px;
        }
    }
    
    /* Rental form styles */
    .rental-form {
        background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .rental-form::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #0000ff, #3333ff, #0000ff);
    }
    
    .rental-form h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .rental-form h3::before {
        content: '📅';
        font-size: 1rem;
    }
    
    .form-group {
        margin-bottom: 1.25rem;
    }
    
    .form-group label {
        display: block;
        font-size: 0.8rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
    
    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        background: white;
    }
    
    .form-control:focus {
        outline: none;
        border-color: #0000ff;
        box-shadow: 0 0 0 3px rgba(0, 0, 255, 0.1);
        transform: translateY(-1px);
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }
    
    @media (max-width: 640px) {
        .form-row {
            grid-template-columns: 1fr;
        }
    }
    
    .section-divider {
        height: 2px;
        background: linear-gradient(90deg, transparent, #0000ff, transparent);
        margin: 1.5rem 0;
        border-radius: 1px;
    }
    
    .time-select {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .time-select select {
        flex: 1;
    }
    
    .total-price-section {
        background: linear-gradient(135deg, #0000ff, #3333ff);
        color: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin: 1.5rem 0;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 255, 0.25);
    }
    
    .total-price-amount {
        font-size: 2.25rem;
        font-weight: 800;
        margin-bottom: 0.25rem;
    }
    
    .total-price-label {
        font-size: 1rem;
        opacity: 0.9;
    }
    
    .payment-button {
        background: linear-gradient(135deg, #22c55e, #16a34a);
        color: white;
        padding: 1rem 1.5rem;
        border: none;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        box-shadow: 0 3px 12px rgba(34, 197, 94, 0.25);
    }
    
    .payment-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(34, 197, 94, 0.3);
    }
    
    .payment-button:active {
        transform: translateY(0);
    }
    
    /* Animations */
    .fade-in {
        animation: fadeIn 0.6s ease-out;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Alert styling */
    .alert {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #dc2626;
        padding: 1rem;
        border-radius: 8px;
        margin-top: 1rem;
    }
    
    .alert ul {
        margin: 0;
        padding-left: 1.5rem;
    }
</style>

<section class="py-12 lg:py-16 mt-20 bg-gradient-to-br from-slate-50 to-blue-50">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-6xl">
        <div class="vehicle-container fade-in">
            <!-- Vehicle Gallery -->
            <div class="vehicle-gallery">
                <img id="main-image" src="{{ asset('storage/' . $vehicle->images->first()->url) }}" alt="{{ $vehicle->brand }} {{ $vehicle->model }}" class="main-image">
               
                <div class="thumbnail-container">
                    @foreach($vehicle->images as $index => $image)
                    <img src="{{ asset('storage/' . $image->url) }}" alt="Vehicle Image {{ $index + 1 }}" 
                         class="thumbnail {{ $index === 0 ? 'active' : '' }}" 
                         onclick="changeImage('{{ asset('storage/' . $image->url) }}', this)">
                    @endforeach
                </div>
            </div>
            
            <!-- Vehicle Info -->
            <div class="vehicle-info">
                <h1 class="vehicle-title">{{ $vehicle->brand }} {{ $vehicle->model }}</h1>
                
                <div class="price-display">
                    <div class="price-amount">Rs.{{ number_format($vehicle->daily_rate) }}</div>
                    <div class="price-period">Per Day</div>
                </div>
                
                <!-- Vehicle Features Grid -->
                <div class="feature-grid">
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div class="feature-text">
                            <div class="feature-label">Transmission</div>
                            <div class="feature-value">{{ $vehicle->engine ?? 'Auto' }}</div>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                              <i class="fas fa-tachometer-alt"></i>
                        </div>
                        <div class="feature-text">
                            <div class="feature-label">Fuel Efficiency</div>
                            <div class="feature-value">{{ $vehicle->fuel_efficiency ?? 'N/A' }} km/l</div>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="feature-text">
                            <div class="feature-label">Seating</div>
                            <div class="feature-value">{{ $vehicle->seats ?? 'N/A' }} Passengers</div>
                        </div>
                    </div>
                    
                    <div class="feature-item">
                        <div class="feature-icon">
                          
                            <i class="fas fa-gas-pump"></i>
                        </div>
                        <div class="feature-text">
                            <div class="feature-label">Fuel Type</div>
                            <div class="feature-value">{{ $vehicle->fuel_type ?? $vehicle->fuel ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Rental Form Section -->
                <form action="{{ route('booking.create') }}" method="get">
                    <div class="rental-form">
                        <h3>Book Your Rental</h3>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="pickup-date">Pick-Up Date</label>
                                <input type="date" id="pickup-date" class="form-control" name="pickupdate" min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label for="pickup-time">Pick-Up Time</label>
                                <select id="pickup-time" class="form-control" name="pickup_time">
                                    <option value="08:00">08:00 AM</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                    <option value="17:00">05:00 PM</option>
                                    <option value="18:00">06:00 PM</option>
                                    <option value="19:00">07:00 PM</option>
                                    <option value="20:00">08:00 PM</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="section-divider"></div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="dropoff-date">Drop-Off Date</label>
                                <input type="date" id="dropoff-date" class="form-control" name="dropoffdate" min="{{ date('Y-m-d') }}" required>
                                <input type="hidden" name="vehicle_id" value="{{ $vehicle->vehicle_id }}">
                                <input type="hidden" name="daily_rate" value="{{ $vehicle->daily_rate }}">
                            </div>
                            <div class="form-group">
                                <label for="dropoff-time">Drop-Off Time</label>
                                <select id="dropoff-time" class="form-control" name="dropoff_time">
                                    <option value="08:00">08:00 AM</option>
                                    <option value="09:00">09:00 AM</option>
                                    <option value="10:00">10:00 AM</option>
                                    <option value="11:00">11:00 AM</option>
                                    <option value="12:00">12:00 PM</option>
                                    <option value="13:00">01:00 PM</option>
                                    <option value="14:00">02:00 PM</option>
                                    <option value="15:00">03:00 PM</option>
                                    <option value="16:00">04:00 PM</option>
                                    <option value="17:00">05:00 PM</option>
                                    <option value="18:00">06:00 PM</option>
                                    <option value="19:00">07:00 PM</option>
                                    <option value="20:00">08:00 PM</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Total Price Display -->
                    <div class="total-price-section">
                        <div class="total-price-amount" id="total-price">Rs.{{ number_format($vehicle->daily_rate) }}</div>
                        <div class="total-price-label">Total Rental Cost</div>
                    </div>
                    
                    <!-- Submit Button -->
                    <button type="submit" class="payment-button">
                        <i class="fas fa-credit-card mr-2"></i>
                        Proceed to Payment
                    </button>
                    
                    @if ($errors->any())
                    <div class="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </form>
            </div>
        </div>
        
        <!-- Reviews Section - Full Width Below -->
        <div class="vehicle-gallery mt-8 fade-in">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-[#1b1b18] flex items-center gap-2">
                    <i class="fas fa-star text-[#0000ff]"></i>
                    Customer Reviews
                </h2>
                <div class="flex items-center gap-2">
                    <div class="flex items-center">
                        @php
                            $averageRating = $vehicle->average_rating;
                            $fullStars = floor($averageRating);
                            $hasHalfStar = ($averageRating - $fullStars) >= 0.5;
                            $emptyStars = 5 - $fullStars - ($hasHalfStar ? 1 : 0);
                        @endphp
                        
                        @for($i = 0; $i < $fullStars; $i++)
                            <i class="fas fa-star text-yellow-400"></i>
                        @endfor
                        
                        @if($hasHalfStar)
                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                        @endif
                        
                        @for($i = 0; $i < $emptyStars; $i++)
                            <i class="fas fa-star text-gray-300"></i>
                        @endfor
                    </div>
                    <span class="text-sm font-medium text-[#706f6c]">
                        {{ number_format($averageRating, 1) }} ({{ $vehicle->review_count }} reviews)
                    </span>
                </div>
            </div>

            @if($vehicle->reviews->count() > 0)
                <!-- Review Cards Grid -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 mb-6">
                    @foreach($vehicle->reviews as $review)
                        <div class="bg-gradient-to-r from-[#f8fafc] to-[#f1f5f9] border border-[#e2e8f0] rounded-lg p-4 transition-all duration-300 hover:shadow-md hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    @php
                                        $userName = $review->user->name ?? 'Anonymous User';
                                        $initials = collect(explode(' ', $userName))->map(function($name) {
                                            return strtoupper(substr($name, 0, 1));
                                        })->take(2)->implode('');
                                    @endphp
                                    <div class="w-10 h-10 bg-gradient-to-br from-[#0000ff] to-[#3333ff] rounded-full flex items-center justify-center text-white font-semibold">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-[#1b1b18] text-sm">{{ $userName }}</h4>
                                        <p class="text-xs text-[#706f6c]">Verified Customer</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-sm {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                    @endfor
                                    <span class="text-xs text-[#706f6c] ml-1">{{ $review->rating }}.0</span>
                                </div>
                            </div>
                            <p class="text-sm text-[#1b1b18] leading-relaxed mb-3">
                                "{{ $review->comment }}"
                            </p>
                            <div class="flex items-center gap-4 text-xs text-[#706f6c]">
                                <span><i class="fas fa-calendar-alt mr-1"></i>{{ $review->created_at->format('M d, Y') }}</span>
                                @if($review->reservation)
                                    @php
                                        $startDate = \Carbon\Carbon::parse($review->reservation->start_date);
                                        $endDate = \Carbon\Carbon::parse($review->reservation->end_date);
                                        $days = $startDate->diffInDays($endDate) + 1;
                                    @endphp
                                    <span><i class="fas fa-car mr-1"></i>{{ $days }}-day rental</span>
                                @else
                                    <span><i class="fas fa-car mr-1"></i>Rental completed</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- No Reviews Message -->
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-star text-gray-400 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Reviews Yet</h3>
                    <p class="text-gray-500">Be the first to review this vehicle after your rental!</p>
                </div>
            @endif

           
        </div>
    </div>
</section>

@if(session('success'))
<div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transition-all duration-300">
    <i class="fas fa-check-circle mr-2"></i>
    {{ session('success') }}
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pickupDate = document.getElementById('pickup-date');
    const dropoffDate = document.getElementById('dropoff-date');
    const totalPriceElem = document.getElementById('total-price');
    const dailyRate = parseFloat("{{ $vehicle->daily_rate }}");

    function calculateTotal() {
        const start = pickupDate.value;
        const end = dropoffDate.value;
        
        if (start && end) {
            const startDate = new Date(start);
            const endDate = new Date(end);
            let days = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
            
            if (days > 0) {
                const total = days * dailyRate;
                totalPriceElem.textContent = `Rs.${total.toLocaleString()}`;
                
                // Add subtle animation
                totalPriceElem.style.transform = 'scale(1.05)';
                setTimeout(() => {
                    totalPriceElem.style.transform = 'scale(1)';
                }, 200);
            } else {
                totalPriceElem.textContent = `Rs.${dailyRate.toLocaleString()}`;
            }
        } else {
            totalPriceElem.textContent = `Rs.${dailyRate.toLocaleString()}`;
        }
    }

    // Auto-hide success message
    const successAlert = document.querySelector('.fixed.top-4.right-4');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transform = 'translateX(100%)';
            setTimeout(() => {
                successAlert.remove();
            }, 300);
        }, 3000);
    }

    pickupDate.addEventListener('change', calculateTotal);
    dropoffDate.addEventListener('change', calculateTotal);
    
    // Ensure drop-off date is after pickup date
    pickupDate.addEventListener('change', function() {
        dropoffDate.min = this.value;
        if (dropoffDate.value && dropoffDate.value < this.value) {
            dropoffDate.value = this.value;
        }
        calculateTotal();
    });
});

// Enhanced image gallery functionality
function changeImage(src, element) {
    const mainImage = document.getElementById('main-image');
    
    // Add loading effect
    mainImage.style.opacity = '0.7';
    
    setTimeout(() => {
        mainImage.src = src;
        mainImage.style.opacity = '1';
    }, 150);
    
    // Remove active class from all thumbnails
    const thumbnails = document.querySelectorAll('.thumbnail');
    thumbnails.forEach(thumb => thumb.classList.remove('active'));
    
    // Add active class to clicked thumbnail
    element.classList.add('active');
}

// Add smooth scrolling for thumbnails on mobile
const thumbnailContainer = document.querySelector('.thumbnail-container');
if (thumbnailContainer) {
    thumbnailContainer.style.scrollBehavior = 'smooth';
}
</script>  
@endsection