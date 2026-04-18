<!-- Footer Component -->
<footer class="bg-orange-500 text-white py-8 mt-8">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-4 gap-8">
    <div>
      <div class="flex items-center gap-2 mb-2">
        <img src="/images/logo-2.png" alt="Voyago Logo" class="h-10 w-auto">
      </div>
      <p class="text-xs">Platform pemesanan tiket & travel terpercaya untuk pesawat, kereta, hotel, dan destinasi
        wisata. Pesan cepat, aman, dan praktis dalam satu aplikasi.</p>
     <div class="flex gap-2 mt-2">
        <a href="#" class="h-5 w-5 flex items-center justify-center hover:text-orange-500 transition">
            <i class="fa-brands fa-facebook-f text-lg"></i>
        </a>
        <a href="#" class="h-5 w-5 flex items-center justify-center hover:text-orange-500 transition">
            <i class="fa-brands fa-instagram text-lg"></i>
        </a>
        <a href="#" class="h-5 w-5 flex items-center justify-center hover:text-orange-500 transition">
            <i class="fa-brands fa-x-twitter text-lg"></i>
        </a>
    </div>
    </div>
    <div>
      <div class="font-bold mb-2">Quick Links</div>
      <ul class="text-xs space-y-1">
        <li><a href="#" class="hover:underline">Beranda</a></li>
        <li><a href="#" class="hover:underline">Cari Tiket</a></li>
        <li><a href="#" class="hover:underline">Pemesanan</a></li>
        <li><a href="#" class="hover:underline">Voucher</a></li>
        <li><a href="#" class="hover:underline">Destinasi Populer</a></li>
        <li><a href="{{ route('partner.auth.page') }}" class="hover:underline font-bold text-orange-200">Jadi Mitra
            Voyago</a>
        </li>
      </ul>
    </div>
    <div>
      <div class="font-bold mb-2">Bantuan & Layanan</div>
      <ul class="text-xs space-y-1">
        <li><a href="#" class="hover:underline">Pusat Bantuan (FAQ)</a></li>
        <li><a href="#" class="hover:underline">Cara Pemesanan</a></li>
        <li><a href="#" class="hover:underline">Pembayaran</a></li>
        <li><a href="#" class="hover:underline">Refund & Reschedule</a></li>
        <li><a href="#" class="hover:underline">Hubungi CS</a></li>
      </ul>
    </div>
    <div>
      <div class="font-bold mb-2">Stay Connected</div>
      <form class="flex gap-2 mb-2">
        <input type="email" placeholder="Masukan Email"
          class="rounded-full px-3 py-1 text-orange-500 focus:outline-none w-full">
        <button type="submit" class="bg-white dark:bg-dark-card text-orange-500 rounded-full px-3 py-1 transition-colors duration-300"><svg class="w-4 h-4" fill="none"
            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M22 2L11 13" />
            <path d="M22 2L15 22L11 13L2 9L22 2Z" />
          </svg></button>
      </form>
      <div class="text-xs">support@voyago.com<br>+62 812-0000-0000</div>
    </div>
  </div>
  <div class="max-w-7xl mx-auto px-6 mt-12 pt-8 border-t border-white/10 flex flex-col md:flex-row items-center justify-between gap-4">
    <p class="text-[10px] md:text-xs font-bold opacity-60">© 2026 Voyago. All rights reserved.</p>
    <p class="text-[10px] md:text-xs font-black tracking-widest uppercase opacity-80">
      Made with <i class="fa-solid fa-heart text-white animate-pulse mx-1"></i> by <span class="text-white underline decoration-white/30 underline-offset-4">Frinzka</span>
    </p>
  </div>
</footer>