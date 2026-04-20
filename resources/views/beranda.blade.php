@extends('layouts.app')

@section('content')
  <div class="flex flex-col gap-6">
    <!-- Top Section: Destinasi Terbaik (Left) + Hero & Others (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- Left: Destinasi Terbaik (Merged with Padar Island) -->
      <div class="lg:col-span-5">
        <x-beranda.destinasi-terbaik :destinations="$bestDestinations" />
      </div>

      <!-- Right: Hero (Top) + Hotel & Chat (Bottom) -->
      <div class="lg:col-span-7 flex flex-col gap-6">
        <x-beranda.hero />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-grow">
          <x-beranda.hotel-hero />
          <x-beranda.chat />
        </div>
      </div>
    </div>

    <!-- Voucher & Cek Pesanan -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <div class="lg:col-span-3">
        <x-beranda.voucher />
      </div>
      <div class="lg:col-span-9 flex flex-col gap-6">
        <x-beranda.cek-pesanan :bookings="$recentBookings" />
        <x-beranda.paket-luar-negeri />
      </div>
    </div>

    <!-- Promo Tiket Pesawat Domestik -->
    <x-beranda.promo-domestik />

    <!-- Aktivitas Trending -->
    <x-beranda.aktivitas-trending />

    <!-- Tamasya Keliling Dunia -->
    <x-beranda.tamasya />

    <!-- Join Mitra Section -->
    <section
      class="mt-10 mb-20 bg-gradient-to-br from-[#FF7304] to-[#FFAC63] rounded-[24px] md:rounded-[32px] p-6 md:p-12 text-white flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden shadow-2xl shadow-orange-100/20 transition-all duration-300">
      <div class="relative z-10 max-w-lg text-center md:text-left">
        <h2 class="text-xl md:text-3xl font-black mb-3 md:mb-4 leading-tight tracking-tight">Punya Bisnis Properti atau Transportasi?</h2>
        <p class="text-[11px] md:text-sm opacity-90 mb-6 md:mb-8 leading-relaxed font-medium">Dapatkan keuntungan lebih dengan bergabung sebagai Mitra
          Voyago. Kelola bisnismu lebih cerdas dan jangkau jutaan penjelajah dunia.</p>
        <div class="flex flex-wrap justify-center md:justify-start gap-3">
          <a href="{{ route('partner.auth.page') }}"
            class="bg-zinc-900 text-white px-6 md:px-8 py-2.5 md:py-3.5 rounded-xl font-black shadow-lg hover:scale-105 transition-all text-center text-[10px] md:text-xs uppercase tracking-widest">Daftar
            Mitra</a>
          <a href="#"
            class="border-2 border-white/20 backdrop-blur-sm text-white px-6 md:px-8 py-2.5 md:py-3.5 rounded-xl font-black hover:bg-white/10 transition-all text-center text-[10px] md:text-xs uppercase tracking-widest">Pelajari
            Selengkapnya</a>
        </div>
      </div>
      <div class="relative z-10 hidden lg:block opacity-20 transform translate-x-4">
        <i class="fa-solid fa-handshake-angle text-[120px]"></i>
      </div>
      <!-- Decorative blobs -->
      <div class="absolute -top-10 -right-10 w-64 h-64 bg-white dark:bg-dark-card/10 rounded-full blur-3xl transition-colors duration-300"></div>
      <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-orange-800/10 rounded-full blur-3xl"></div>
    </section>
  </div>
@endsection