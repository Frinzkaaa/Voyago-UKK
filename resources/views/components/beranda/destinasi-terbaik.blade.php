@php
    // Data Statis Destinasi
    $staticDestinations = [
        [
            'id' => 1,
            'name' => 'Raja Ampat',
            'loc' => 'Papua Barat',
            'img' => 'https://images.unsplash.com/photo-1516690561799-46d8f74f9abf?auto=format&fit=crop&w=800&q=80',
            'desc' => 'Surga bawah laut terakhir di dunia dengan ribuan spesies ikan dan terumbu karang yang mempesona. Cocok untuk diving dan snorkeling.',
            'rating' => '4.9',
            'price' => 'Rp 5.000.000 (Estimasi)'
        ],
        [
            'id' => 2,
            'name' => 'Candi Borobudur',
            'loc' => 'Jawa Tengah',
            'img' => 'https://images.unsplash.com/photo-1578469550956-0e16b69c6a3d?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MTB8fGJvcm9idWR1cnxlbnwwfHwwfHx8MA%3D%3D',
            'desc' => 'Monumen Buddha terbesar di dunia peninggalan Dinasti Syailendra. Bangunan megah yang menjadi warisan budaya dunia UNESCO.',
            'rating' => '4.8',
            'price' => 'Rp 50.000'
        ],
        [
            'id' => 3,
            'name' => 'Gunung Bromo',
            'loc' => 'Probolinggo',
            'img' => 'https://images.unsplash.com/photo-1605860632725-fa88d0ce7a07?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8N3x8YnJvbW98ZW58MHx8MHx8fDA%3D',
            'desc' => 'Pemandangan kawah aktif yang menakjubkan dengan lautan pasir luas. Momen matahari terbit di sini adalah salah satu yang terbaik di dunia.',
            'rating' => '4.8',
            'price' => 'Rp 27.500'
        ],
        [
            'id' => 4,
            'name' => 'Nusa Penida',
            'loc' => 'Bali',
            'img' => 'https://plus.unsplash.com/premium_photo-1697730113048-1903ddc36c58?w=600&auto=format&fit=crop&q=60&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8MXx8bnVzYSUyMHBlbmlkYXxlbnwwfHwwfHx8MA%3D%3D',
            'desc' => 'Pulau dengan tebing-tebing ikonik seperti Kelingking Beach. Destinasi favorit bagi pecinta petualangan dan fotografi.',
            'rating' => '4.7',
            'price' => 'Rp 25.000'
        ],
    ];
@endphp

