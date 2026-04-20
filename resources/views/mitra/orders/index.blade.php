@extends('mitra.layout')

@section('content')
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12">
        <div class="space-y-1">
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase italic">Manajemen Pesanan</h2>
            <p class="text-sm text-gray-500 dark:text-zinc-400 font-medium">Pantau rincian transaksi dan status keberangkatan pelanggan secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative group">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xs transition-colors group-focus-within:text-orange-500"></i>
                <input type="text" placeholder="Cari Kode Booking..."
                    class="bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-2xl py-4 pl-12 pr-6 text-xs font-black uppercase tracking-widest focus:outline-none focus:ring-2 focus:ring-orange-500/20 w-64 transition-all placeholder:text-gray-300 dark:text-white">
            </div>
            <button class="bg-gray-900 dark:bg-zinc-800 text-white p-4 rounded-2xl hover:scale-105 active:scale-95 transition-all">
                <i class="fa-solid fa-sliders"></i>
            </button>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden mb-12">
        <div class="p-8 border-b border-gray-50 dark:border-zinc-800 flex items-center justify-between bg-zinc-50/30 dark:bg-zinc-900/50">
            <div class="flex gap-3">
                <button class="px-6 py-2.5 bg-gray-900 text-white rounded-xl text-[10px] font-black uppercase tracking-[0.2em] shadow-lg">Semua</button>
                <button class="px-6 py-2.5 bg-white dark:bg-zinc-800 text-gray-400 dark:text-zinc-500 border border-gray-100 dark:border-zinc-700 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-50 dark:hover:bg-zinc-700 transition-all">Pending</button>
                <button class="px-6 py-2.5 bg-white dark:bg-zinc-800 text-gray-400 dark:text-zinc-500 border border-gray-100 dark:border-zinc-700 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-gray-50 dark:hover:bg-zinc-700 transition-all">Confirmed</button>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-emerald-50 dark:bg-emerald-500/10 rounded-xl border border-emerald-100 dark:border-emerald-500/20">
                <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                <span class="text-[9px] font-black text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Auto-Sync Active</span>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-zinc-950/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Order Context</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Customer Identity</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Product / Category</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-right">Total Payment</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center">Status</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-zinc-800 pb-10">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/30 dark:hover:bg-zinc-800/30 transition-all group">
                            <td class="px-10 py-8">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">#{{ $order->booking_code }}</span>
                                    <span class="text-[9px] text-gray-400 font-bold uppercase mt-1 italic">{{ $order->created_at->format('d M, Y') }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-2xl bg-orange-500 text-white flex items-center justify-center font-black text-xs shadow-lg shadow-orange-500/20">
                                        {{ substr($order->user->name ?? 'C', 0, 1) }}
                                    </div>
                                    <div class="flex flex-col">
                                        <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $order->user->name ?? 'Guest Client' }}</p>
                                        <p class="text-[9px] text-gray-400 font-bold uppercase">{{ $order->user->email ?? 'no-email@voyago.id' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex items-center gap-3">
                                    <div class="px-3 py-1 bg-gray-900 dark:bg-zinc-800 text-white text-[10px] font-black uppercase rounded-lg italic">
                                        {{ $order->category }}
                                    </div>
                                    <span class="text-[9px] text-gray-400 font-bold uppercase tracking-widest">ID: {{ $order->item_id }}</span>
                                </div>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span class="text-sm font-black text-gray-900 dark:text-white tracking-widest italic outline-text">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-center">
                                @php
                                    $statusStyle = match ($order->status) {
                                        \App\Enums\BookingStatus::PENDING => 'bg-orange-50 dark:bg-orange-500/10 text-orange-500 border-orange-100 dark:border-orange-500/20',
                                        \App\Enums\BookingStatus::CONFIRMED => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 border-emerald-100 dark:border-emerald-500/20',
                                        \App\Enums\BookingStatus::COMPLETED => 'bg-blue-50 dark:bg-blue-500/10 text-blue-500 border-blue-100 dark:border-blue-500/20',
                                        \App\Enums\BookingStatus::CANCELLED => 'bg-red-50 dark:bg-red-500/10 text-red-500 border-red-100 dark:border-red-500/20',
                                        default => 'bg-gray-50 dark:bg-zinc-800 text-gray-400 border-gray-100 dark:border-zinc-700',
                                    };
                                @endphp
                                <span class="px-4 py-2 border {{ $statusStyle }} rounded-2xl text-[9px] font-black uppercase tracking-[0.1em] italic">
                                    {{ $order->status->value }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-all transform translate-x-2 group-hover:translate-x-0">
                                    @if($order->status === \App\Enums\BookingStatus::PENDING)
                                        <span class="text-[9px] font-black uppercase tracking-widest text-orange-500 bg-orange-50 dark:bg-orange-500/10 px-4 py-2 rounded-xl italic">Menunggu Pembayaran</span>
                                        <button onclick="showOrderDetail({{ json_encode($order->load('user')) }})"
                                            class="bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-zinc-400 px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-900 hover:text-white transition-all transform flex items-center gap-2">
                                            <i class="fa-solid fa-eye"></i> Details
                                        </button>
                                    @elseif($order->status === \App\Enums\BookingStatus::CONFIRMED)
                                        <form action="{{ route('partner.orders.update-status', $order->id) }}" method="POST" onsubmit="return confirm('Konfirmasi bahwa tiket ini telah digunakan oleh pelanggan?')">
                                            @csrf
                                            <input type="hidden" name="status" value="{{ \App\Enums\BookingStatus::COMPLETED }}">
                                            <button class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-[9px] font-black uppercase tracking-widest transition-all hover:bg-blue-700 hover:scale-105 active:scale-95 shadow-xl shadow-blue-600/10">Konfirmasi Pemakaian</button>
                                        </form>
                                        <button onclick="showOrderDetail({{ json_encode($order->load('user')) }})"
                                            class="bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-zinc-400 px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-900 hover:text-white transition-all transform flex items-center gap-2">
                                            <i class="fa-solid fa-eye"></i> Details
                                        </button>
                                    @else
                                        <button onclick="showOrderDetail({{ json_encode($order->load('user')) }})"
                                            class="bg-gray-100 dark:bg-zinc-800 text-gray-600 dark:text-zinc-400 px-6 py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-gray-900 hover:text-white transition-all transform flex items-center gap-2">
                                            <i class="fa-solid fa-eye"></i> Details
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-10 py-32 text-center text-gray-400 font-bold uppercase text-[10px] tracking-[0.3em]">
                                <i class="fa-solid fa-box-open text-4xl block mb-6 opacity-20"></i>
                                Tidak ada data pesanan yang tersedia saat ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Redesigned Premium Modal -->
    <div id="orderModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md" onclick="closeOrderModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-xl p-6">
            <div class="bg-white dark:bg-zinc-950 rounded-[40px] overflow-hidden shadow-2xl border border-gray-100 dark:border-zinc-800 transition-all animate-scale-in">
                <!-- Header -->
                <div class="p-10 border-b border-gray-50 dark:border-zinc-900 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] italic mb-1">Transaction Detail</p>
                        <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tighter" id="modal-order-code">#VYG-XXXX</h2>
                    </div>
                    <button onclick="closeOrderModal()" class="w-12 h-12 bg-gray-50 dark:bg-zinc-900 rounded-full flex items-center justify-center text-gray-400 hover:text-orange-500 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <!-- Body -->
                <div class="p-10">
                    <div class="grid grid-cols-2 gap-10 mb-10">
                        <div class="space-y-4">
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Primary Client</p>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-[10px] font-black text-white" id="modal-customer-avatar">V</div>
                                    <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter" id="modal-customer-name">-</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Booking Timeline</p>
                            <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter" id="modal-order-date">-</p>
                            <p class="text-[9px] text-gray-400 font-bold uppercase mt-1">Confirmed Timestamp</p>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-zinc-900 rounded-[30px] p-8 border border-gray-100 dark:border-zinc-800">
                        <div class="flex items-center gap-6 mb-8">
                            <div class="w-14 h-14 bg-white dark:bg-zinc-800 border border-gray-100 dark:border-zinc-700 rounded-2xl flex items-center justify-center text-gray-900 dark:text-white shadow-sm">
                                <i class="fa-solid fa-cube text-xl" id="modal-product-icon"></i>
                            </div>
                            <div>
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1 italic">Purchased Item</p>
                                <h4 class="text-lg font-black text-gray-900 dark:text-white tracking-tighter" id="modal-product-name">-</h4>
                            </div>
                        </div>
                        
                        <div class="space-y-4 border-t border-gray-100 dark:border-zinc-800 pt-8 mt-2">
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase">Quantity / Unit</span>
                                <span class="text-xs font-black text-gray-900 dark:text-white uppercase" id="modal-passenger-count">-</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-[10px] font-black text-gray-400 uppercase">Settlement Rate</span>
                                <span class="text-xs font-black text-gray-900 dark:text-white tracking-widest" id="modal-unit-price">-</span>
                            </div>
                            <div class="flex justify-between items-center pt-6 border-t border-gray-100 dark:border-zinc-800">
                                <span class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em] italic">Total Revenue</span>
                                <span class="text-2xl font-black text-orange-500 tracking-tighter italic" id="modal-total-price">Rp 0</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-10">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-emerald-500 animate-pulse shadow-glow shadow-emerald-500/50"></div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]" id="modal-order-status">VERIFIED</span>
                        </div>
                        <button onclick="closeOrderModal()"
                            class="bg-gray-900 text-white px-10 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-black transition-all shadow-xl shadow-gray-900/10">
                            Dismiss Preview
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showOrderDetail(order) {
            const modal = document.getElementById('orderModal');
            document.getElementById('modal-order-code').innerText = '#' + order.booking_code;
            document.getElementById('modal-customer-name').innerText = order.user ? order.user.name : 'Unknown Client';
            document.getElementById('modal-customer-avatar').innerText = (order.user?.name ?? 'C').charAt(0);
            const dateObj = new Date(order.created_at);
            document.getElementById('modal-order-date').innerText = dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
            document.getElementById('modal-product-name').innerText = order.category.toUpperCase();
            document.getElementById('modal-passenger-count').innerText = order.passenger_count + ' UNIT SEATS';
            const total = parseFloat(order.total_price);
            const unitPrice = total / (order.passenger_count || 1);
            document.getElementById('modal-unit-price').innerText = 'Rp ' + unitPrice.toLocaleString('id-ID');
            document.getElementById('modal-total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('modal-order-status').innerText = (order.status.value || order.status).toUpperCase();
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

    <style>
        .animate-scale-in { animation: scaleIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .outline-text { -webkit-text-stroke: 0.1px currentColor; }
    </style>
@endsection