<div x-data="{ activeTab: 'Semua' }" class="flex flex-col gap-6">
  <div class="flex flex-col gap-4">
    <h3 class="font-black text-2xl text-gray-800 dark:text-white">Aktivitas Trending</h3>

    <div class="flex items-center justify-between">
      <div class="flex flex-wrap gap-2">
        @php
          $categories = ['Semua', 'Atraksi', 'Tur', 'Taman Bermain', 'Spa & Gaya Hidup'];
        @endphp
        @foreach($categories as $cat)
          <button 
            @click="activeTab = '{{ $cat }}'"
            :class="activeTab === '{{ $cat }}' ? 'bg-orange-500 text-white shadow-md shadow-orange-100' : 'bg-white dark:bg-dark-card text-gray-500 dark:text-[#A1A1AA] hover:text-orange-500 border border-gray-100 dark:border-dark-border'"
            class="px-4 py-1.5 rounded-full text-xs font-black transition-all duration-300">
            {{ $cat }}
          </button>
        @endforeach
      </div>
    </div>
  </div>

  <div class="relative group">
    <div class="flex overflow-x-auto gap-6 hide-scrollbar pb-6 scroll-smooth snap-x">
      @php
        $activities = [
          ['title' => 'Tiket OPI Water Fun', 'type' => 'Atraksi', 'color' => 'bg-pink-400', 'loc' => 'Bali', 'rev' => '1.1k ulasan', 'old' => '40.000', 'new' => '20.000', 'save' => '50%', 'img' => 'https://s-light.tiket.photos/t/01E25EBZS3W0FY9GTG6C42E1SE/rsfit19201280gsm/events/2024/08/08/f3aee3a0-9282-491b-bc58-6ac408dfcc60-1723102340085-7d301ac0a227a49de035bfafa1985867.jpg'],
          ['title' => 'Trans Snow World Makassar', 'type' => 'Taman Bermain', 'color' => 'bg-red-400', 'loc' => 'Makassar', 'rev' => '1.5k ulasan', 'old' => '250.000', 'new' => '116.980', 'save' => '70%', 'img' => 'https://rricoid-assets.obs.ap-southeast-4.myhuaweicloud.com/berita/Makassar/f/1770017257147-Foto_Artikel_(23)/v6q4y15fftjdyah.jpeg'],
          ['title' => 'Tiket Jatim Park 1', 'type' => 'Taman Bermain', 'color' => 'bg-orange-400', 'loc' => 'Jatim', 'rev' => '2.5k ulasan', 'old' => '90.000', 'new' => '57.000', 'save' => '40%', 'img' => 'https://xpscntm-asset-6aaa6adb24ad2493.s3.ap-southeast-1.amazonaws.com/2000625477092/Jatim-Park-1-Tickets-65be264f-c251-4202-abc0-3fe4c8364b13.jpeg'],
          ['title' => 'Batu Secret Zoo & Museum', 'type' => 'Atraksi', 'color' => 'bg-orange-400', 'loc' => 'Jatim', 'rev' => '1.5k ulasan', 'old' => '190.000', 'new' => '148.500', 'save' => '20%', 'img' => 'https://i0.wp.com/labirutour.com/wp-content/uploads/2023/12/Daya-Tarik-Zoo-tiket.com_.png?fit=1436%2C900&ssl=1'],
          ['title' => 'Mount Batur Sunrise Trekking', 'type' => 'Tur', 'color' => 'bg-emerald-400', 'loc' => 'Bali', 'rev' => '8.9k ulasan', 'old' => '450.000', 'new' => '325.000', 'save' => '25%', 'img' => 'https://bagustourservice.com/wp-content/uploads/2014/12/Sunrise-Trekking.jpg.webp'],
          ['title' => 'Ayana Resort Spa Experience', 'type' => 'Spa & Gaya Hidup', 'color' => 'bg-purple-400', 'loc' => 'Bali', 'rev' => '2.1k ulasan', 'old' => '1.200.000', 'new' => '890.000', 'save' => '25%', 'img' => 'https://images.squarespace-cdn.com/content/v1/5a5596188dd0411a8df1b41a/1524181458576-6J3Y8FYYQLYVPPUGNACC/_AYANA_SPA_SPA-VILLA_SINGLE-ROOM.jpg'],
        ];
      @endphp

      @foreach($activities as $a)
        <div
          x-show="activeTab === 'Semua' || activeTab === '{{ $a['type'] }}'"
          x-transition:enter="transition ease-out duration-300"
          x-transition:enter-start="opacity-0 transform scale-95"
          x-transition:enter-end="opacity-100 transform scale-100"
          onclick="window.location.href = '{{ route('booking.page') }}?category=wisata'"
          class="flex-none w-[280px] bg-white dark:bg-dark-card rounded-3xl p-4 shadow-sm border border-gray-50 dark:border-dark-border group cursor-pointer hover:border-orange-200 transition-all flex flex-col h-full snap-start">
          <div class="relative h-40 rounded-2xl overflow-hidden">
            <img src="{{ $a['img'] }}"
              class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
            <div
              class="absolute top-3 left-3 {{ $a['color'] }} text-white text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest flex items-center gap-1">
              <i class="fas fa-map-marker-alt text-[7px]"></i> {{ $a['type'] }}
            </div>
            <div
              class="absolute bottom-3 right-3 bg-orange-500 text-white text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest">
              Hemat {{ $a['save'] }}</div>
          </div>

          <div class="flex flex-col px-1 mt-4 flex-grow">
            <h4
              class="font-black text-gray-800 dark:text-white text-xs leading-tight group-hover:text-orange-500 transition-colors line-clamp-2 uppercase">
              {{ $a['title'] }}
            </h4>
            <div class="flex items-center gap-2 mt-2">
              <span class="text-[9px] font-bold text-teal-400 uppercase">{{ $a['loc'] }}</span>
              <span class="text-[9px] font-bold text-gray-300">•</span>
              <span class="text-[9px] font-bold text-gray-400">{{ $a['rev'] }}</span>
            </div>
            <div class="mt-auto pt-3">
              <div class="text-[9px] font-bold text-gray-300 line-through">Rp {{ $a['old'] }}</div>
              <div class="flex items-baseline gap-1 mt-0.5">
                <span class="text-[10px] font-black text-orange-500">Rp</span>
                <span class="text-lg font-black text-orange-500">{{ $a['new'] }}</span>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>

    <button
      @click="$el.parentElement.querySelector('.flex').scrollBy({left: 300, behavior: 'smooth'})"
      class="absolute -right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white dark:bg-dark-card shadow-lg border border-gray-100 dark:border-dark-border rounded-full flex items-center justify-center text-gray-400 hover:text-orange-500 transition-all duration-300">
      <i class="fas fa-chevron-right text-xs"></i>
    </button>
  </div>
</div>

<style>
  .hide-scrollbar::-webkit-scrollbar { display: none; }
  .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>