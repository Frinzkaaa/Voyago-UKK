@extends('layouts.app')

@section('content')
  <div class="flex flex-col gap-6">
    <!-- Top Section: Destinasi Terbaik (Left) + Hero & Others (Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <!-- Left: Destinasi Terbaik (Merged with Padar Island) -->
      <div class="lg:col-span-5">
        <x-Beranda.destinasi-terbaik :destinations="$bestDestinations" />
      </div>

      <!-- Right: Hero (Top) + Hotel & Chat (Bottom) -->
      <div class="lg:col-span-7 flex flex-col gap-6">
        <x-Beranda.hero />
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 flex-grow">
          <x-Beranda.hotel-hero />
          <x-Beranda.chat />
        </div>
      </div>
    </div>

    <!-- Voucher & Cek Pesanan -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
      <div class="lg:col-span-3">
        <x-Beranda.voucher />
      </div>
      <div class="lg:col-span-9 flex flex-col gap-6">
        <x-Beranda.cek-pesanan :bookings="$recentBookings" />
        <x-Beranda.paket-luar-negeri />
      </div>
    </div>

    <!-- Promo Tiket Pesawat Domestik -->
    <x-Beranda.promo-domestik />

    <!-- Aktivitas Trending -->
    <x-Beranda.aktivitas-trending />

    <!-- Tamasya Keliling Dunia -->
    <x-Beranda.tamasya />

    <!-- Join Mitra Section -->
    <section
      class="mt-10 mb-20 bg-gradient-to-br from-[#FF7304] to-[#FFAC63] rounded-[32px] md:rounded-[40px] p-8 md:p-16 text-white flex flex-col md:flex-row items-center justify-between gap-10 relative overflow-hidden shadow-2xl shadow-orange-100">
      <div class="relative z-10 max-w-xl text-center md:text-left">
        <h2 class="text-2xl md:text-5xl font-black mb-4 md:mb-6 leading-tight">Punya Bisnis Properti atau Transportasi?</h2>
        <p class="text-sm md:text-lg opacity-90 mb-8 md:mb-10 leading-relaxed">Dapatkan keuntungan lebih dengan bergabung sebagai Mitra
          Voyago. Kelola bisnismu lebih cerdas dan jangkau jutaan penjelajah.</p>
        <div class="flex flex-wrap justify-center md:justify-start gap-4">
          <a href="{{ route('partner.auth.page') }}"
            class="bg-white dark:bg-dark-card text-[#FF7304] px-6 md:px-10 py-3 md:py-4 rounded-xl md:rounded-2xl font-black shadow-lg hover:scale-105 transition-all text-center transition-colors duration-300 text-sm md:text-base">Daftar
            Mitra</a>
          <a href="#"
            class="border-2 border-white/30 backdrop-blur-sm text-white px-6 md:px-10 py-3 md:py-4 rounded-xl md:rounded-2xl font-black hover:bg-white dark:bg-dark-card/10 transition-all text-center transition-colors duration-300 text-sm md:text-base">Pelajari
            Selengkapnya</a>
        </div>
      </div>
      <div class="relative z-10 hidden lg:block opacity-20">
        <i class="fa-solid fa-handshake-angle text-[200px]"></i>
      </div>
      <!-- Decorative blobs -->
      <div class="absolute -top-10 -right-10 w-64 h-64 bg-white dark:bg-dark-card/10 rounded-full blur-3xl transition-colors duration-300"></div>
      <div class="absolute -bottom-20 -left-20 w-80 h-80 bg-orange-800/10 rounded-full blur-3xl"></div>
    </section>
  </div>
@endsection