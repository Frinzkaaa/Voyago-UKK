<div class="flex flex-col gap-6">
  <div class="flex flex-col gap-4">
    <h3 class="font-black text-2xl text-gray-800 dark:text-white">Promo Tiket Pesawat Domestik Murah!</h3>

    <div class="flex items-center justify-between">
      <div class="flex flex-wrap gap-2">
        @php
          $tabs = ['Bali', 'Medan', 'Surabaya', 'Makassar', 'Yogyakarta', 'Palembang', 'Lampung', 'Lombok', 'Balikpapan', 'Jakarta'];
        @endphp
        @foreach($tabs as $t)
          <button
            class="{{ $loop->first ? 'bg-orange-500 text-white shadow-md shadow-orange-100' : 'bg-white dark:bg-dark-card text-gray-500 dark:text-[#A1A1AA] hover:text-orange-500 border border-gray-100 dark:border-dark-border' }} px-4 py-1.5 rounded-full text-xs font-black transition-al transition-colors duration-300l">
            {{ $t }}
          </button>
        @endforeach
      </div>
      <a href="#"
        class="text-xs font-black text-gray-400 hover:text-orange-500 transition-colors uppercase tracking-widest flex items-center gap-1">
        Lihat Semua <i class="fas fa-chevron-right text-[8px]"></i>
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 relative">
    @php
      $promos = [
        ['price' => '721.900', 'date' => '24 Mar 2026'],
        ['price' => '846.300', 'date' => '23 Mar 2026'],
        ['price' => '857.200', 'date' => '26 Mar 2026'],
        ['price' => '856.400', 'date' => '24 Feb 2026'],
      ];
    @endphp

    @foreach($promos as $p)
      <div
        class="bg-white dark:bg-dark-card rounded-3xl p-4 shadow-sm border border-gray-50 dark:border-dark-border group cursor-pointer hover:border-orange-200 transition-all flex flex-col gap-4 transition-colors duration-300">
        <div class="relative h-40 rounded-2xl overflow-hidden">
          <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=400&q=80"
            class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
          <div
            class="absolute top-3 left-3 bg-black/60 text-white text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest">
            Sekali Jalan</div>
        </div>

        <div class="flex flex-col px-1">
          <h4 class="font-black text-gray-800 dark:text-white text-sm leading-tight group-hover:text-orange-500 transition-colors">Jakarta
            - Bali / Denpasar</h4>
          <div class="flex items-center gap-2 mt-2">
            <i class="far fa-calendar-alt text-teal-400 text-[10px]"></i>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $p['date'] }}</span>
          </div>
          <div class="mt-2 flex items-baseline gap-1">
            <span class="text-[10px] font-black text-orange-500">Rp</span>
            <span class="text-xl font-black text-orange-500">{{ $p['price'] }}</span>
          </div>
        </div>
      </div>
    @endforeach

    <!-- Next Button Placeholder -->
    <button
      class="absolute -right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white dark:bg-dark-card shadow-lg border border-gray-100 dark:border-dark-border rounded-full flex items-center justify-center text-gray-400 hover:text-orange-500 transition-al transition-colors duration-300l">
      <i class="fas fa-chevron-right text-xs"></i>
    </button>
  </div>
</div>