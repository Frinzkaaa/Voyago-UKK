<<<<<<< HEAD:resources/views/components/Beranda/destinasi-terbaik.blade.php
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
=======
<div class="bg-white dark:bg-dark-card rounded-2xl md:rounded-3xl p-4 md:p-6 shadow-sm border border-gray-50 dark:border-dark-border flex flex-col gap-4 md:gap-6 h-full transition-colors duration-300">
    <!-- Banner: Padar Island (Merged) -->
    <div class="relative h-[250px] rounded-3xl overflow-hidden group shadow-md">
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
            class="absolute bottom-4 left-4 right-4 md:right-auto bg-white dark:bg-dark-card/20 backdrop-blur-md border border-white/30 rounded-2xl p-2 flex gap-3 items-center shadow-xl transition-colors duration-300">
            <div class="w-12 h-10 md:w-16 md:h-12 bg-gray-200 dark:bg-dark-border rounded-lg overflow-hidden border border-white/20">
                <img src="https://www.google.com/maps/vt/pb=!1m4!1m3!1i13!2i6642!3i4152!2m3!1e0!2sm!3i634211105!3m8!2sid!3sUS!5e1105!12m4!1e68!2m2!1sset!2sRoadmap!4e0!5m1!1e0!23i4111425!24i1000000"
                    class="w-full h-full object-cover grayscale brightness-110">
            </div>
            <div class="flex flex-col text-white">
                <span class="font-black text-semibold uppercase tracking-widest leading-none">Padar Island</span>
                <span class="text-[7px] opacity-80 mt-0.5">Labuan Bajo</span>
                <div class="flex items-center gap-0.5 mt-1 text-yellow-400 text-[6px]">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="flex items-center justify-between">
        <h3 class="font-black text-xl text-gray-800 dark:text-white">Destinasi Terbaik!</h3>
        <a href="#"
            class="text-xs font-bold text-gray-400 flex items-center gap-1 hover:text-orange-500 transition-colors uppercase tracking-widest">Semua
            <i class="fas fa-chevron-right text-[10px]"></i></a>
    </div>
    <p class="text-sm text-gray-500 dark:text-[#A1A1AA] -mt-4 font-medium">Rayakan hari hari bertamu dengan destinasi terbaik di Voyago</p>

    <div class="flex flex-col gap-4 mt-2">
        @foreach($destinations as $d)
            @php
                $isWisata = $d instanceof \App\Models\WisataSpot;
                $name = $isWisata ? $d->name : $d['name'];
                $loc = $isWisata ? $d->location : $d['loc'];
                $img = $isWisata ? ($d->main_image ?? '/images/p-1.jpeg') : $d['img'];
                $itemId = $isWisata ? $d->id : 0;
                $type = 'wisata';

                $isWishlisted = false;
                if (auth()->check() && $isWisata) {
                    try {
                        $isWishlisted = \App\Models\Wishlist::where('user_id', auth()->id())
                            ->where('wishlistable_id', $d->id)
                            ->where('wishlistable_type', get_class($d))
                            ->exists();
                    } catch (\Exception $e) {
                        $isWishlisted = false;
                    }
                }
            @endphp
            <div class="flex items-center gap-3 md:gap-4 bg-white dark:bg-dark-card hover:bg-orange-50 dark:hover:bg-[#2A2A2A] p-2 rounded-2xl transition-all group transition-colors duration-300">
                <img src="{{ $img }}" alt="{{ $name }}" class="w-12 h-12 md:w-16 md:h-16 rounded-xl md:rounded-2xl object-cover shadow-sm">
                <div class="flex-1 flex flex-col min-w-0">
                    <span class="font-black text-gray-800 dark:text-white text-sm md:text-base leading-tight truncate">{{ $name }}</span>
                    <span class="text-[10px] md:text-xs font-thin text-gray-400 mt-0.5 truncate">{{ $loc }}</span>
                </div>
                <div class="flex items-center gap-2 md:gap-3 shrink-0">
                    <button onclick="handleWishlist(event, {{ $itemId }}, '{{ $type }}')"
                        class="wishlist-btn-{{ $itemId }} w-8 h-8 md:w-10 md:h-10 rounded-full border {{ $isWishlisted ? 'bg-orange-500 border-orange-500 text-white' : 'border-orange-400 text-orange-500' }} flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                        <i class="fas fa-heart text-xs md:text-sm"></i>
                    </button>
                    <button onclick='showDestinationDetail({{ json_encode($d) }})'
                        class="bg-orange-500 hover:bg-orange-600 text-white font-black px-4 md:px-6 py-1.5 md:py-2 rounded-full text-xs shadow-md shadow-orange-100 transition-all transform active:scale-95">
                        Lihat
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Info Detail Modal -->
    <div id="destModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm" onclick="closeDestModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div
                class="bg-white dark:bg-dark-card w-full max-w-md rounded-[2.5rem] overflow-hidden shadow-2xl animate-in fade-in zoom-in duration-300 border border-gray-100 dark:border-dark-border">
                <div class="relative h-56">
                    <img id="dest-modal-img" src="" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <button onclick="closeDestModal()"
                        class="absolute top-4 right-4 w-10 h-10 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white hover:bg-white hover:text-orange-500 transition-all">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="absolute bottom-6 left-6 text-white">
                        <h3 id="dest-modal-name" class="text-2xl font-black tracking-tight leading-none mb-1"></h3>
                        <p id="dest-modal-loc" class="text-xs opacity-80 flex items-center gap-1">
                            <i class="fas fa-location-dot"></i> <span></span>
                        </p>
                    </div>
                </div>

                <div class="p-8">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex flex-col">
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Harga Tiket</span>
                            <span id="dest-modal-price" class="text-xl font-black text-orange-500"></span>
                        </div>
                        <div class="flex items-center gap-1 bg-yellow-50 dark:bg-yellow-500/10 px-3 py-1.5 rounded-xl border border-yellow-100 dark:border-yellow-500/20">
                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                            <span class="text-xs font-black text-yellow-600 dark:text-yellow-400">4.9</span>
                        </div>
                    </div>

                    <div class="mb-8">
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest block mb-2">Tentang Destinasi</span>
                        <p id="dest-modal-desc" class="text-sm text-gray-500 dark:text-[#A1A1AA] leading-relaxed font-medium"></p>
                    </div>

                    <div class="flex gap-4">
                        <button onclick="closeDestModal()"
                            class="flex-1 py-4 border-2 border-gray-100 dark:border-dark-border rounded-2xl font-black text-xs uppercase tracking-widest text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 transition-all">Tutup</button>
                        <a id="dest-modal-book" href="/"
                            class="flex-1 py-4 bg-[#FF7304] text-white rounded-2xl font-black text-xs uppercase tracking-widest text-center shadow-lg shadow-orange-200 hover:scale-[1.02] transition-all">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showDestinationDetail(dest) {
    const modal = document.getElementById('destModal');
    const name = dest.name || dest['name'];
    const loc = dest.location || dest['loc'];
    const img = dest.main_image || dest['img'] || '/images/p-1.jpeg';
    const desc = dest.description || 'Nikmati keindahan alam Indonesia yang menakjubkan dengan paket perjalanan eksklusif dari Voyago.';
    const price = dest.price ? 'Rp' + new Intl.NumberFormat('id-ID').format(dest.price) : 'Gratis';

    document.getElementById('dest-modal-img').src = img;
    document.getElementById('dest-modal-name').innerText = name;
    document.getElementById('dest-modal-loc').querySelector('span').innerText = loc;
    document.getElementById('dest-modal-desc').innerText = desc;
    document.getElementById('dest-modal-price').innerText = price;
    
    // Smooth scroll to top then show or just show
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeDestModal() {
    document.getElementById('destModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function handleWishlist(event, id, type) {
    event.stopPropagation();
    if (id === 0) return;
    
    fetch('{{ route('wishlist.toggle') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ id: id, type: type })
    })
    .then(response => {
        if (response.status === 401) {
            window.location.href = '{{ route('login') }}';
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.status) {
            const heartBtns = document.querySelectorAll('.wishlist-btn-' + id);
            heartBtns.forEach(hb => {
                if (data.status === 'added') {
                    hb.classList.add('bg-orange-500', 'text-white', 'border-orange-500');
                    hb.classList.remove('text-orange-500', 'border-orange-400');
                } else {
                    hb.classList.remove('bg-orange-500', 'text-white', 'border-orange-500');
                    hb.classList.add('text-orange-500', 'border-orange-400');
                }
            });

            if (window.dispatchEvent) {
                window.dispatchEvent(new CustomEvent('notify', {
                    detail: { type: 'success', message: data.message }
                }));
            }
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
>>>>>>> a01ab7f3843271c82e611eaf9bf04362c5919ec0:resources/views/components/beranda/destinasi-terbaik.blade.php
