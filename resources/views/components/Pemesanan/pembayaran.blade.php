<div id="pembayaran-section" class="flex flex-col gap-8 mt-4" style="display: none;">
  <!-- Detail Tiket Terpilih (Optional Info) -->
  <div id="selected-ticket-info" class="bg-orange-500 rounded-[2rem] p-8 text-white shadow-lg relative overflow-hidden">
    <div class="relative z-10">
        <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-1">Tiket Terpilih</p>
        <h3 id="display-selected-name" class="text-3xl font-black mb-2">Nama Kereta</h3>
        <div class="flex items-center gap-4 text-sm font-bold opacity-90">
            <span id="display-selected-route">Asal → Tujuan</span>
            <span class="w-1.5 h-1.5 rounded-full bg-white/40"></span>
            <span id="display-selected-class">Executive</span>
        </div>
    </div>
    <i class="fas fa-ticket-alt absolute -right-4 -bottom-4 text-8xl opacity-10 -rotate-12"></i>
  </div>

  <!-- Pilih Kursi (Moved here) -->
  <div class="bg-white border-2 border-gray-100 rounded-[2rem] p-8 shadow-sm">
      <div class="flex items-center justify-between mb-8">
          <div>
              <h3 class="text-gray-800 font-black text-xl tracking-tight">Pilih Kursi</h3>
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
              class="seat-item bg-gray-50 text-gray-400 font-bold h-12 w-full flex items-center justify-center rounded-xl text-xs border-2 border-transparent hover:border-orange-200 transition-all cursor-pointer">
              {{ $seatNo }}
            </div>
          @endfor
      </div>

      <div class="flex gap-6 mt-8 pt-6 border-t border-gray-50">
          <div class="flex items-center gap-2">
              <div class="w-4 h-4 bg-gray-100 rounded-md"></div>
              <span class="text-[10px] font-black text-gray-400 uppercase">Tersedia</span>
          </div>
          <div class="flex items-center gap-2">
              <div class="w-4 h-4 bg-orange-500 rounded-md"></div>
              <span class="text-[10px] font-black text-gray-400 uppercase">Dipilih</span>
          </div>
      </div>
  </div>
  <!-- Rincian Pembayaran -->
  <div class="bg-white border-2 border-gray-100 rounded-[2rem] p-8 shadow-sm">
    <h3 class="text-gray-800 font-black text-lg mb-6">Rincian Pembayaran</h3>
    <div class="flex flex-col gap-4">
      <div class="flex justify-between items-center text-orange-500 font-bold">
        <span id="label-summary-price">Harga tiket ( 1 pax ) :</span>
        <span id="summary-base">Rp 0</span>
      </div>
      <div class="flex justify-between items-center text-orange-500 font-bold">
        <span>Biaya layanan :</span>
        <span>Rp 10.000</span>
      </div>
      <div class="flex justify-between items-center text-orange-500 font-bold border-b border-gray-100 pb-4">
        <span>Diskon voucher :</span>
        <span>Rp 50.000</span>
      </div>
      <div class="flex justify-between items-center text-orange-500 font-black text-xl pt-2">
        <span>Total Payment :</span>
        <span id="summary-total">Rp 0</span>
      </div>
    </div>
  </div>

  <!-- Pilih Metode Pembayaran -->
  <div class="bg-white border-2 border-gray-100 rounded-[2rem] p-8 shadow-sm flex items-center justify-between">
    <div class="flex flex-col gap-4">
      <h3 class="text-gray-800 font-black text-lg">Pilih Metode Pembayaran</h3>
      <div class="flex gap-8">
        <label class="flex items-center gap-3 cursor-pointer group">
          <input type="radio" name="payment" value="qris" checked class="hidden peer">
          <div
            class="w-5 h-5 rounded-full border-2 border-orange-200 flex items-center justify-center peer-checked:border-orange-500 transition-colors">
            <div class="w-2.5 h-2.5 bg-orange-500 rounded-full scale-0 peer-checked:scale-100 transition-transform">
            </div>
          </div>
          <span class="font-black text-gray-800 group-hover:text-orange-500 transition-colors">QRIS</span>
        </label>
        <label class="flex items-center gap-3 cursor-pointer group">
          <input type="radio" name="payment" value="bank" class="hidden peer">
          <div
            class="w-5 h-5 rounded-full border-2 border-orange-200 flex items-center justify-center peer-checked:border-orange-500 transition-colors">
            <div class="w-2.5 h-2.5 bg-orange-500 rounded-full scale-0 peer-checked:scale-100 transition-transform">
            </div>
          </div>
          <span class="font-black text-gray-800 group-hover:text-orange-500 transition-colors">Bank</span>
        </label>
        <label class="flex items-center gap-3 cursor-pointer group">
          <input type="radio" name="payment" value="e-wallet" class="hidden peer">
          <div
            class="w-5 h-5 rounded-full border-2 border-orange-200 flex items-center justify-center peer-checked:border-orange-500 transition-colors">
            <div class="w-2.5 h-2.5 bg-orange-500 rounded-full scale-0 peer-checked:scale-100 transition-transform">
            </div>
          </div>
          <span class="font-black text-gray-800 group-hover:text-orange-500 transition-colors">E-Wallet</span>
        </label>
      </div>
    </div>
    <button onclick="handleCheckout()"
      class="bg-orange-500 hover:bg-orange-600 text-white font-black px-16 py-4 rounded-2xl shadow-lg shadow-orange-200 transition-all transform active:scale-95 text-lg">
      Bayar
    </button>
  </div>
</div>