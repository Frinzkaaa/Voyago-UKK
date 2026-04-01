@props(['bookings' => []])

<div class="flex flex-col gap-6">
  <div class="flex flex-col gap-1">
    <h3 class="font-black text-2xl text-orange-500">Cek pesanan kamu disini</h3>
    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-[-0.5rem]">Pantau status tiketmu dan
      lihat detail pesanan</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @guest
      <div
        class="col-span-1 md:col-span-3 bg-white dark:bg-dark-card/50 border border-dashed border-gray-200 dark:border-dark-border rounded-[32px] p-12 text-center transition-colors duration-300">
        <div class="w-16 h-16 bg-gray-100 dark:bg-dark-border rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-400">
          <i class="fa-solid fa-user-lock text-2xl"></i>
        </div>
        <h4 class="font-black text-gray-800 dark:text-white mb-1">Sudah punya tiket?</h4>
        <p class="text-xs text-gray-400 mb-6">Silakan login untuk memantau status pesanan Anda secara real-time.</p>
        <a href="{{ route('login') }}"
          class="inline-block bg-[#FF7304] text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg shadow-orange-100">Masuk
          Sekarang</a>
      </div>
    @else
      @forelse($bookings as $booking)
        @php
          $item = $booking->item;
          if (!$item)
            continue;

          $statusClasses = match ($booking->status->value ?? $booking->status) {
            'confirmed', 'verified', 'success' => 'bg-green-200 text-green-800',
            'pending' => 'bg-yellow-200 text-yellow-800',
            'rejected', 'cancelled', 'failed' => 'bg-red-200 text-red-800',
            default => 'bg-gray-200 dark:bg-dark-border text-gray-800 dark:text-white'
          };

          $statusLabel = match ($booking->status->value ?? $booking->status) {
            'confirmed', 'verified', 'success' => 'Berhasil',
            'pending' => 'Proses',
            'rejected', 'cancelled', 'failed' => 'Gagal',
            default => 'Pending'
          };

          $config = match ($booking->category) {
            'pesawat' => [
              'icon' => 'fa-plane',
              'color' => 'yellow',
              'title' => $item->airline_name ?? 'Pesawat',
              'route' => ($item->origin ?? 'CGK') . ' → ' . ($item->destination ?? 'DPS'),
              'code_o' => $item->origin ?? 'CGK',
              'code_d' => $item->destination ?? 'DPS',
              'label1' => 'Tanggal',
              'val1' => \Carbon\Carbon::parse($item->departure_time)->format('d M Y'),
              'label2' => 'Waktu',
              'val2' => \Carbon\Carbon::parse($item->departure_time)->format('H:i'),
              'label3' => 'Seat',
              'val3' => 'TBA',
              'label4' => 'Kelas',
              'val4' => $item->class ?? 'ECONOMY'
            ],
            'kereta' => [
              'icon' => 'fa-train',
              'color' => 'green',
              'title' => $item->name ?? 'Kereta',
              'route' => ($item->origin ?? 'JKT') . ' → ' . ($item->destination ?? 'YOG'),
              'code_o' => strtoupper(substr($item->origin ?? 'JKT', 0, 3)),
              'code_d' => strtoupper(substr($item->destination ?? 'YOG', 0, 3)),
              'label1' => 'Tanggal',
              'val1' => \Carbon\Carbon::parse($item->departure_time)->format('d M Y'),
              'label2' => 'Waktu',
              'val2' => \Carbon\Carbon::parse($item->departure_time)->format('H:i'),
              'label3' => 'Seat',
              'val3' => 'TBA',
              'label4' => 'Kelas',
              'val4' => $item->class ?? 'EKSEKUTIF'
            ],
            'hotel' => [
              'icon' => 'fa-hotel',
              'color' => 'red',
              'title' => $item->name ?? 'Hotel',
              'route' => $item->location ?? 'Indonesia',
              'code_o' => 'HTL',
              'code_d' => 'STAY',
              'label1' => 'Check In',
              'val1' => 'TBA',
              'label2' => 'Check Out',
              'val2' => 'TBA',
              'label3' => 'Rating',
              'val3' => ($item->rating ?? '5.0') . ' ★',
              'label4' => 'Kamar',
              'val4' => $item->room_type ?? 'DELUXE'
            ],
            default => [
              'icon' => 'fa-ticket',
              'color' => 'gray',
              'title' => 'Layanan Voyago',
              'route' => 'Destinasi Impian',
              'code_o' => 'VYG',
              'code_d' => 'OK',
              'label1' => 'Tanggal',
              'val1' => $booking->created_at->format('d M Y'),
              'label2' => 'Booking ID',
              'val2' => substr($booking->booking_code, -6),
              'label3' => 'Status',
              'val3' => $statusLabel,
              'label4' => 'Total',
              'val4' => 'Rp ' . number_format($booking->total_price, 0, ',', '.')
            ]
          };
        @endphp

        <div
          class="bg-{{ $config['color'] }}-100/50 rounded-3xl p-6 border border-{{ $config['color'] }}-200/50 flex flex-col gap-6 relative group hover:shadow-xl hover:shadow-{{ $config['color'] }}-100/20 transition-all">
          <div class="flex items-center justify-between">
            <span class="font-black text-gray-800 dark:text-white text-sm truncate max-w-[140px]">{{ $config['title'] }}</span>
            <span
              class="{{ $statusClasses }} text-[10px] font-black px-4 py-1.5 rounded-full uppercase tracking-widest">{{ $statusLabel }}</span>
          </div>

          <div class="flex flex-col gap-1 px-2">
            <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">{{ $config['route'] }}</span>
            <div class="flex items-center justify-between text-gray-800 dark:text-white font-black">
              <div class="flex flex-col">
                <span class="text-2xl leading-none">{{ $config['code_o'] }}</span>
              </div>
              <div class="flex-grow flex flex-col items-center px-4">
                <span
                  class="text-[8px] text-gray-300 font-bold mb-1 uppercase tracking-tighter">{{ $booking->category }}</span>
                <div class="w-full h-[1px] bg-gray-200 dark:bg-dark-border relative mb-4">
                  <i
                    class="fas {{ $config['icon'] }} absolute -top-[5px] left-1/2 -translate-x-1/2 text-[10px] text-gray-300 group-hover:text-orange-500 transition-colors"></i>
                </div>
              </div>
              <div class="flex flex-col items-end">
                <span class="text-2xl leading-none">{{ $config['code_d'] }}</span>
              </div>
            </div>
          </div>

          <div class="grid grid-cols-2 gap-4 border-t border-{{ $config['color'] }}-200/50 pt-6">
            <div class="flex flex-col">
              <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">{{ $config['label1'] }}</span>
              <span class="text-xs font-black text-gray-800 dark:text-white mt-1 uppercase">{{ $config['val1'] }}</span>
            </div>
            <div class="flex flex-col items-end">
              <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">{{ $config['label3'] }}</span>
              <span class="text-xs font-black text-gray-800 dark:text-white mt-1 uppercase">{{ $config['val3'] }}</span>
            </div>
            <div class="flex flex-col">
              <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">{{ $config['label2'] }}</span>
              <span class="text-xs font-black text-gray-800 dark:text-white mt-1 uppercase">{{ $config['val2'] }}</span>
            </div>
            <div class="flex flex-col items-end">
              <span class="text-[8px] font-black text-gray-400 uppercase tracking-widest">{{ $config['label4'] }}</span>
              <span class="text-xs font-black text-gray-800 dark:text-white mt-1 uppercase text-right">{{ $config['val4'] }}</span>
            </div>
          </div>
          <button onclick="openTicketModal()"
            class="w-full bg-white dark:bg-dark-card/50 hover:bg-white dark:bg-dark-card text-gray-800 dark:text-white font-black py-3 rounded-2xl text-xs transition-all border border-{{ $config['color'] }}-200/50 shadow-sm active:scale-95 transition-colors duration-300">Lihat
            Detail</button>
        </div>
      @empty
        <div
          class="col-span-1 md:col-span-3 bg-white dark:bg-dark-card/50 border border-dashed border-gray-200 dark:border-dark-border rounded-[32px] p-12 text-center transition-colors duration-300">
          <div class="w-16 h-16 bg-gray-100 dark:bg-dark-border rounded-2xl flex items-center justify-center mx-auto mb-4 text-gray-400">
            <i class="fa-solid fa-calendar-xmark text-2xl"></i>
          </div>
          <h4 class="font-black text-gray-800 dark:text-white mb-1">Belum ada pesanan aktif</h4>
          <p class="text-xs text-gray-400 mb-6">Mulai rencanakan liburanmu dan semua tiketmu akan muncul di sini!</p>
          <a href="{{ route('booking.page') }}"
            class="inline-block bg-[#FF7304] text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg shadow-orange-100">Cari
            Tiket</a>
        </div>
      @endforelse
    @endguest
  </div>

  <!-- E-Ticket Modal -->
  <div id="ticketModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeTicketModal()"></div>

    <!-- Modal Content -->
    <div class="relative min-h-screen flex items-center justify-center p-4"
      onclick="if(event.target === this) closeTicketModal()">
      <div
        class="bg-white dark:bg-dark-card rounded-[32px] shadow-2xl w-full max-w-[380px] overflow-hidden transform transition-all relative transition-colors duration-300">

        <!-- Ticket Header -->
        <div class="p-6 flex items-center justify-between">
          <img src="/images/Logo.png" class="h-7 object-contain">
          <span class="font-black text-gray-800 dark:text-white text-xs tracking-tighter">VOYAGO E-TICKET</span>
        </div>

        <div class="px-6 pb-6 text-center">
          <div class="py-10">
            <i class="fa-solid fa-qrcode text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-black text-gray-800 dark:text-white">Detail Tiket</h3>
            <p class="text-sm text-gray-400 mt-2">Silakan cek menu "Pesanan Saya" untuk melihat e-ticket lengkap dan QR
              Code.</p>
          </div>

          <!-- Action Button -->
          <a href="{{ route('my.bookings') }}"
            class="block w-full bg-[#FF7304] text-white py-4 rounded-[24px] font-black text-lg shadow-xl shadow-orange-100 active:scale-[0.98] transition-all">
            Ke Pesanan Saya
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  function openTicketModal() {
    document.getElementById('ticketModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeTicketModal() {
    document.getElementById('ticketModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
  }

  // Close on ESC
  document.addEventListener('keydown', function (event) {
    if (event.key === "Escape") {
      closeTicketModal();
    }
  });
</script>