@extends('mitra.layout')

@section('content')
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 tracking-tight">Manajemen Pesanan</h2>
        <p class="text-sm text-gray-500 mt-1">Pantau rincian transaksi dan status keberangkatan pelanggan</p>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-white">
            <div class="flex gap-2">
                <button
                    class="px-3 py-1.5 bg-gray-900 text-white rounded text-[10px] font-semibold uppercase tracking-wider">Semua</button>
                <button
                    class="px-3 py-1.5 bg-gray-50 text-gray-500 rounded text-[10px] font-semibold uppercase tracking-wider hover:bg-gray-100">Pending</button>
                <button
                    class="px-3 py-1.5 bg-gray-50 text-gray-500 rounded text-[10px] font-semibold uppercase tracking-wider hover:bg-gray-100">Selesai</button>
            </div>
            <div class="relative">
                <i
                    class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]"></i>
                <input type="text" placeholder="Cari Kode Booking..."
                    class="bg-gray-50 border border-gray-200 rounded py-2 pl-9 pr-4 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-orange-500 w-48 transition-all">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Invoice / Tgl
                        </th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Data
                            Pelanggan</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Item Produk
                        </th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400 text-right">
                            Nilai Bayar</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400 text-center">
                            Status</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400 text-right">
                            Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        <td class="px-6 py-4">
                                            <p class="font-bold text-gray-900 text-xs">#{{ $order->booking_code }}</p>
                                            <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-tight">
                                                {{ $order->created_at->format('d M Y') }}</p>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-7 h-7 rounded bg-gray-100 flex items-center justify-center text-gray-500 text-[10px] font-bold">
                                                    {{ substr($order->user->name ?? 'C', 0, 1) }}
                                                </div>
                                                <p class="font-semibold text-gray-900 text-xs">
                                                    {{ $order->user->name ?? 'Customer Account' }}</p>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <p class="font-medium text-gray-900 text-xs italic capitalize">{{ $order->category }}</p>
                                            <p class="text-[9px] text-gray-400 mt-0.5 tracking-wider">REF ID: {{ $order->item_id }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <p class="font-bold text-gray-900 text-xs text-right">Rp
                                                {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @php
                                                $statusStyle = match ($order->status) {
                                                    \App\Enums\BookingStatus::PENDING => 'bg-orange-50 text-orange-600 border-orange-100',
                                                    \App\Enums\BookingStatus::CONFIRMED => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                    \App\Enums\BookingStatus::COMPLETED => 'bg-blue-50 text-blue-600 border-blue-100',
                                                    \App\Enums\BookingStatus::CANCELLED => 'bg-red-50 text-red-600 border-red-100',
                                                    default => 'bg-gray-50 text-gray-500 border-gray-100',
                                                };
                                            @endphp
                         <span
                                                class="px-2 py-0.5 border {{ $statusStyle }} rounded text-[9px] font-bold uppercase">{{ $order->status->value }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                @if($order->status === \App\Enums\BookingStatus::PENDING)
                                                    <form action="{{ route('partner.orders.confirm', $order->id) }}" method="POST">
                                                        @csrf
                                                        <button
                                                            class="bg-gray-900 text-white px-3 py-1.5 rounded text-[9px] font-bold uppercase tracking-wider transition-colors hover:bg-black">Setuju</button>
                                                    </form>
                                                    <button
                                                        class="bg-white border border-gray-200 text-gray-400 px-3 py-1.5 rounded text-[9px] font-bold uppercase tracking-wider hover:bg-red-50 hover:text-red-500 transition-colors">Batal</button>
                                                @else
                                                    <button onclick="showOrderDetail({{ json_encode($order) }})"
                                                        class="bg-gray-50 text-gray-500 hover:bg-gray-100 px-3 py-1.5 rounded text-[9px] font-bold uppercase tracking-wider transition-colors">Details</button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center">
                                <div
                                    class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100 text-gray-200">
                                    <i class="fa-solid fa-receipt text-2xl"></i>
                                </div>
                                <p class="font-semibold text-gray-900 text-sm mb-1">Tidak Ada Pesanan</p>
                                <p class="text-xs text-gray-500">Belum ada transaksi pelanggan saat ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Detail Order Modal -->
    <div id="orderModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-[2px]" onclick="closeOrderModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm">
            <div class="bg-white rounded-md overflow-hidden shadow-2xl border border-gray-200">
                <!-- Header -->
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Order Detail</p>
                        <h2 class="text-base font-bold text-gray-900 mt-1" id="modal-order-code">#VYG-XXXX</h2>
                    </div>
                    <button onclick="closeOrderModal()" class="text-gray-400 hover:text-gray-600"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>

                <!-- Body -->
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[9px] font-semibold text-gray-400 uppercase">Customer</p>
                            <p class="text-xs font-bold text-gray-900 mt-1" id="modal-customer-name">-</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-semibold text-gray-400 uppercase">Waktu Pesan</p>
                            <p class="text-xs font-bold text-gray-900 mt-1" id="modal-order-date">-</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 rounded p-4 border border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div
                                class="w-8 h-8 bg-white border border-gray-100 rounded flex items-center justify-center text-gray-800">
                                <i class="fa-solid fa-cube text-xs" id="modal-product-icon"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-semibold text-gray-400 uppercase">Item</p>
                                <h4 class="text-xs font-bold text-gray-900" id="modal-product-name">-</h4>
                            </div>
                        </div>
                        <div class="space-y-2 border-t border-gray-100 pt-4">
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="text-gray-500">Kuantitas</span>
                                <span class="font-bold text-gray-900" id="modal-passenger-count">-</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="text-gray-500">Harga Satuan</span>
                                <span class="font-bold text-gray-900" id="modal-unit-price">-</span>
                            </div>
                            <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                <span class="text-[10px] font-bold text-gray-400 uppercase">Total Bayar</span>
                                <span class="text-sm font-bold text-gray-900" id="modal-total-price">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-widest"
                                id="modal-order-status">STATUS</span>
                        </div>
                        <button onclick="closeOrderModal()"
                            class="bg-gray-900 text-white px-5 py-2 rounded text-[10px] font-bold uppercase tracking-wider hover:bg-black transition-colors">Tutup
                            Window</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showOrderDetail(order) {
            const modal = document.getElementById('orderModal');
            document.getElementById('modal-order-code').innerText = '#' + order.booking_code;
            document.getElementById('modal-customer-name').innerText = order.user ? order.user.name : 'Unknown Customer';
            const dateObj = new Date(order.created_at);
            document.getElementById('modal-order-date').innerText = dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
            document.getElementById('modal-product-name').innerText = order.category.charAt(0).toUpperCase() + order.category.slice(1);
            document.getElementById('modal-passenger-count').innerText = order.passenger_count + ' Unit/Pax';
            const total = parseFloat(order.total_price);
            const unitPrice = total / (order.passenger_count || 1);
            document.getElementById('modal-unit-price').innerText = 'Rp ' + unitPrice.toLocaleString('id-ID');
            document.getElementById('modal-total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('modal-order-status').innerText = order.status;
            const icons = { 'kereta': 'fa-train', 'pesawat': 'fa-plane', 'bus': 'fa-bus', 'hotel': 'fa-hotel', 'wisata': 'fa-mountain-sun' };
            document.getElementById('modal-product-icon').className = 'fa-solid ' + (icons[order.category] || 'fa-receipt');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        function closeOrderModal() {
            document.getElementById('orderModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection