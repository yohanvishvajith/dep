@extends('layouts.app')
@section('title', 'Wenujaya Rent a Car - Fleet')
@section('content')
    <div class="container py-25 mt-40 mx-auto px-4 sm:px-6 lg:px-8 max-w-7xl">
        <!-- Page Heading Section -->
        <div class="text-center mb-12">
            <div class="flex items-center justify-between mb-4">
                <div class="flex-1"></div>
                <h2 class="text-3xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] sm:text-4xl font-manrope">
                    Explore Our Premium Vehicle Collection
                </h2>
                <div class="flex-1 flex justify-end">
                    <!-- Filter Icon Button -->
                    <button onclick="toggleFilterModal()" 
                            class="bg-white dark:bg-[#161615] border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg p-3 hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A] transition-colors duration-200 shadow-sm">
                        <i class="fas fa-filter text-[#0000ff] dark:text-[#1111ff] text-lg"></i>
                    </button>
                </div>
            </div>
            <p class="text-lg text-[#706f6c] dark:text-[#A1A09A] max-w-3xl mx-auto">
                Choose from our wide selection of well-maintained vehicles for every travel need. 
                Whether you're looking for economy, comfort, or luxury, we have the perfect vehicle for your journey.
            </p>
        </div>

        <!-- Filter Modal -->
        <div id="filterModal" class="fixed inset-0 z-50 hidden">
            <!-- Backdrop -->
            <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="toggleFilterModal()"></div>
            
            <!-- Modal Content -->
            <div class="relative flex items-center justify-center min-h-screen p-4">
                <div class="bg-white dark:bg-[#161615] rounded-xl shadow-xl border border-[#e3e3e0] dark:border-[#3E3E3A] w-full max-w-2xl transform transition-all duration-300 scale-95 opacity-0" id="filterModalContent">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                        <h3 class="text-xl font-semibold text-[#1b1b18] dark:text-[#EDEDEC]">Filter Vehicles</h3>
                        <button onclick="toggleFilterModal()" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-[#0000ff] dark:hover:text-[#1111ff] transition-colors duration-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="p-6 space-y-6">
                        <!-- Search Input -->
                        <div>
                            <label class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Search Vehicles</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-[#706f6c] dark:text-[#A1A09A]"></i>
                                </div>
                                <input type="text" 
                                       id="searchInput"
                                       placeholder="Search by brand, model..." 
                                       class="block w-full pl-10 pr-3 py-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#706f6c] dark:placeholder-[#A1A09A] focus:outline-none focus:ring-2 focus:ring-[#0000ff] dark:focus:ring-[#1111ff] focus:border-transparent">
                            </div>
                        </div>
                        
                        <!-- Filter Options Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Fuel Type Filter -->
                            <div>
                                <label class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Fuel Type</label>
                                <select id="fuelTypeFilter" 
                                        class="block w-full py-3 px-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-[#0000ff] dark:focus:ring-[#1111ff] focus:border-transparent">
                                    <option value="">All Fuel Types</option>
                                    <option value="petrol">Petrol</option>
                                    <option value="diesel">Diesel</option>
                                    <option value="hybrid">Hybrid</option>
                                    <option value="electric">Electric</option>
                                </select>
                            </div>
                            
                            <!-- Price Range Filter -->
                            <div>
                                <label class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Price Range</label>
                                <select id="priceRangeFilter" 
                                        class="block w-full py-3 px-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-[#0000ff] dark:focus:ring-[#1111ff] focus:border-transparent">
                                    <option value="">All Prices</option>
                                    <option value="0-50">$0 - $50</option>
                                    <option value="51-100">$51 - $100</option>
                                    <option value="101-200">$101 - $200</option>
                                    <option value="201+">$201+</option>
                                </select>
                            </div>
                            
                            <!-- Seats Filter -->
                            <div>
                                <label class="block text-sm font-medium text-[#1b1b18] dark:text-[#EDEDEC] mb-2">Number of Seats</label>
                                <select id="seatsFilter" 
                                        class="block w-full py-3 px-3 border border-[#e3e3e0] dark:border-[#3E3E3A] rounded-lg bg-white dark:bg-[#161615] text-[#1b1b18] dark:text-[#EDEDEC] focus:outline-none focus:ring-2 focus:ring-[#0000ff] dark:focus:ring-[#1111ff] focus:border-transparent">
                                    <option value="">Any Seats</option>
                                    <option value="2">2 Seats</option>
                                    <option value="4">4 Seats</option>
                                    <option value="5">5 Seats</option>
                                    <option value="7">7+ Seats</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Results Count -->
                        <div class="bg-[#f5f5f5] dark:bg-[#3E3E3A] rounded-lg p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Results:</span>
                                <span id="resultsCount" class="text-sm font-medium text-[#0000ff] dark:text-[#1111ff]">0 vehicles found</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal Footer -->
                    <div class="flex items-center justify-between p-6 border-t border-[#e3e3e0] dark:border-[#3E3E3A] space-x-4">
                        <button onclick="clearAllFilters()" 
                                class="px-4 py-2 text-[#706f6c] dark:text-[#A1A09A] hover:text-[#0000ff] dark:hover:text-[#1111ff] transition-colors duration-200">
                            Clear All
                        </button>
                        <div class="flex space-x-3">
                            <button onclick="toggleFilterModal()" 
                                    class="px-6 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] rounded-lg hover:bg-[#f5f5f5] dark:hover:bg-[#3E3E3A] transition-colors duration-200">
                                Cancel
                            </button>
                            <button onclick="applyFilters()" 
                                    class="px-6 py-2 bg-[#0000ff] dark:bg-[#1111ff] text-white rounded-lg hover:bg-[#d12a00] dark:hover:bg-[#e53e2e] transition-colors duration-200">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vehicle Grid Section -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($vehicles as $vehicle)
                <div class="group bg-white dark:bg-[#161615] rounded-xl shadow-sm border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-300 ease-out">
                    <!-- Vehicle Image -->
                    <div class="relative overflow-hidden">
                        @if($vehicle->images->isNotEmpty())
                            <img class="w-full h-48 sm:h-52 object-cover group-hover:scale-105 transition-transform duration-300" 
                                 src="{{ asset('storage/' . $vehicle->images->first()->url) }}" 
                                 alt="{{ $vehicle->brand }} {{ $vehicle->model }}">
                        @else
                            <div class="w-full h-48 sm:h-52 bg-gradient-to-br from-[#dbdbd7] to-[#e3e3e0] dark:from-[#3E3E3A] dark:to-[#161615] flex items-center justify-center">
                                <i class="fas fa-car text-4xl text-[#706f6c] dark:text-[#A1A09A]"></i>
                            </div>
                        @endif
                        
                       
                        
                        <!-- Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-4 sm:p-5">
                        <!-- Vehicle Title -->
                        <div class="mb-3">
                            <h3 class="text-lg sm:text-xl font-bold text-[#1b1b18] dark:text-[#EDEDEC] mb-1 line-clamp-1">
                                {{ $vehicle->brand }} {{ $vehicle->model }}
                            </h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                {{ $vehicle->year ?? 'N/A' }} • {{ $vehicle->fuel_type ?? 'N/A' }}
                            </p>
                        </div>

                        <!-- Vehicle Features -->
                        <div class="grid grid-cols-2 gap-2 mb-4 text-xs">
                            <div class="flex items-center text-[#706f6c] dark:text-[#A1A09A]">
                                <i class="fas fa-users w-4 mr-1.5 text-[#0000ff] dark:text-[#1111ff]"></i>
                                <span>{{ $vehicle->seats ?? 'N/A' }} Seats</span>
                            </div>
                            <div class="flex items-center text-[#706f6c] dark:text-[#A1A09A]">
                                <i class="fas fa-gas-pump w-4 mr-1.5 text-[#0000ff] dark:text-[#1111ff]"></i>
                                <span>{{ $vehicle->fuel_type ?? 'N/A' }}</span>
                            </div>
                            <div class="flex items-center text-[#706f6c] dark:text-[#A1A09A]">
                                <i class="fas fa-cog w-4 mr-1.5 text-[#0000ff] dark:text-[#1111ff]"></i>
                                <span>{{ $vehicle->engine ?? 'Auto' }}</span>
                            </div>
                            <div class="flex items-center text-[#706f6c] dark:text-[#A1A09A]">
                                <i class="fas fa-palette w-4 mr-1.5 text-[#0000ff] dark:text-[#1111ff]"></i>
                                <span>{{ $vehicle->color ?? 'N/A' }}</span>
                            </div>
                                 <div class="flex items-center text-[#706f6c] dark:text-[#A1A09A]">
                                <i class="fas fa-tachometer-alt w-4 mr-1.5 text-[#0000ff] dark:text-[#1111ff]"></i>
                                <span>{{ $vehicle->fuel_efficiency ?? 'N/A' }}km/l</span>
                            </div>
                        </div>

                        <!-- Pricing & CTA -->
                        <div class="flex items-center justify-between pt-3 border-t border-[#e3e3e0] dark:border-[#3E3E3A]">
                            <div class="flex flex-col">
                                <div class="flex items-baseline">
                                    <span class="text-xl sm:text-2xl font-bold text-[#0000ff] dark:text-[#1111ff]">
                                        Rs.{{ number_format($vehicle->daily_rate, 0) }}
                                    </span>
                                    <span class="text-sm text-[#706f6c] dark:text-[#A1A09A] ml-1">/day</span>
                                </div>
                            </div>
                            
                            <div class="flex flex-col gap-2">
                                <a href="{{ route('vehicle.details', $vehicle->vehicle_id) }}" 
                                   class="bg-[#0000ff] dark:bg-[#1111ff] text-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-[#d12a00] dark:hover:bg-[#e53e2e] transition-colors duration-200 text-center">
                                    Book Now
                                </a>
                          
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-12 text-center">
            {{ $vehicles->links() }}
        </div>

        <!-- Call to Action -->
        {{-- <div class="mt-12 text-center">
            <button class="group px-6 py-3 bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow transition-all duration-300 inline-flex items-center">
                <span class="text-white text-base font-medium leading-6">View All Vehicles</span>
                <svg class="ml-2 group-hover:translate-x-1 transition-all duration-300" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                    <path d="M6.6665 5L13.3332 10L6.6665 15" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div> --}}
    </div>

    <style>
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
        
        /* Line clamp utility */
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }
        
        /* Enhanced card hover effects */
        .group:hover .group-hover\:scale-105 {
            transform: scale(1.05);
        }
        
        /* Smooth transitions for all interactive elements */
        * {
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        /* Loading skeleton animation */
        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }
            100% {
                background-position: calc(200px + 100%) 0;
            }
        }
        
        .loading-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200px 100%;
            animation: shimmer 1.5s infinite;
        }
        
        /* Responsive grid improvements */
        @media (min-width: 640px) {
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }
        
        @media (min-width: 1024px) {
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }
        
        @media (min-width: 1280px) {
            .grid {
                grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            }
        }
        
        /* Enhanced focus states for accessibility */
        .focus\:ring-2:focus {
            ring-width: 2px;
            ring-color: rgb(245 48 3 / 0.5);
            ring-offset-width: 2px;
            ring-offset-color: rgb(255 255 255);
        }
        
        @media (prefers-color-scheme: dark) {
            .focus\:ring-2:focus {
                ring-offset-color: rgb(22 22 21);
            }
        }
    </style>

    <script>
        // Filter modal functionality
        function toggleFilterModal() {
            const modal = document.getElementById('filterModal');
            const modalContent = document.getElementById('filterModalContent');
            
            if (modal.classList.contains('hidden')) {
                // Show modal
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modalContent.classList.remove('scale-95', 'opacity-0');
                    modalContent.classList.add('scale-100', 'opacity-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            } else {
                // Hide modal
                modalContent.classList.remove('scale-100', 'opacity-100');
                modalContent.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 300);
            }
        }

        // Apply filters function
        function applyFilters() {
            const searchTerm = document.getElementById('searchInput').value;
            const fuelType = document.getElementById('fuelTypeFilter').value;
            const priceRange = document.getElementById('priceRangeFilter').value;
            const seats = document.getElementById('seatsFilter').value;
            
            filterVehicles(searchTerm, fuelType, priceRange, seats);
            toggleFilterModal();
            showToast('Filters applied successfully');
        }

        // Clear all filters
        function clearAllFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('fuelTypeFilter').value = '';
            document.getElementById('priceRangeFilter').value = '';
            document.getElementById('seatsFilter').value = '';
            
            // Reset all vehicles to visible
            const cards = document.querySelectorAll('.group');
            cards.forEach(card => {
                card.style.display = 'block';
            });
            
            updateResultsCount();
            showToast('All filters cleared');
        }

        // Enhanced filter function
        function filterVehicles(searchTerm = '', fuelType = '', priceRange = '', seats = '') {
            const cards = document.querySelectorAll('.group');
            
            cards.forEach(card => {
                let isVisible = true;
                
                // Search filter
                if (searchTerm) {
                    const title = card.querySelector('h3').textContent.toLowerCase();
                    isVisible = isVisible && title.includes(searchTerm.toLowerCase());
                }
                
                // Fuel type filter
                if (fuelType) {
                    const fuelText = card.querySelector('p').textContent.toLowerCase();
                    isVisible = isVisible && fuelText.includes(fuelType.toLowerCase());
                }
                
                // Price range filter
                if (priceRange) {
                    const priceText = card.querySelector('.text-xl, .text-2xl').textContent;
                    const price = parseInt(priceText.replace(/[^0-9]/g, ''));
                    
                    if (priceRange === '0-50') {
                        isVisible = isVisible && (price >= 0 && price <= 50);
                    } else if (priceRange === '51-100') {
                        isVisible = isVisible && (price >= 51 && price <= 100);
                    } else if (priceRange === '101-200') {
                        isVisible = isVisible && (price >= 101 && price <= 200);
                    } else if (priceRange === '201+') {
                        isVisible = isVisible && (price >= 201);
                    }
                }
                
                // Seats filter
                if (seats) {
                    const seatsText = card.querySelector('.fa-users').parentElement.textContent;
                    const vehicleSeats = parseInt(seatsText.replace(/[^0-9]/g, ''));
                    
                    if (seats === '7') {
                        isVisible = isVisible && vehicleSeats >= 7;
                    } else {
                        isVisible = isVisible && vehicleSeats == seats;
                    }
                }
                
                // Show/hide card
                if (isVisible) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.3s ease-out';
                } else {
                    card.style.display = 'none';
                }
            });
            
            updateResultsCount();
        }

        // Update results count
        function updateResultsCount() {
            const visibleCards = document.querySelectorAll('.group[style*="display: block"], .group:not([style*="display: none"])').length;
            const totalCards = document.querySelectorAll('.group').length;
            
            const resultsCount = document.getElementById('resultsCount');
            if (resultsCount) {
                resultsCount.textContent = `${visibleCards} vehicles found`;
            }
        }

        // Real-time search in modal
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value;
                    const fuelType = document.getElementById('fuelTypeFilter').value;
                    const priceRange = document.getElementById('priceRangeFilter').value;
                    const seats = document.getElementById('seatsFilter').value;
                    
                    filterVehicles(searchTerm, fuelType, priceRange, seats);
                });
            }
            
            // Initial count
            updateResultsCount();
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                const modal = document.getElementById('filterModal');
                if (!modal.classList.contains('hidden')) {
                    toggleFilterModal();
                }
            }
        });

        // Favorite functionality
        function toggleFavorite(vehicleId) {
            const heartIcon = event.target.querySelector('i') || event.target;
            
            // Toggle heart icon
            if (heartIcon.classList.contains('far')) {
                heartIcon.classList.remove('far');
                heartIcon.classList.add('fas');
                heartIcon.style.color = '#0000ff';
            } else {
                heartIcon.classList.remove('fas');
                heartIcon.classList.add('far');
                heartIcon.style.color = '';
            }
            
            // Here you can add AJAX call to save/remove favorite
            // fetch(`/vehicles/${vehicleId}/favorite`, { method: 'POST', ... })
            
            // Show toast notification
            showToast('Vehicle ' + (heartIcon.classList.contains('fas') ? 'added to' : 'removed from') + ' favorites');
        }
        
        // Simple toast notification
        function showToast(message) {
            const toast = document.createElement('div');
            toast.className = 'fixed top-4 right-4 bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] px-4 py-2 rounded-lg shadow-lg z-50 transition-all duration-300 transform translate-x-full';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            // Animate in
            setTimeout(() => {
                toast.classList.remove('translate-x-full');
            }, 100);
            
            // Animate out and remove
            setTimeout(() => {
                toast.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 3000);
        }
        
        // Lazy loading for images (if needed)
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('img[data-src]');
            
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            img.src = img.dataset.src;
                            img.classList.remove('loading-skeleton');
                            imageObserver.unobserve(img);
                        }
                    });
                });
                
                images.forEach(img => imageObserver.observe(img));
            } else {
                // Fallback for browsers without IntersectionObserver
                images.forEach(img => {
                    img.src = img.dataset.src;
                    img.classList.remove('loading-skeleton');
                });
            }
        });
        
        // Add fade-in animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection