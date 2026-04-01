<div class="bg-white dark:bg-dark-card rounded-3xl p-6 shadow-sm border border-gray-50 dark:border-dark-border flex flex-col gap-6 h-full transition-colors duration-300">
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
            class="absolute bottom-4 left-4 bg-white dark:bg-dark-card/20 backdrop-blur-md border border-white/30 rounded-2xl p-2 flex gap-3 items-center shadow-xl transition-colors duration-300">
            <div class="w-16 h-12 bg-gray-200 dark:bg-dark-border rounded-lg overflow-hidden border border-white/20">
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
        @php
            $destinations = [
                ['name' => 'Candi Borobudur', 'loc' => 'Magelang, Jawa Timur', 'img' => '/images/p-1.jpeg'],
                ['name' => 'Gunung Bromo', 'loc' => 'Jawa Timur, Indonesia', 'img' => '/images/p-2.jpeg'],
                ['name' => 'Pink Beach', 'loc' => 'Labuan Bajo (NTT)', 'img' => '/images/p-3.jpeg'],
            ];
        @endphp

        @foreach($destinations as $d)
            <div class="flex items-center gap-4 bg-white dark:bg-dark-card hover:bg-orange-50 dark:hover:bg-[#2A2A2A] p-2 rounded-2xl transition-all group transition-colors duration-300">
                <img src="{{ $d['img'] }}" alt="{{ $d['name'] }}" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
                <div class="flex-1 flex flex-col">
                    <span class="font-black text-gray-800 dark:text-white text-base leading-tight">{{ $d['name'] }}</span>
                    <span class="text-xs font-thin text-gray-400 mt-0.5">{{ $d['loc'] }}</span>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="w-10 h-10 rounded-full border-2 border-orange-400 flex items-center justify-center text-orange-500 hover:bg-orange-50 dark:hover:bg-[#2A2A2A]0 hover:text-white transition-all">
                        <i class="fas fa-heart text-sm"></i>
                    </button>
                    <button
                        class="bg-orange-500 hover:bg-orange-600 text-white font-black px-6 py-2 rounded-full text-xs shadow-md shadow-orange-100 transition-all transform active:scale-95">
                        Lihat
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>