<div class="flex flex-col gap-6">
  <div class="flex flex-col gap-1">
    <h3 class="font-black text-2xl text-gray-800">Voucher</h3>
    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-[-0.5rem]">Klaim promo dan dapatkan
      potongan harga</p>
  </div>

  <div class="flex flex-col gap-4">
    @php
      $vouchers = [
        ['title' => 'Diskon 10%', 'code' => 'FLYMORE2026', 'price' => 'Potongan hingga Rp50.000', 'bg' => 'bg-orange-400', 'color' => 'orange'],
        ['title' => 'Rp50.000', 'code' => 'TRAINHEAT', 'price' => 'Min transaksi Rp2.000.000', 'bg' => 'bg-emerald-600', 'color' => 'emerald'],
        ['title' => 'Diskon 15%', 'code' => 'STAYCATION', 'price' => 'Min menginap 1 malam', 'bg' => 'bg-blue-900', 'color' => 'blue'],
        ['title' => 'Rp300.000', 'code' => 'TRIPHEMAT', 'price' => 'Min transaksi Rp3.000.000', 'bg' => 'bg-green-700', 'color' => 'green'],
      ];
    @endphp

    @foreach($vouchers as $v)
      <div
        class="relative {{ $v['bg'] }} rounded-3xl p-6 text-white overflow-hidden group cursor-pointer hover:scale-[1.02] transition-transform shadow-lg">
        <div class="flex flex-col gap-1 relative z-10">
          <span class="text-[8px] font-black uppercase tracking-[0.2em] opacity-80">Diskon</span>
          <h4 class="text-2xl font-black leading-tight">{{ $v['title'] }}</h4>
          <div class="mt-4 flex flex-col gap-1">
            <span class="text-[9px] font-bold opacity-70">{{ $v['price'] }}</span>
            <div class="flex items-center gap-2 mt-1">
              <i class="fas fa-ticket-alt text-[10px]"></i>
              <span class="text-[10px] font-black uppercase tracking-widest">{{ $v['code'] }}</span>
            </div>
          </div>
        </div>
        <!-- Info Icon -->
        <div class="absolute top-4 right-4 opacity-40 group-hover:opacity-100 transition-opacity">
          <i class="fas fa-info-circle text-xs"></i>
        </div>
        <!-- Background Decoration -->
        <div
          class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full group-hover:scale-150 transition-transform duration-700">
        </div>
      </div>
    @endforeach
  </div>
</div>