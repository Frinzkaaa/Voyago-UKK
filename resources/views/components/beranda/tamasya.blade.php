<div class="flex flex-col gap-6 mb-24" x-data="{ activeGuide: null }">
  <div class="flex flex-col gap-1 px-1">
    <h3 class="font-black text-2xl text-gray-800 dark:text-white flex items-center gap-2">
      <i class="fas fa-globe-americas text-teal-400 text-xl"></i>
      Tamasya keliling dunia, cek panduannya!
    </h3>
    <p class="text-xs text-gray-400 font-medium max-w-2xl leading-relaxed">
        Klik pada kota destinasi untuk melihat panduan perjalanan singkat, tips hemat, dan rencana perjalanan terbaik dari kami.
    </p>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 md:gap-6 items-start">
    @php
      $guides = [
        [
            'city' => 'Bali', 
            'country' => 'Indonesia', 
            'img' => 'https://plus.unsplash.com/premium_photo-1661878915254-f3163e91d870?q=80&w=1171&auto=format&fit=crop',
            'tips' => 'Sewa motor untuk fleksibilitas. Kunjungi Pura Uluwatu saat sore untuk sunset terbaik.',
            'budget' => 'Rp 500rb - 1jt / Hari',
            'transport' => 'Motor / Mobil Sewa'
        ],
        [
            'city' => 'Bangkok', 
            'country' => 'Thailand', 
            'img' => 'https://images.unsplash.com/photo-1562602833-0f4ab2fc46e3?q=80&w=736&auto=format&fit=crop',
            'tips' => 'Gunakan MRT/BTS untuk hindari macet. Jangan lupa coba Pad Thai di Pinggir Jalan.',
            'budget' => '฿ 1.500 - 2.500 / Hari',
            'transport' => 'Tuk-tuk / BTS Skytrain'
        ],
        [
            'city' => 'Seoul', 
            'country' => 'Korea Selatan', 
            'img' => 'https://images.unsplash.com/photo-1570191913384-7b4ff11716e7?q=80&w=687&auto=format&fit=crop',
            'tips' => 'Beli T-Money untuk transportasi mudah. Pakai Hanbok di Gyeongbokgung masuk gratis!',
            'budget' => '₩ 70.000 - 120.000 / Hari',
            'transport' => 'Subway / Bus Umum'
        ],
        [
            'city' => 'Istanbul', 
            'country' => 'Turki', 
            'img' => 'https://images.unsplash.com/photo-1527838832700-5059252407fa?q=80&w=698&auto=format&fit=crop',
            'tips' => 'Beli Istanbulkart untuk semua transportasi. Nikmati Kopi Turki di kedai pinggir Bosphorus.',
            'budget' => '₺ 800 - 1.500 / Hari',
            'transport' => 'Tram / Kapal Ferry'
        ],
        [
            'city' => 'Liverpool', 
            'country' => 'United Kingdom', 
            'img' => 'https://plus.unsplash.com/premium_photo-1694475284460-51ace2ec7cfd?q=80&w=774&auto=format&fit=crop',
            'tips' => 'Ziarah ke situs The Beatles. Coba kuliner khas Scouse yang menghangatkan.',
            'budget' => '£ 60 - £ 100 / Hari',
            'transport' => 'Kereta Api / Berjalan Kaki'
        ],
      ];
    @endphp

    @foreach($guides as $index => $g)
      <div class="flex flex-col gap-3 transition-all duration-500">
          <div
            @click="activeGuide === {{ $index }} ? activeGuide = null : activeGuide = {{ $index }}"
            class="group relative h-72 md:h-80 lg:h-80 rounded-[32px] overflow-hidden cursor-pointer shadow-lg transition-all duration-300 border-4"
            :class="activeGuide === {{ $index }} ? 'border-orange-500 scale-[0.98]' : 'border-transparent hover:scale-[1.02]'">
            
            <img src="{{ $g['img'] }}"
              class="absolute inset-0 w-full h-full object-cover transition-transform duration-700"
              :class="activeGuide === {{ $index }} ? 'scale-110' : 'group-hover:scale-110'">
            
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent"></div>
            
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-full text-center px-4">
              <h4 class="text-white font-black text-lg md:text-xl tracking-tighter uppercase leading-none mb-1">
                {{ $g['city'] }}
              </h4>
              <p class="text-[9px] text-white/60 font-black uppercase tracking-[2px]">{{ $g['country'] }}</p>
            </div>

            <!-- Indicator icon -->
            <div class="absolute top-4 right-4 w-8 h-8 bg-white/20 backdrop-blur-md rounded-full flex items-center justify-center text-white transition-all transform"
                 :class="activeGuide === {{ $index }} ? 'rotate-45 bg-orange-500' : ''">
                <i class="fas fa-plus text-[10px]"></i>
            </div>
          </div>

          <!-- Mini Guide Expansion -->
          <div x-show="activeGuide === {{ $index }}"
               x-transition:enter="transition ease-out duration-300 transform"
               x-transition:enter-start="opacity-0 -translate-y-4"
               x-transition:enter-end="opacity-100 translate-y-0"
               class="bg-white dark:bg-dark-card/50 rounded-3xl p-5 border border-gray-100 dark:border-white/5 shadow-xl">
               
               <div class="space-y-4 text-left">
                    <div>
                        <p class="text-[8px] font-black text-orange-500 uppercase tracking-widest mb-1">💡 Tips Cerdas</p>
                        <p class="text-[10px] text-gray-500 dark:text-gray-400 font-medium leading-relaxed italic">"{{ $g['tips'] }}"</p>
                    </div>
                    <div class="flex flex-col gap-2">
                        <div class="bg-gray-50 dark:bg-white/5 p-3 rounded-xl">
                            <p class="text-[7px] font-black text-gray-400 uppercase mb-0.5 tracking-[1px]">💰 Perkiraan Budget</p>
                            <p class="text-[10px] font-bold text-gray-800 dark:text-white leading-tight uppercase">{{ $g['budget'] }}</p>
                        </div>
                        <div class="bg-gray-50 dark:bg-white/5 p-3 rounded-xl">
                            <p class="text-[7px] font-black text-gray-400 uppercase mb-0.5 tracking-[1px]">🚲 Transportasi Utama</p>
                            <p class="text-[10px] font-bold text-gray-800 dark:text-white leading-tight uppercase">{{ $g['transport'] }}</p>
                        </div>
                    </div>
               </div>
          </div>
      </div>
    @endforeach
  </div>
</div>