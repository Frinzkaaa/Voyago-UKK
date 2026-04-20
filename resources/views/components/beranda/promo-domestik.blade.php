<div x-data="{ activeCity: 'Semua' }" class="flex flex-col gap-6">
  <div class="flex flex-col gap-4">
    <h3 class="font-black text-2xl text-gray-800 dark:text-white">Promo Tiket Domestik</h3>

    <div class="flex items-center justify-between">
      <div class="flex flex-wrap gap-2">
        @php
          $cities = ['Semua', 'Bali', 'Yogyakarta', 'Surabaya', 'Bandung', 'Lombok'];
        @endphp
        @foreach($cities as $city)
          <button 
            @click="activeCity = '{{ $city }}'"
            :class="activeCity === '{{ $city }}' ? 'bg-orange-500 text-white shadow-md shadow-orange-100' : 'bg-white dark:bg-dark-card text-gray-500 dark:text-[#A1A1AA] hover:text-orange-500 border border-gray-100 dark:border-dark-border'"
            class="px-4 py-1.5 rounded-full text-xs font-black transition-all duration-300">
            {{ $city }}
          </button>
        @endforeach
      </div>
    </div>
  </div>

  <div class="relative group">
    <div class="flex overflow-x-auto gap-6 hide-scrollbar pb-6 scroll-smooth snap-x">
      @php
        $promos = [
          [
            'title' => 'Liburan Hemat ke Bali',
            'dest' => 'Bali',
            'cat' => 'wisata',
            'discount' => '20%',
            'period' => '1–30 April 2026',
            'code' => 'BALIHEMAT20',
            'terms' => 'Min. transaksi Rp500.000',
            'img' => 'https://plus.unsplash.com/premium_photo-1678304639537-d347f2aebc92?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
          ],
          [
            'title' => 'Weekend ke Yogyakarta',
            'dest' => 'Yogyakarta',
            'cat' => 'wisata',
            'discount' => '15%',
            'period' => '5–20 April 2026',
            'code' => 'JOGJA15',
            'terms' => 'Berlaku Sabtu & Minggu',
            'img' => 'https://images.unsplash.com/photo-1631795617958-3ddcf718d6aa?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
          ],
          [
            'title' => 'Promo Mudik Surabaya',
            'dest' => 'Surabaya',
            'cat' => 'bus',
            'discount' => '25%',
            'period' => '10–25 April 2026',
            'code' => 'MUDIKSBY25',
            'terms' => 'Khusus tiket kereta & bus',
            'img' => 'https://images.unsplash.com/photo-1566176553949-872b2a73e04e?q=80&w=685&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
          ],
          [
            'title' => 'Jelajah Bandung Murah',
            'dest' => 'Bandung',
            'cat' => 'wisata',
            'discount' => '10%',
            'period' => '1–15 Mei 2026',
            'code' => 'BDGTRIP10',
            'terms' => 'Min. 2 penumpang',
            'img' => 'https://images.unsplash.com/photo-1611638281871-1063d3e76e1f?q=80&w=1133&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
          ],
          [
            'title' => 'Eksplor Lombok Spesial',
            'dest' => 'Lombok',
            'cat' => 'wisata',
            'discount' => '30%',
            'period' => '1–31 Mei 2026',
            'code' => 'LOMBOK30',
            'terms' => 'Maks. diskon Rp300.000',
            'img' => 'https://images.unsplash.com/photo-1611638281871-1063d3e76e1f?q=80&w=1133&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
          ],
        ];
      @endphp

      @foreach($promos as $p)
        <div
          x-show="activeCity === 'Semua' || activeCity === '{{ $p['dest'] }}'"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-95"
          x-transition:enter-end="opacity-100 transform scale-100"
          class="flex-none w-[280px] md:w-[320px] bg-white dark:bg-dark-card rounded-3xl p-4 md:p-5 shadow-sm border border-gray-50 dark:border-dark-border group cursor-pointer hover:border-orange-200 transition-all flex flex-col gap-4 snap-start">
          
          <div class="relative h-40 md:h-44 rounded-2xl md:rounded-3xl overflow-hidden shadow-lg shadow-orange-100/20">
            <img src="{{ $p['img'] }}"
              class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div
              class="absolute top-4 left-4 bg-orange-500 text-white text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest shadow-lg">
              Diskon {{ $p['discount'] }}
            </div>
          </div>

          <div class="flex flex-col gap-2">
            <h4 class="font-black text-gray-800 dark:text-white text-base leading-tight group-hover:text-orange-500 transition-colors">
              {{ $p['title'] }}
            </h4>
            
            <div class="flex flex-col gap-1.5 mt-1">
              <div class="flex items-center gap-2">
                <i class="far fa-calendar-alt text-teal-500 text-xs"></i>
                <span class="text-[11px] font-bold text-gray-500 dark:text-gray-400 capitalize">{{ $p['period'] }}</span>
              </div>
              <div class="flex items-center gap-2">
                <i class="fas fa-tag text-orange-500 text-xs"></i>
                <span class="text-[11px] font-black text-orange-500 bg-orange-50 px-2 py-0.5 rounded border border-orange-100">{{ $p['code'] }}</span>
              </div>
              <div class="flex items-center gap-2">
                <i class="fas fa-info-circle text-gray-300 text-xs"></i>
                <span class="text-[10px] font-bold text-gray-400 italic">{{ $p['terms'] }}</span>
              </div>
            </div>
          </div>

          <button 
            onclick="window.location.href = '{{ route('booking.page') }}?category={{ $p['cat'] }}&promo={{ $p['code'] }}&discount={{ $p['discount'] }}&title={{ urlencode($p['title']) }}'"
            class="mt-2 w-full bg-zinc-900 dark:bg-zinc-800 text-white py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-orange-500 transition-colors shadow-lg shadow-zinc-200/50 dark:shadow-none">
            Gunakan Promo
          </button>
        </div>
      @endforeach
    </div>

    <button
      @click="$el.parentElement.querySelector('.flex').scrollBy({left: 280, behavior: 'smooth'})"
      class="absolute -right-2 md:-right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white dark:bg-dark-card shadow-lg border border-gray-100 dark:border-dark-border rounded-full hidden md:flex items-center justify-center text-gray-400 hover:text-orange-500 transition-all duration-300">
      <i class="fas fa-chevron-right text-xs"></i>
    </button>
  </div>
</div>

<style>
  .hide-scrollbar::-webkit-scrollbar { display: none; }
  .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>