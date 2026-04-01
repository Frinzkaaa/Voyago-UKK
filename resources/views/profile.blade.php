@extends('layouts.app')

@section('content')
    <div class="max-w-[1280px] mx-auto space-y-8">

        <!-- Profile Header Section -->
        <div
            class="bg-white dark:bg-dark-card rounded-[24px] p-8 shadow-sm border border-gray-100 dark:border-dark-border flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden transition-colors duration-300">
            <!-- Background decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-orange-50 rounded-full -mr-32 -mt-32 opacity-40"></div>
            <div class="absolute bottom-0 left-0 w-32 h-32 bg-orange-50 rounded-full -ml-16 -mb-16 opacity-30"></div>

            <div class="flex flex-col md:flex-row items-center gap-6 relative">
                <div class="relative group">
                    <div class="w-32 h-32 rounded-full border-4 border-orange-50 overflow-hidden shadow-lg">
                        <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : '/images/Avatarprof.jpeg' }}"
                            class="w-full h-full object-cover">
                    </div>
                    <a href="/settings"
                        class="absolute bottom-0 right-0 w-10 h-10 bg-[#FF7304] text-white rounded-full flex items-center justify-center border-4 border-white shadow-md hover:scale-110 transition-all">
                        <i class="fa-solid fa-camera text-sm"></i>
                    </a>
                </div>
                <div class="text-center md:text-left">
                    <div class="flex items-center justify-center md:justify-start gap-2 mb-1">
                        <h1 class="text-3xl font-bold text-gray-800 dark:text-white">{{ auth()->user()->name }}</h1>
                        <span
                            class="px-3 py-1 bg-orange-500 text-white text-[10px] font-bold rounded-full uppercase tracking-widest shadow-sm">{{ auth()->user()->badge }}</span>
                    </div>
                    <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mb-2">
                        <p class="text-gray-500 dark:text-[#A1A1AA] text-sm">{{ auth()->user()->email }}</p>
                        @if(auth()->user()->phone)
                            <div class="hidden md:block w-1 h-1 bg-gray-300 rounded-full"></div>
                            <p class="text-gray-500 dark:text-[#A1A1AA] text-sm">{{ auth()->user()->phone }}</p>
                        @endif
                        <div class="hidden md:block w-1 h-1 bg-gray-300 rounded-full"></div>
                        <div class="flex items-center gap-1.5">
                            <i class="fa-solid fa-coins text-orange-400 text-xs"></i>
                            <p class="text-sm font-black text-gray-700 dark:text-gray-300">{{ auth()->user()->points }} <span
                                    class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter">Voyago
                                    Points</span></p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 flex items-center justify-center md:justify-start gap-1">
                        <i class="fa-regular fa-calendar-check"></i> Member since
                        {{ auth()->user()->created_at->format('M Y') }}
                    </p>
                </div>
            </div>

            <div class="flex gap-4 relative">
                <button
                    class="px-8 py-3 bg-[#FF7304] text-white rounded-full font-bold shadow-lg shadow-orange-100 hover:scale-105 transition-all">Edit
                    Profil</button>
                <a href="/pesanan-saya"
                    class="px-8 py-3 border-2 border-[#FF7304] text-[#FF7304] rounded-full font-bold hover:bg-[#FF7304] hover:text-white transition-all">Lihat
                    Aktivitas</a>
            </div>
        </div>

        <!-- Travel Summary Section (4 Cards) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white dark:bg-dark-card p-6 rounded-[24px] shadow-sm border border-gray-100 dark:border-dark-border flex items-center gap-4 group hover:border-orange-100 transition-al transition-colors duration-300l">
                <div
                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-[#FF7304] group-hover:bg-[#FF7304] group-hover:text-white transition-all">
                    <i class="fa-solid fa-map-location-dot text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['total_trips'] }}</p>
                    <p class="text-xs text-gray-400 font-medium">Total Trips</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-dark-card p-6 rounded-[24px] shadow-sm border border-gray-100 dark:border-dark-border flex items-center gap-4 group hover:border-orange-100 transition-al transition-colors duration-300l">
                <div
                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-[#FF7304] group-hover:bg-[#FF7304] group-hover:text-white transition-all">
                    <i class="fa-solid fa-earth-asia text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['destinations'] }}</p>
                    <p class="text-xs text-gray-400 font-medium">Destinations</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-dark-card p-6 rounded-[24px] shadow-sm border border-gray-100 dark:border-dark-border flex items-center gap-4 group hover:border-orange-100 transition-al transition-colors duration-300l">
                <div
                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-[#FF7304] group-hover:bg-[#FF7304] group-hover:text-white transition-all">
                    <i class="fa-solid fa-people-roof text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['planning_rooms'] }}</p>
                    <p class="text-xs text-gray-400 font-medium">Planning Rooms</p>
                </div>
            </div>
            <div
                class="bg-white dark:bg-dark-card p-6 rounded-[24px] shadow-sm border border-gray-100 dark:border-dark-border flex items-center gap-4 group hover:border-orange-100 transition-al transition-colors duration-300l">
                <div
                    class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-[#FF7304] group-hover:bg-[#FF7304] group-hover:text-white transition-all">
                    <i class="fa-solid fa-heart text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $stats['wishlist'] }}</p>
                    <p class="text-xs text-gray-400 font-medium">Wishlist Saved</p>
                </div>
            </div>
        </div>

        <!-- 2 Column Layout for Activities & More -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Left: Recent Activity (2/3 width) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white dark:bg-dark-card rounded-[24px] p-8 shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Aktivitas Terakhir</h2>
                    <div class="space-y-6">
                        @foreach($activities as $activity)
                            <div onclick="{{ $activity['type'] == 'booking' ? 'showOrderDetail(' . json_encode($activity['raw']) . ')' : '' }}"
                                class="flex items-center justify-between p-4 bg-gray-50 dark:bg-[#121212]/50 rounded-2xl hover:bg-gray-50 dark:bg-[#121212] transition-all {{ $activity['type'] == 'booking' ? 'cursor-pointer' : '' }}">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-12 h-12 rounded-full bg-white dark:bg-dark-card flex items-center justify-center text-[#FF7304] shadow-sm transition-colors duration-300">
                                        <i class="fa-solid {{ $activity['icon'] }}"></i>
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 dark:text-white text-sm">{{ $activity['title'] }}</p>
                                        <p class="text-[10px] text-gray-400 tracking-tight">{{ $activity['date'] }}</p>
                                    </div>
                                </div>
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-bold {{ $activity['type'] == 'booking' ? 'bg-green-100 text-green-600' : ($activity['type'] == 'wishlist' ? 'bg-red-50 text-red-500' : 'bg-orange-100 text-orange-600') }}">
                                    {{ $activity['status'] }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-8 flex justify-center">
                        <a href="/pesanan-saya" class="text-sm font-bold text-[#FF7304] hover:underline">Lihat Semua
                            Aktivitas</a>
                    </div>
                </div>

                <!-- Detail Order Modal -->
                <div id="orderModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto">
                    <!-- Backdrop/Overlay -->
                    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
                        onclick="closeOrderModal()"></div>

                    <!-- Modal Wrapper (Clickable area outside card) -->
                    <div class="relative min-h-screen flex items-center justify-center p-4"
                        onclick="if(event.target === this) closeOrderModal()">
                        <div class="bg-white dark:bg-dark-card rounded-[2rem] overflow-hidden shadow-2xl w-full max-w-xl relative transition-colors duration-300">
                            <!-- Header -->
                            <div class="bg-gradient-to-r from-[#FF7304] to-[#FFAC63] p-8 text-white relative">
                                <button onclick="closeOrderModal()"
                                    class="absolute top-6 right-6 text-white/50 hover:text-white transition-all">
                                    <i class="fa-solid fa-xmark text-xl"></i>
                                </button>
                                <h3 class="text-xs font-black uppercase tracking-[0.2em] mb-2 text-white/70">Order Details
                                </h3>
                                <h2 class="text-3xl font-black" id="modal-order-code">#VYG-12345678</h2>
                            </div>

                            <!-- Body -->
                            <div class="p-6 md:p-10">
                                <div class="grid grid-cols-2 gap-8 mb-10">
                                    <div>
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Tipe
                                            Pesanan</p>
                                        <p class="font-bold text-gray-800 dark:text-white text-lg mb-1 capitalize" id="modal-product-name">
                                            Pesawat</p>
                                        <p class="text-xs text-[#FF7304] uppercase font-bold" id="modal-payment-status">Paid
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Waktu
                                            Pemesanan</p>
                                        <p class="font-bold text-gray-800 dark:text-white" id="modal-order-date">23 Feb 2026</p>
                                        <p class="text-xs text-gray-400" id="modal-order-time">11:18</p>
                                    </div>
                                </div>

                                <div class="bg-gray-50 dark:bg-[#121212] rounded-3xl p-6 mb-10">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="w-12 h-12 bg-white dark:bg-dark-card rounded-2xl flex items-center justify-center text-[#FF7304] shadow-sm transition-colors duration-300">
                                                <i class="fa-solid fa-plane text-xl" id="modal-product-icon"></i>
                                            </div>
                                            <div>
                                                <p
                                                    class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                                    Status Perjalanan</p>
                                                <h4 class="font-black text-gray-800 dark:text-white text-lg capitalize"
                                                    id="modal-travel-status">Upcoming</h4>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                                Jumlah</p>
                                            <p class="font-black text-gray-800 dark:text-white text-xl" id="modal-passenger-count">2 Pax</p>
                                        </div>
                                    </div>

                                    <div class="h-px bg-gray-200 dark:bg-dark-border/50 mb-6"></div>

                                    <div class="space-y-4">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-500 dark:text-[#A1A1AA] font-bold">Harga Satuan</span>
                                            <span class="font-bold text-gray-800 dark:text-white" id="modal-unit-price">Rp 0</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-gray-500 dark:text-[#A1A1AA] font-bold">Metode Pembayaran</span>
                                            <span class="font-bold text-[#FF7304] uppercase tracking-wider"
                                                id="modal-payment-method">Transfer Bank</span>
                                        </div>
                                        <div class="flex justify-between items-center pt-2">
                                            <span class="text-gray-800 dark:text-white font-black uppercase text-xs tracking-widest">Total
                                                Bayar</span>
                                            <span class="text-2xl font-black text-[#FF7304]" id="modal-total-price">Rp
                                                0</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-end gap-4">
                                    <button onclick="closeOrderModal()"
                                        class="bg-gray-900 text-white px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-gray-800 transition-all shadow-xl">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function showOrderDetail(booking) {
                    const modal = document.getElementById('orderModal');

                    // Populate fields
                    document.getElementById('modal-order-code').innerText = '#' + booking.booking_code;
                    document.getElementById('modal-payment-status').innerText = booking.payment_status.toUpperCase();

                    const dateObj = new Date(booking.created_at);
                    document.getElementById('modal-order-date').innerText = dateObj.toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' });
                    document.getElementById('modal-order-time').innerText = dateObj.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                    document.getElementById('modal-product-name').innerText = booking.category;
                    document.getElementById('modal-passenger-count').innerText = booking.passenger_count + ' Pax';

                    const total = parseFloat(booking.total_price);
                    const unitPrice = total / booking.passenger_count;

                    document.getElementById('modal-unit-price').innerText = 'Rp ' + unitPrice.toLocaleString('id-ID');
                    document.getElementById('modal-total-price').innerText = 'Rp ' + total.toLocaleString('id-ID');
                    document.getElementById('modal-payment-method').innerText = booking.payment_method || 'TRANSFER BANK';

                    // Travel Status Logic
                    let travelStatus = 'Upcoming';
                    if (booking.payment_status === 'completed') travelStatus = 'Selesai';
                    if (booking.payment_status === 'cancelled') travelStatus = 'Dibatalkan';
                    document.getElementById('modal-travel-status').innerText = travelStatus;

                    // Icon mapping
                    const icons = {
                        'kereta': 'fa-train',
                        'pesawat': 'fa-plane',
                        'bus': 'fa-bus',
                        'hotel': 'fa-hotel',
                        'wisata': 'fa-mountain-sun'
                    };
                    document.getElementById('modal-product-icon').className = 'fa-solid ' + (icons[booking.category] || 'fa-receipt');

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

            <!-- Favorite Destinations Preview -->
            <div class="bg-white dark:bg-dark-card rounded-[24px] p-8 shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Destinasi Favorit</h2>
                    <a href="/pesanan-saya" class="text-sm font-bold text-[#FF7304] hover:underline">Lihat Semua</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Sample 1 -->
                    <div class="group cursor-pointer">
                        <div class="relative h-32 rounded-[20px] overflow-hidden mb-3">
                            <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=400"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="absolute top-2 right-2 w-7 h-7 bg-white dark:bg-dark-card rounded-full flex items-center justify-center text-red-500 shadow-md transition-colors duration-300">
                                <i class="fa-solid fa-heart text-[10px]"></i>
                            </div>
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-white text-sm truncate">Bali, Indonesia</h3>
                        <p class="text-[10px] text-gray-400">Rp 1.500.000</p>
                    </div>
                    <!-- Sample 2 -->
                    <div class="group cursor-pointer">
                        <div class="relative h-32 rounded-[20px] overflow-hidden mb-3">
                            <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?auto=format&fit=crop&w=400"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="absolute top-2 right-2 w-7 h-7 bg-white dark:bg-dark-card rounded-full flex items-center justify-center text-red-500 shadow-md transition-colors duration-300">
                                <i class="fa-solid fa-heart text-[10px]"></i>
                            </div>
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-white text-sm truncate">Kyoto, Japan</h3>
                        <p class="text-[10px] text-gray-400">Rp 8.500.000</p>
                    </div>
                    <!-- Sample 3 -->
                    <div class="group cursor-pointer">
                        <div class="relative h-32 rounded-[20px] overflow-hidden mb-3">
                            <img src="https://images.unsplash.com/photo-1518173946687-a4c8a3b74dbf?auto=format&fit=crop&w=400"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="absolute top-2 right-2 w-7 h-7 bg-white dark:bg-dark-card rounded-full flex items-center justify-center text-red-500 shadow-md transition-colors duration-300">
                                <i class="fa-solid fa-heart text-[10px]"></i>
                            </div>
                        </div>
                        <h3 class="font-bold text-gray-800 dark:text-white text-sm truncate">Swiss Alps</h3>
                        <p class="text-[10px] text-gray-400">Rp 15.200.000</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Account Info (1/3 width) -->
        <div class="space-y-8">
            <div class="bg-white dark:bg-dark-card rounded-[24px] p-8 shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Informasi Akun</h2>
                <div class="space-y-6">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nama Lengkap</p>
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ auth()->user()->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Email</p>
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ auth()->user()->email }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Nomor Telepon</p>
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ auth()->user()->phone ?? 'Belum diatur' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Status Keanggotaan
                        </p>
                        <p class="text-sm font-bold text-[#FF7304]">{{ auth()->user()->badge }} Member</p>
                    </div>
                </div>
                <div class="mt-10">
                    <a href="/settings"
                        class="block w-full text-center px-6 py-3 border-2 border-orange-100 text-[#FF7304] font-bold rounded-2xl hover:bg-orange-50 dark:hover:bg-[#2A2A2A] transition-all text-sm">Update
                        Profil</a>
                </div>
            </div>

            <!-- Achievement/Badges -->
            <div class="bg-[#FF7304] rounded-[24px] p-8 shadow-lg shadow-orange-100 text-white relative overflow-hidden">
                <i class="fa-solid fa-crown absolute right-[-20px] bottom-[-20px] text-9xl opacity-10"></i>
                <h3 class="font-bold text-lg mb-2 relative">Voyago Elite</h3>
                <p class="text-xs text-white/80 mb-6 relative">Kamu sudah melakukan 12 perjalanan. Kumpulkan 3 lagi
                    untuk Gold Member!</p>
                <div class="w-full bg-white dark:bg-dark-card/20 h-2 rounded-full mb-2 relative transition-colors duration-300">
                    <div class="bg-white dark:bg-dark-card w-[75%] h-full rounded-full transition-colors duration-300"></div>
                </div>
                <p class="text-[10px] text-right font-bold relative">12/15 Trips</p>
            </div>
        </div>

    </div>
    </div>
@endsection