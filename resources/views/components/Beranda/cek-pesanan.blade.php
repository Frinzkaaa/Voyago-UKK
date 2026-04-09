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
            'confirmed' => 'bg-blue-50 text-blue-500',
            'completed' => 'bg-green-100 text-green-600',
            'cancelled' => 'bg-red-50 text-red-500',
            'refunded' => 'bg-purple-50 text-purple-400',
            default => 'bg-orange-100 text-orange-600'
          };

          $statusLabel = match ($booking->status->value ?? $booking->status) {
            'confirmed' => 'Terkonfirmasi',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            'refunded' => 'Refunded',
            default => 'Proses'
          };

          if ($booking->payment_status === \App\Enums\PaymentStatus::PENDING) {
            $statusLabel = 'Menunggu Bayar';
            $statusClasses = 'bg-orange-100 text-orange-600';
          } elseif ($booking->payment_status === \App\Enums\PaymentStatus::PAID) {
            if ($statusLabel === 'Proses') $statusLabel = 'Dibayar';
            $statusClasses = 'bg-green-100 text-green-600';
          }

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
          <button onclick="showOrderDetail({{ json_encode($booking) }})"
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

  <!-- Detail Order Modal -->
  <div id="orderModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeOrderModal()"></div>

    <!-- Modal Content -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-[340px] animate-in fade-in zoom-in duration-300">
      <div class="bg-white dark:bg-dark-card rounded-[2.5rem] overflow-hidden shadow-2xl transition-colors duration-300 border border-gray-100 dark:border-dark-border">
        <!-- Header: Minimal & Clean -->
        <div class="p-5 flex items-center justify-between border-b border-gray-50 dark:border-dark-border">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-orange-50 dark:bg-orange-500/10 rounded-2xl flex items-center justify-center text-orange-500 transition-colors">
              <i class="fa-solid fa-plane text-base" id="modal-product-icon"></i>
            </div>
            <div>
              <h2 class="text-sm font-black text-gray-800 dark:text-white leading-none" id="modal-order-code">#VYG-12345678</h2>
              <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1" id="modal-product-name">Pesawat</p>
            </div>
          </div>
          <button onclick="closeOrderModal()" class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-orange-500 transition-all">
            <i class="fa-solid fa-xmark text-sm"></i>
          </button>
        </div>

        <!-- Body -->
        <div class="p-5">
          <div class="grid grid-cols-2 gap-4 mb-5">
            <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-2xl">
              <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Payment</p>
              <p class="text-[10px] font-black text-orange-500 uppercase" id="modal-payment-status">PAID</p>
            </div>
            <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-2xl">
              <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">Date</p>
              <p class="text-[10px] font-black text-gray-800 dark:text-white" id="modal-order-date">08 Apr 2026</p>
            </div>
          </div>

          <div class="px-1 mb-5 space-y-3">
             <div class="flex justify-between items-center">
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Travel Status</span>
                <span class="text-[10px] font-black text-gray-800 dark:text-white capitalize" id="modal-travel-status">Upcoming</span>
             </div>
             <div class="flex justify-between items-center">
                <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Passenger</span>
                <span class="text-[10px] font-black text-gray-800 dark:text-white" id="modal-passenger-count">1 Pax</span>
             </div>
             <div class="flex justify-between items-center border-t border-gray-100 dark:border-dark-border pt-3 mt-3">
                <span class="text-[10px] font-black text-gray-800 dark:text-white uppercase">Total Price</span>
                <span class="text-sm font-black text-orange-500" id="modal-total-price">Rp 0</span>
             </div>
          </div>

          <!-- Compact QR Section -->
          <div id="modal-qr-section" class="py-4 border-t border-dashed border-gray-100 dark:border-dark-border flex flex-col items-center">
            <div class="relative bg-white p-2 rounded-2xl shadow-sm mb-3">
              <img id="modal-qr-code" src="" alt="QR" class="w-24 h-24 grayscale">
            </div>
            <p class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em]">Scan QR for Check-in</p>
          </div>

          <!-- Actions -->
          <div class="mt-4 flex gap-3">
            <a id="modal-ticket-download" href="#" class="w-12 h-12 flex items-center justify-center bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-orange-500 rounded-2xl transition-all border border-gray-100 dark:border-dark-border">
              <i class="fas fa-file-pdf"></i>
            </a>
            <button onclick="closeOrderModal()" class="flex-1 bg-zinc-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-orange-500 transition-all shadow-lg active:scale-95">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    @keyframes scan {
      0% { top: 0; opacity: 0; }
      50% { opacity: 1; }
      100% { top: 100%; opacity: 0; }
    }

    .animate-scan {
      position: absolute;
      animation: scan 2s linear infinite;
    }
  </style>
</div>

<script>
  function showOrderDetail(booking) {
    const modal = document.getElementById('orderModal');
    if (!modal) return;

    // Helper to set text if element exists
    const setText = (id, text) => {
        const el = document.getElementById(id);
        if (el) el.innerText = text;
    };

    setText('modal-order-code', '#' + booking.booking_code);
    setText('modal-payment-status', (booking.payment_status || 'pending').toUpperCase());

    const dateObj = new Date(booking.created_at);
    setText('modal-order-date', dateObj.toLocaleDateString('id-ID', {
      day: '2-digit',
      month: 'long',
      year: 'numeric'
    }));
    
    setText('modal-order-time', dateObj.toLocaleTimeString('id-ID', {
      hour: '2-digit',
      minute: '2-digit'
    }));

    setText('modal-product-name', booking.category);
    setText('modal-passenger-count', (booking.passenger_count || 1) + ' Pax');

    const total = parseFloat(booking.total_price || 0);
    const unitPrice = total / (booking.passenger_count || 1);

    setText('modal-unit-price', 'Rp ' + unitPrice.toLocaleString('id-ID'));
    setText('modal-total-price', 'Rp ' + total.toLocaleString('id-ID'));
    setText('modal-payment-method', booking.payment_method || 'BANK');

    // Travel Status Logic
    let travelStatus = 'Upcoming';
    if (booking.status === 'completed') travelStatus = 'Selesai';
    if (booking.status === 'cancelled') travelStatus = 'Dibatalkan';
    setText('modal-travel-status', travelStatus);

    // Icon mapping
    const icons = {
      'kereta': 'fa-train',
      'pesawat': 'fa-plane',
      'bus': 'fa-bus',
      'hotel': 'fa-hotel',
      'wisata': 'fa-mountain-sun'
    };
    const iconEl = document.getElementById('modal-product-icon');
    if (iconEl) iconEl.className = 'fa-solid ' + (icons[booking.category] || 'fa-receipt') + ' text-base';

    // QR Code
    const qrImg = document.getElementById('modal-qr-code');
    const qrSection = document.getElementById('modal-qr-section');
    const downloadBtn = document.getElementById('modal-ticket-download');

    if (booking.payment_status === 'paid') {
      if (qrSection) qrSection.style.display = 'flex';
      if (qrImg) qrImg.src = `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=${booking.booking_code}&color=000&bgcolor=fff`;
      if (downloadBtn) {
          downloadBtn.style.display = 'flex';
          downloadBtn.href = `/booking/${booking.id}/ticket`;
      }
    } else {
      if (qrSection) qrSection.style.display = 'none';
      if (downloadBtn) downloadBtn.style.display = 'none';
    }

    // Show modal
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeOrderModal() {
    const modal = document.getElementById('orderModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
  }
</script>