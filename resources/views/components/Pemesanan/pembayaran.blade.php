<div id="pembayaran-section" class="flex flex-col gap-8 mt-4" style="display: none;">
  <!-- Detail Tiket Terpilih (Optional Info) -->
  <div id="selected-ticket-info" class="bg-zinc-900 rounded-[2rem] p-8 text-white shadow-lg relative overflow-hidden">
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <p class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">Tiket Terpilih</p>
            <h3 id="display-selected-name" class="text-3xl font-black mb-2 tracking-tighter">Nama Kereta</h3>
            <div class="flex items-center gap-4 text-xs font-bold opacity-80">
                <span id="display-selected-route" class="flex items-center gap-2"><i class="fas fa-location-dot text-orange-500"></i> Asal → Tujuan</span>
                <span class="w-1.5 h-1.5 rounded-full bg-white/20"></span>
                <span id="display-selected-class" class="flex items-center gap-2"><i class="fas fa-shield-halved text-orange-500"></i> Executive</span>
            </div>
        </div>
        <div class="flex flex-col items-end shrink-0">
             <div class="text-[10px] font-black uppercase tracking-widest opacity-60 mb-1">Status</div>
             <div class="px-4 py-1.5 bg-orange-500 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg shadow-orange-500/20">Ready to Book</div>
        </div>
    </div>
    <i class="fas fa-ticket-alt absolute -right-4 -bottom-4 text-8xl opacity-10 -rotate-12"></i>
  </div>

  <!-- Promo Alert Banner -->
  <div id="promo-alert-banner" class="bg-orange-50 dark:bg-orange-500/10 border-2 border-orange-100 dark:border-orange-500/20 rounded-[2rem] p-6 hidden">
    <div class="flex items-center gap-6">
        <div class="w-14 h-14 bg-orange-500 rounded-2xl flex items-center justify-center text-white shadow-lg shrink-0">
            <i class="fas fa-gift text-2xl"></i>
        </div>
        <div class="flex-grow">
            <h4 class="font-black text-gray-800 dark:text-white uppercase tracking-tighter text-lg">Promo Berhasil Digunakan!</h4>
            <p id="promo-description" class="text-xs font-bold text-gray-400 mt-1 uppercase tracking-widest">Diskon 20% Liburan Hemat ke Bali</p>
        </div>
        <div class="shrink-0">
            <div id="promo-code-badge" class="px-4 py-2 bg-white dark:bg-dark-card border border-orange-200 text-orange-500 font-black text-xs rounded-xl shadow-sm">BALIHEMAT20</div>
        </div>
    </div>
  </div>

  <!-- Pilih Kursi (Moved here) -->
  <div id="seat-selection-container" class="bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-[2rem] p-8 shadow-sm transition-colors duration-300">
      <div class="flex items-center justify-between mb-8">
          <div>
              <h3 class="text-gray-800 dark:text-white font-black text-xl tracking-tight">Pilih Kursi</h3>
              <p class="text-xs font-bold text-gray-400">Silakan pilih posisi duduk yang Anda inginkan</p>
          </div>
          <div class="bg-orange-50 px-4 py-2 rounded-xl">
              <span id="seat-count-display" class="text-orange-500 font-black text-sm">0/1 Kursi Terpilih</span>
          </div>
      </div>
      
      <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3">
          @for($i = 1; $i <= 24; $i++)
            @php $seatNo = ($i < 10 ? 'A0' : 'A') . $i; @endphp
            <div onclick="toggleSeat(this, '{{ $seatNo }}')"
              class="seat-item bg-gray-50 dark:bg-[#121212] text-gray-400 font-bold h-12 w-full flex items-center justify-center rounded-xl text-xs border-2 border-transparent hover:border-orange-200 transition-all cursor-pointer">
              {{ $seatNo }}
            </div>
          @endfor
      </div>

      <div class="flex gap-6 mt-8 pt-6 border-t border-gray-50 dark:border-dark-border">
          <div class="flex items-center gap-2">
              <div class="w-4 h-4 bg-gray-100 dark:bg-dark-border rounded-md"></div>
              <span class="text-[10px] font-black text-gray-400 uppercase">Tersedia</span>
          </div>
          <div class="flex items-center gap-2">
              <div class="w-4 h-4 bg-orange-500 rounded-md"></div>
              <span class="text-[10px] font-black text-gray-400 uppercase">Dipilih</span>
          </div>
      </div>
  </div>
  <!-- Pilih Metode Pembayaran -->
  <div class="bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-[2rem] p-8 shadow-sm transition-colors duration-300">
      <h3 class="text-gray-800 dark:text-white font-black text-xl mb-6 tracking-tighter uppercase">Metode Pembayaran</h3>
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <!-- QRIS -->
          <label class="relative cursor-pointer group">
              <input type="radio" name="payment" value="qris" class="peer hidden" checked>
              <div class="p-6 rounded-3xl border-2 border-gray-50 dark:border-zinc-800 bg-gray-50/50 dark:bg-zinc-900/50 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-500/10 transition-all duration-300 flex flex-col items-center gap-3">
                  <div class="w-12 h-12 rounded-2xl bg-white dark:bg-zinc-800 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                      <i class="fas fa-qrcode text-orange-500 text-xl"></i>
                  </div>
                  <div class="text-center">
                      <p class="font-black text-gray-800 dark:text-white text-sm uppercase">QRIS</p>
                      <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Instant Pay</p>
                  </div>
              </div>
          </label>

          <!-- Virtual Account -->
          <label class="relative cursor-pointer group">
              <input type="radio" name="payment" value="bank" class="peer hidden">
              <div class="p-6 rounded-3xl border-2 border-gray-50 dark:border-zinc-800 bg-gray-50/50 dark:bg-zinc-900/50 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-500/10 transition-all duration-300 flex flex-col items-center gap-3">
                  <div class="w-12 h-12 rounded-2xl bg-white dark:bg-zinc-800 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                      <i class="fas fa-university text-orange-500 text-xl"></i>
                  </div>
                  <div class="text-center">
                      <p class="font-black text-gray-800 dark:text-white text-sm uppercase">Transfer Bank</p>
                      <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Virtual Account</p>
                  </div>
              </div>
          </label>

          <!-- E-Wallet -->
          <label class="relative cursor-pointer group">
              <input type="radio" name="payment" value="ewallet" class="peer hidden">
              <div class="p-6 rounded-3xl border-2 border-gray-50 dark:border-zinc-800 bg-gray-50/50 dark:bg-zinc-900/50 peer-checked:border-orange-500 peer-checked:bg-orange-50 dark:peer-checked:bg-orange-500/10 transition-all duration-300 flex flex-col items-center gap-3">
                  <div class="w-12 h-12 rounded-2xl bg-white dark:bg-zinc-800 flex items-center justify-center shadow-sm group-hover:scale-110 transition-transform">
                      <i class="fas fa-wallet text-orange-500 text-xl"></i>
                  </div>
                  <div class="text-center">
                      <p class="font-black text-gray-800 dark:text-white text-sm uppercase">E-Wallet</p>
                      <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">GoPay / OVO</p>
                  </div>
              </div>
          </label>
      </div>
  </div>

  <!-- Rincian Pembayaran -->
  <div class="bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-[2rem] p-8 shadow-sm transition-colors duration-300">
    <h3 class="text-gray-800 dark:text-white font-black text-xl mb-8 tracking-tighter">Rincian Pembayaran</h3>
    <div class="flex flex-col gap-5">
      <div class="flex justify-between items-center">
        <span id="label-summary-price" class="text-sm font-bold text-gray-500 uppercase tracking-widest">Harga tiket ( 1 pax )</span>
        <span id="summary-base" class="text-sm font-black text-gray-700 dark:text-white">Rp 0</span>
      </div>
      <div class="flex justify-between items-center">
        <span class="text-sm font-bold text-gray-500 uppercase tracking-widest">Biaya layanan</span>
        <span class="text-sm font-black text-teal-500">Rp 10.000</span>
      </div>
      <div id="summary-discount-row" class="hidden justify-between items-center pt-2">
        <span class="text-sm font-bold text-orange-500 uppercase tracking-widest">Potongan Promo</span>
        <span id="summary-discount-value" class="text-sm font-black text-orange-500">- Rp 0</span>
      </div>
      <div class="flex justify-between items-center text-orange-500 font-black text-xl pt-2">
        <span>Total Payment :</span>
        <span id="summary-total">Rp 0</span>
      </div>
    </div>
  </div>

  <!-- Tombol Bayar -->
  <div class="bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-[2rem] p-8 shadow-sm flex items-center justify-center transition-colors duration-300">
    <button onclick="handleCheckout()"
      class="bg-orange-500 hover:bg-orange-600 text-white font-black px-24 py-5 rounded-[2rem] shadow-xl shadow-orange-500/20 transition-all transform active:scale-95 text-xl w-full md:w-auto">
      Konfirmasi & Bayar Sekarang
    </button>
  </div>
</div>