<div class="bg-white dark:bg-dark-card rounded-3xl p-6 shadow-sm border border-gray-50 dark:border-dark-border transition-colors duration-300">
    <!-- Banner: Padar Island (KEEPER) -->
    <div class="relative h-[250px] rounded-3xl overflow-hidden group shadow-md mb-8">
        <img src="/images/hero1.jpeg" alt="Padar Island" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20"></div>

        <div class="absolute top-6 left-6 text-white max-w-[200px]">
            <p class="text-[10px] font-bold opacity-90 leading-snug">
                <span class="text-white font-black">Padar Island di Labuan Bajo</span> menyuguhkan keindahan panorama
                dramatis.
            </p>
        </div>

        <!-- Float Map Card -->
        <div
            class="absolute bottom-6 left-6 right-6 md:right-auto bg-white/70 dark:bg-black/40 backdrop-blur-xl border border-white/40 dark:border-white/10 rounded-[20px] p-3 md:p-4 flex gap-4 items-center shadow-2xl transition-all duration-500 hover:scale-105 group">
            <div class="w-14 h-11 md:w-20 md:h-14 bg-gray-200 dark:bg-white/10 rounded-xl overflow-hidden border border-white/20 shadow-inner">
                <img src="https://www.google.com/maps/vt/pb=!1m4!1m3!1i13!2i6642!3i4152!2m3!1e0!2sm!3i634211105!3m8!2sid!3sUS!5e1105!12m4!1e68!2m2!1sset!2sRoadmap!4e0!5m1!1e0!23i4111425!24i1000000"
                    class="w-full h-full object-cover grayscale brightness-110 opacity-80 group-hover:opacity-100 transition-opacity">
            </div>
            <div class="flex flex-col">
                <div class="flex items-center gap-2 mb-0.5">
                    <span class="font-black text-gray-800 dark:text-white uppercase tracking-wider text-[10px] md:text-xs">Padar Island</span>
                    <span class="px-1.5 py-0.5 bg-orange-500 text-white text-[6px] font-black rounded-md uppercase">Top</span>
                </div>
                <span class="text-[8px] md:text-[10px] text-gray-500 dark:text-gray-300 font-bold mb-1.5 flex items-center gap-1">
                    <i class="fas fa-location-dot text-orange-500"></i> Labuan Bajo
                </span>
                <div class="flex items-center gap-0.5 text-yellow-400 text-[6px] md:text-[8px]">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Section -->
    <div class="flex items-center justify-between mb-2">
        <h3 class="font-black text-2xl text-gray-800 dark:text-white uppercase tracking-tighter">Destinasi Terbaik!</h3>
        <a href="#" class="text-[10px] font-black text-gray-400 hover:text-orange-500 uppercase tracking-[2px] transition-all">Semua <i class="fas fa-chevron-right ml-1"></i></a>
    </div>
    <p class="text-xs text-gray-400 font-medium mb-8 leading-relaxed">Rayakan hari hari bertamu dengan destinasi terbaik di Voyago</p>

    <!-- Poster Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" x-data="{ expanded: null }">
        @foreach($staticDestinations as $d)
            <div class="bg-[#F9F9F9] dark:bg-[#1A1A1A] rounded-[32px] overflow-hidden border border-gray-100 dark:border-white/5 transition-all duration-300 shadow-sm hover:shadow-md">
                
                <!-- Poster Image Area -->
                <div class="relative h-44 overflow-hidden group">
                    <img src="{{ $d['img'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    
                    <!-- Content Over Image -->
                    <div class="absolute bottom-4 left-5 right-5 flex justify-between items-end">
                        <div>
                            <h4 class="font-black text-white text-lg uppercase leading-none tracking-tight">{{ $d['name'] }}</h4>
                            <p class="text-[10px] text-white/70 italic font-medium mt-1 flex items-center gap-1">
                                <i class="fas fa-location-dot text-orange-400"></i> {{ $d['loc'] }}
                            </p>
                        </div>
                        <div class="bg-white/10 backdrop-blur-md px-2 py-1 rounded-lg flex items-center gap-1 border border-white/20">
                            <i class="fas fa-star text-yellow-400 text-[10px]"></i>
                            <span class="text-[10px] font-black text-white">{{ $d['rating'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="p-4 flex items-center justify-between gap-3">
                    <div class="flex items-center gap-2">
                        <!-- Love Button -->
                        <button class="w-10 h-10 rounded-2xl bg-white dark:bg-white/5 border border-gray-100 dark:border-white/10 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all active:scale-90">
                            <i class="fas fa-heart"></i>
                        </button>
                    </div>

                    <!-- Lihat Button (Toggle Dropdown) -->
                    <button @click="expanded === {{ $d['id'] }} ? expanded = null : expanded = {{ $d['id'] }}" 
                            class="flex-1 bg-orange-500 text-white py-3 rounded-2xl font-black text-[11px] uppercase tracking-widest flex items-center justify-center gap-2 shadow-lg shadow-orange-500/20 active:scale-[0.98] transition-all">
                        <span x-text="expanded === {{ $d['id'] }} ? 'Tutup Detail' : 'Lihat Detail'"></span>
                        <i class="fas fa-chevron-down text-[8px] transition-transform duration-300" :class="expanded === {{ $d['id'] }} ? 'rotate-180' : ''"></i>
                    </button>
                </div>

                <!-- Dropdown Info Content -->
                <div x-show="expanded === {{ $d['id'] }}" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="px-5 pb-5 pt-2">
                    <div class="h-[1px] bg-gray-200 dark:bg-white/5 w-full mb-4"></div>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Estimasi Tiket</p>
                                <p class="text-sm font-black text-gray-800 dark:text-white">{{ $d['price'] }}</p>
                            </div>
                            <a href="{{ route('booking.page') }}" class="bg-orange-100 dark:bg-orange-500/10 text-orange-600 p-2.5 rounded-xl hover:bg-orange-500 hover:text-white transition-all">
                                <i class="fas fa-ticket-alt"></i>
                            </a>
                        </div>
                        
                        <div>
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1">Informasi Singkat</p>
                            <p class="text-[11px] text-gray-500 dark:text-gray-400 font-medium leading-relaxed italic">
                                "{{ $d['desc'] }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
