@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row gap-8 min-h-[600px]">

        <!-- Left Sidebar -->
        <aside class="w-full md:w-80 shrink-0">
            <!-- Mobile Sidebar Toggle -->
            <button onclick="toggleSidebarMenu()"
                class="md:hidden w-full flex items-center justify-between bg-white dark:bg-dark-card rounded-[2rem] p-6 shadow-xl shadow-orange-500/5 border border-gray-100 dark:border-dark-border mb-6 text-gray-800 dark:text-white font-black transition-all hover:border-orange-500 group">
                <span class="flex items-center gap-4">
                    <div
                        class="w-10 h-10 bg-orange-50 dark:bg-orange-500/10 rounded-2xl flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bars-staggered"></i>
                    </div>
                    Menu Akun
                </span>
                <i class="fa-solid fa-chevron-down text-sm transition-transform duration-500" id="sidebar-chevron"></i>
            </button>

            <div id="sidebar-menu"
                class="hidden md:flex bg-white dark:bg-dark-card rounded-[2.5rem] p-4 shadow-xl shadow-orange-500/5 border border-gray-100 dark:border-dark-border flex-col gap-3 transition-all duration-500 sticky top-24">

                <h3 class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Pusat Navigasi
                </h3>

                <button onclick="switchSection('pesanan')" id="btn-pesanan"
                    class="flex items-center gap-4 px-6 py-4 rounded-3xl transition-all group active-nav relative overflow-hidden">
                    <div
                        class="w-10 h-10 rounded-2xl flex items-center justify-center bg-gray-50 dark:bg-[#121212] group-[.active-nav]:bg-white/20 transition-colors shadow-sm">
                        <i class="fa-solid fa-receipt text-lg text-gray-400 group-[.active-nav]:text-white"></i>
                    </div>
                    <span
                        class="font-bold text-sm tracking-tight text-gray-600 dark:text-[#A1A1AA] group-[.active-nav]:text-white">Pesanan
                        Saya</span>
                </button>

                <button onclick="switchSection('wishlist')" id="btn-wishlist"
                    class="flex items-center gap-4 px-6 py-4 rounded-3xl transition-all group relative overflow-hidden">
                    <div
                        class="w-10 h-10 rounded-2xl flex items-center justify-center bg-gray-50 dark:bg-[#121212] group-[.active-nav]:bg-white/20 transition-colors shadow-sm">
                        <i class="fa-solid fa-heart text-lg text-gray-400 group-[.active-nav]:text-white"></i>
                    </div>
                    <span
                        class="font-bold text-sm tracking-tight text-gray-600 dark:text-[#A1A1AA] group-[.active-nav]:text-white">Wishlist</span>
                </button>

                <button onclick="switchSection('komplain')" id="btn-komplain"
                    class="flex items-center gap-4 px-6 py-4 rounded-3xl transition-all group relative overflow-hidden">
                    <div
                        class="w-10 h-10 rounded-2xl flex items-center justify-center bg-gray-50 dark:bg-[#121212] group-[.active-nav]:bg-white/20 transition-colors shadow-sm">
                        <i class="fa-solid fa-headset text-lg text-gray-400 group-[.active-nav]:text-white"></i>
                    </div>
                    <span
                        class="font-bold text-sm tracking-tight text-gray-600 dark:text-[#A1A1AA] group-[.active-nav]:text-white">Komplain</span>
                </button>

                <button onclick="switchSection('pengaturan')" id="btn-pengaturan"
                    class="flex items-center gap-4 px-6 py-4 rounded-3xl transition-all group relative overflow-hidden">
                    <div
                        class="w-10 h-10 rounded-2xl flex items-center justify-center bg-gray-50 dark:bg-[#121212] group-[.active-nav]:bg-white/20 transition-colors shadow-sm">
                        <i class="fa-solid fa-user-gear text-lg text-gray-400 group-[.active-nav]:text-white"></i>
                    </div>
                    <span
                        class="font-bold text-sm tracking-tight text-gray-600 dark:text-[#A1A1AA] group-[.active-nav]:text-white">Pengaturan</span>
                </button>

                <div
                    class="mt-8 mx-4 p-8 bg-gradient-to-br from-orange-500 to-orange-400 rounded-[2rem] text-white hidden md:block relative overflow-hidden shadow-lg shadow-orange-500/20 group hover:scale-[1.02] transition-all duration-500">
                    <div class="relative z-10">
                        <h4 class="font-black text-lg leading-tight mb-2">Jadi Mitra Voyago</h4>
                        <p class="text-[10px] font-bold opacity-80 mb-6 leading-relaxed">Punya bisnis travel? Bergabunglah &
                            kembangkan bersama kami!</p>
                        <a href="{{ route('partner.auth.page') }}"
                            class="block w-full text-center py-3 bg-white dark:bg-dark-card text-orange-500 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl hover:bg-orange-50 dark:hover:bg-[#2A2A2A] transition-all">Daftar
                            Sekarang</a>
                    </div>
                    <i
                        class="fa-solid fa-rocket absolute -right-6 -bottom-6 text-7xl opacity-10 -rotate-12 group-hover:translate-x-2 group-hover:-translate-y-2 transition-transform duration-700"></i>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-grow">

            <!-- Pesanan Saya Content -->
            <div id="section-pesanan" class="dashboard-section animate-in fade-in slide-in-from-bottom-4 duration-500">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-10">
                    <div>
                        <h1 class="text-4xl font-black text-gray-800 dark:text-white tracking-tighter mb-2">Pesanan Saya
                        </h1>
                        <p class="text-sm font-bold text-gray-400">Kelola tiket dan rincian perjalanan Anda</p>
                    </div>
                    <div
                        class="flex items-center gap-2 md:gap-3 bg-white dark:bg-dark-card p-1.5 md:p-2 rounded-2xl md:rounded-3xl border border-gray-100 dark:border-dark-border shadow-sm w-full lg:w-fit overflow-x-auto lg:overflow-visible no-scrollbar">
                        <button onclick="filterStatus('semua')"
                            class="status-tab active-tab px-4 md:px-6 py-2.5 md:py-3 rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest transition-all whitespace-nowrap shrink-0">Semua</button>
                        <button onclick="filterStatus('upcoming')"
                            class="status-tab px-4 md:px-6 py-2.5 md:py-3 rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest transition-all whitespace-nowrap shrink-0">Upcoming</button>
                        <button onclick="filterStatus('selesai')"
                            class="status-tab px-4 md:px-6 py-2.5 md:py-3 rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest transition-all whitespace-nowrap shrink-0">Selesai</button>
                        <button onclick="filterStatus('dibatalkan')"
                            class="status-tab px-4 md:px-6 py-2.5 md:py-3 rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest transition-all whitespace-nowrap shrink-0">Dibatalkan</button>
                    </div>
                </div>

                <!-- Booking Lists -->
                <div class="space-y-4 md:space-y-6" id="booking-list">
                    @forelse($bookings as $booking)
                        <div class="booking-card bg-white dark:bg-dark-card rounded-3xl md:rounded-[3rem] p-5 md:p-8 shadow-xl shadow-orange-500/5 border border-gray-100 dark:border-dark-border flex flex-col xl:flex-row items-center gap-6 md:gap-10 transition-all duration-500 hover:border-orange-200 group relative overflow-hidden"
                            data-status="{{ $booking->status }}">

                            <!-- Premium Background Accent -->
                            <div
                                class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/5 to-transparent -z-10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-1000">
                            </div>

                            <!-- Left Part: Icon & ID -->
                            <div
                                class="flex flex-row xl:flex-col items-center xl:items-start gap-4 md:gap-6 w-full xl:w-56 shrink-0 border-b xl:border-b-0 xl:border-r border-gray-50 dark:border-dark-border pb-4 md:pb-6 xl:pb-0 xl:pr-10">
                                <div
                                    class="w-16 h-16 md:w-20 md:h-20 rounded-2xl md:rounded-[2rem] bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center shrink-0 shadow-inner group-hover:scale-110 transition-transform duration-500">
                                    @if($booking->category == 'kereta')
                                        <i class="fa-solid fa-train text-orange-500 text-2xl md:text-3xl"></i>
                                    @elseif($booking->category == 'pesawat')
                                        <i class="fa-solid fa-plane text-orange-500 text-2xl md:text-3xl"></i>
                                    @elseif($booking->category == 'hotel')
                                        <i class="fa-solid fa-hotel text-orange-500 text-2xl md:text-3xl"></i>
                                    @else
                                        <i class="fa-solid fa-mountain-sun text-orange-500 text-2xl md:text-3xl"></i>
                                    @endif
                                </div>
                                <div class="flex flex-col gap-1 md:gap-2">
                                    <p class="text-[10px] md:text-[12px] font-black text-orange-500 uppercase tracking-[0.1em] md:tracking-[0.2em]">
                                        {{ $booking->booking_code }}
                                    </p>
                                    @php
                                        $statusClass = 'bg-orange-100 text-orange-600';
                                        $statusLabel = 'Upcoming';

                                        if ($booking->status === \App\Enums\BookingStatus::CANCELLED) {
                                            $statusClass = 'bg-red-50 text-red-500';
                                            $statusLabel = 'Dibatalkan';
                                        } elseif ($booking->status === \App\Enums\BookingStatus::COMPLETED) {
                                            $statusClass = 'bg-green-100 text-green-600';
                                            $statusLabel = 'Selesai';
                                        } elseif ($booking->status === \App\Enums\BookingStatus::CONFIRMED) {
                                            $statusClass = 'bg-blue-50 text-blue-500';
                                            $statusLabel = 'Terkonfirmasi';
                                        } elseif ($booking->status === \App\Enums\BookingStatus::REFUNDED) {
                                            $statusClass = 'bg-purple-50 text-purple-400';
                                            $statusLabel = 'Refunded';
                                        } elseif ($booking->payment_status === \App\Enums\PaymentStatus::PENDING) {
                                            $statusClass = 'bg-orange-100 text-orange-600';
                                            $statusLabel = 'Menunggu Bayar';
                                        }
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="px-3 md:px-4 py-1 md:py-1.5 rounded-full text-[8px] md:text-[9px] font-black uppercase tracking-widest text-center whitespace-nowrap {{ $statusClass }} shadow-sm ring-1 ring-inset ring-orange-500/20">{{ $statusLabel }}</span>
                                    </div>
                                    @if($booking->payment_status === \App\Enums\PaymentStatus::PENDING && $booking->snap_token)
                                        <button onclick="continuePayment('{{ $booking->snap_token }}', '{{ $booking->booking_code }}')"
                                            class="mt-1 flex items-center gap-1 md:gap-2 text-[9px] md:text-[10px] font-black text-orange-500 hover:text-orange-600 transition-all uppercase tracking-widest leading-none">
                                            <div class="w-5 h-5 md:w-6 md:h-6 rounded-lg bg-orange-100 flex items-center justify-center">
                                                <i class="fas fa-credit-card text-[8px] md:text-[10px]"></i>
                                            </div>
                                            Bayar
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <!-- Center Part: Main Details -->
                            <div
                                class="flex-grow grid grid-cols-2 md:grid-cols-4 xl:grid-cols-2 2xl:grid-cols-4 gap-4 md:gap-8 w-full py-1 md:py-2">
                                <div>
                                    <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 md:mb-2">Tujuan / Nama
                                    </p>
                                    @php
                                        $itemName = 'Produk Tidak Ditemukan';
                                        if ($booking->item) {
                                            $itemName = $booking->item->name ?? $booking->item->airline_name ?? $booking->item->operator ?? 'Tiket Perjalanan';
                                        }
                                    @endphp
                                    <p class="font-black text-gray-800 dark:text-white text-xs md:text-base leading-tight">{{ $itemName }}
                                    </p>
                                </div>
                                <div class="hidden md:block">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Tanggal Pesan
                                    </p>
                                    <p class="font-bold text-gray-700 dark:text-gray-300 text-base leading-tight">
                                        {{ $booking->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 md:mb-2">Penumpang</p>
                                    <p class="font-bold text-gray-700 dark:text-gray-300 text-xs md:text-base leading-tight">
                                        {{ $booking->passenger_count }} Pax
                                        @if($booking->seats)
                                            <span class="text-orange-500 font-black ml-1">•
                                                {{ implode(', ', $booking->seats) }}</span>
                                        @endif
                                    </p>
                                </div>
                                @if($booking->item && ($booking->item->origin || $booking->item->location))
                                    <div class="col-span-2 md:col-span-1">
                                        <p class="text-[8px] md:text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1 md:mb-2">Detail Rute
                                        </p>
                                        <p class="font-bold text-gray-500 dark:text-[#A1A1AA] text-[10px] md:text-sm leading-relaxed italic">
                                            {{ $booking->item->origin ? $booking->item->origin . ' → ' . $booking->item->destination : $booking->item->location }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Right Part: Price & Actions -->
                            <div
                                class="flex flex-col sm:flex-row xl:flex-col items-center sm:justify-between xl:justify-center gap-6 w-full xl:w-64 shrink-0 border-t xl:border-t-0 xl:border-l border-gray-50 dark:border-dark-border pt-8 xl:pt-0 xl:pl-10">
                                <div class="text-center sm:text-left xl:text-right w-full sm:w-auto xl:w-full">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">Total Bayar
                                    </p>
                                    <p class="font-black text-orange-500 text-2xl tracking-tighter">
                                        <span
                                            class="text-xs font-bold mr-0.5">Rp</span>{{ number_format($booking->total_price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2 w-full sm:w-auto xl:w-full justify-center xl:justify-end">
                                    <!-- Detail Button -->
                                    <button onclick="showOrderDetail({{ json_encode($booking) }})"
                                        class="relative flex-grow sm:flex-grow-0 px-6 h-11 flex items-center justify-center bg-gray-100 dark:bg-white/10 text-gray-700 dark:text-gray-200 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-[#FF7304] hover:text-white border border-transparent shadow-sm transition-all active:scale-95 v-tooltip-btn">
                                        Detail
                                        <span class="v-tooltip">Lihat Detail</span>
                                    </button>

                                    <!-- Action Icons -->
                                    @if($booking->status !== \App\Enums\BookingStatus::CANCELLED && $booking->status !== \App\Enums\BookingStatus::COMPLETED && $booking->status !== \App\Enums\BookingStatus::REFUNDED)
                                        <form action="{{ route('booking.cancel', $booking->id) }}" method="POST"
                                            class="flex items-center m-0"
                                            onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            <button type="submit"
                                                class="relative w-11 h-11 bg-red-50 dark:bg-red-500/20 text-red-500 dark:text-red-400 rounded-2xl flex items-center justify-center hover:bg-red-500 hover:text-white transition-all shadow-sm active:scale-95 v-tooltip-btn">
                                                <i class="fa-solid fa-xmark"></i>
                                                <span class="v-tooltip">Batal</span>
                                            </button>
                                        </form>
                                    @endif

                                    @if($booking->payment_status == \App\Enums\PaymentStatus::PAID)
                                        <button onclick="openComplaintModal({{ $booking->id }}, '{{ $booking->booking_code }}')"
                                            class="relative w-11 h-11 bg-amber-50 dark:bg-amber-500/20 text-amber-600 dark:text-amber-400 rounded-2xl flex items-center justify-center hover:bg-amber-600 hover:text-white transition-all shadow-sm active:scale-95 v-tooltip-btn">
                                            <i class="fa-solid fa-circle-exclamation"></i>
                                            <span class="v-tooltip">Komplain</span>
                                        </button>
                                        <a href="{{ route('booking.ticket', $booking->id) }}"
                                            class="relative w-11 h-11 bg-blue-50 dark:bg-blue-500/20 text-blue-600 dark:text-blue-400 rounded-2xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm active:scale-95 v-tooltip-btn">
                                            <i class="fa-solid fa-cloud-arrow-down"></i>
                                            <span class="v-tooltip">E-Ticket</span>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div
                            class="text-center py-20 bg-white dark:bg-dark-card rounded-[24px] shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                            <div class="w-32 h-32 mx-auto mb-6 bg-orange-50 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-suitcase-rolling text-5xl text-orange-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Belum ada perjalanan nih 😢</h3>
                            <p class="text-gray-500 dark:text-[#A1A1AA] mb-8">Yuk rencanakan liburan pertamamu!</p>
                            <a href="/"
                                class="px-8 py-3 bg-[#FF7304] text-white rounded-full font-bold shadow-lg shadow-orange-200 hover:scale-105 transition-all">Cari
                                Destinasi</a>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Detail Order Modal -->
            <div id="orderModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
                <!-- Backdrop -->
                <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" onclick="closeOrderModal()"></div>

                <!-- Modal Content -->
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[90%] max-w-[340px] animate-in fade-in zoom-in duration-300">
                    <div
                        class="bg-white dark:bg-dark-card rounded-[2.5rem] overflow-hidden shadow-2xl transition-colors duration-300 border border-gray-100 dark:border-dark-border">
                        <!-- Header: Minimal & Clean -->
                        <div
                            class="p-5 flex items-center justify-between border-b border-gray-50 dark:border-dark-border">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-10 h-10 bg-orange-50 dark:bg-orange-500/10 rounded-2xl flex items-center justify-center text-orange-500 transition-colors">
                                    <i class="fa-solid fa-plane text-base" id="modal-product-icon"></i>
                                </div>
                                <div>
                                    <h2 class="text-sm font-black text-gray-800 dark:text-white leading-none"
                                        id="modal-order-code">#VYG-12345678</h2>
                                    <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-1"
                                        id="modal-product-name">Pesawat</p>
                                </div>
                            </div>
                            <button onclick="closeOrderModal()"
                                class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-orange-500 transition-all">
                                <i class="fa-solid fa-xmark text-sm"></i>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="p-5">
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-2xl">
                                    <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                        Payment</p>
                                    <p class="text-[10px] font-black text-orange-500 uppercase"
                                        id="modal-payment-status">PAID</p>
                                </div>
                                <div class="p-3 bg-gray-50 dark:bg-white/5 rounded-2xl">
                                    <p class="text-[8px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                        Date</p>
                                    <p class="text-[10px] font-black text-gray-800 dark:text-white"
                                        id="modal-order-date">08 Apr 2026</p>
                                </div>
                            </div>

                            <div class="px-1 mb-5 space-y-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Travel
                                        Status</span>
                                    <span class="text-[10px] font-black text-gray-800 dark:text-white capitalize"
                                        id="modal-travel-status">Upcoming</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Passenger</span>
                                    <span class="text-[10px] font-black text-gray-800 dark:text-white"
                                        id="modal-passenger-count">1 Pax</span>
                                </div>
                                <div
                                    class="flex justify-between items-center border-t border-gray-100 dark:border-dark-border pt-3 mt-3">
                                    <span
                                        class="text-[10px] font-black text-gray-800 dark:text-white uppercase">Total
                                        Price</span>
                                    <span class="text-sm font-black text-orange-500" id="modal-total-price">Rp 0</span>
                                </div>
                            </div>

                            <!-- Compact QR Section -->
                            <div id="modal-qr-section"
                                class="py-4 border-t border-dashed border-gray-100 dark:border-dark-border flex flex-col items-center">
                                <div class="relative bg-white p-2 rounded-2xl shadow-sm mb-3">
                                    <img id="modal-qr-code" src="" alt="QR" class="w-24 h-24 grayscale">
                                </div>
                                <p class="text-[8px] font-black text-gray-400 uppercase tracking-[0.2em]">Scan QR
                                    for Check-in</p>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 flex gap-3">
                                <a id="modal-ticket-download" href="#"
                                    class="w-12 h-12 flex items-center justify-center bg-gray-50 dark:bg-white/5 text-gray-400 hover:text-orange-500 rounded-2xl transition-all border border-gray-100 dark:border-dark-border">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                <button onclick="closeOrderModal()"
                                    class="flex-1 bg-zinc-900 text-white rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-orange-500 transition-all shadow-lg active:scale-95">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                @keyframes scan {
                    0% {
                        top: 0;
                        opacity: 0;
                    }

                    50% {
                        opacity: 1;
                    }

                    100% {
                        top: 100%;
                        opacity: 0;
                    }
                }

                .animate-scan {
                    position: absolute;
                    animation: scan 2s linear infinite;
                }
            </style>

            <!-- Wishlist Content -->
            <div id="section-wishlist" class="dashboard-section hidden">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">Wishlist Saya</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Sample Wishlist Card -->
                    <div
                        class="bg-white dark:bg-dark-card rounded-[24px] overflow-hidden shadow-sm border border-gray-100 dark:border-dark-border group hover:-translate-y-2 hover:shadow-xl transition-all duration-300 transition-colors duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=400"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <button
                                class="absolute top-4 right-4 w-10 h-10 bg-white dark:bg-dark-card rounded-full shadow-md flex items-center justify-center text-[#FF7304] transition-colors duration-300">
                                <i class="fa-solid fa-heart text-xl"></i>
                            </button>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-1 mb-2">
                                <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                <span class="text-xs font-bold text-gray-600 dark:text-[#A1A1AA]">4.8</span>
                            </div>
                            <h3 class="font-bold text-gray-800 dark:text-white mb-1">Bali, Indonesia</h3>
                            <p class="text-xs text-gray-400 mb-4 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot"></i> Indonesia
                            </p>
                            <div class="flex items-center justify-between mt-4">
                                <div>
                                    <p class="text-[10px] text-gray-400">Mulai dari</p>
                                    <p class="font-bold text-[#FF7304]">Rp 1.500.000</p>
                                </div>
                                <button
                                    class="bg-orange-50 text-[#FF7304] px-4 py-2 rounded-full text-xs font-bold hover:bg-[#FF7304] hover:text-white transition-all">Cek
                                    Detail</button>
                            </div>
                        </div>
                    </div>

                    <!-- More sample cards or empty state -->
                    <div
                        class="bg-white dark:bg-dark-card rounded-[24px] overflow-hidden shadow-sm border border-gray-100 dark:border-dark-border group hover:-translate-y-2 hover:shadow-xl transition-all duration-300 transition-colors duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?auto=format&fit=crop&w=400"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <button
                                class="absolute top-4 right-4 w-10 h-10 bg-white dark:bg-dark-card rounded-full shadow-md flex items-center justify-center text-[#FF7304] transition-colors duration-300">
                                <i class="fa-solid fa-heart text-xl"></i>
                            </button>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-1 mb-2">
                                <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                <span class="text-xs font-bold text-gray-600 dark:text-[#A1A1AA]">4.9</span>
                            </div>
                            <h3 class="font-bold text-gray-800 dark:text-white mb-1">Kyoto, Japan</h3>
                            <p class="text-xs text-gray-400 mb-4 flex items-center gap-1">
                                <i class="fa-solid fa-location-dot"></i> Japan
                            </p>
                            <div class="flex items-center justify-between mt-4">
                                <div>
                                    <p class="text-[10px] text-gray-400">Mulai dari</p>
                                    <p class="font-bold text-[#FF7304]">Rp 8.500.000</p>
                                </div>
                                <button
                                    class="bg-orange-50 text-[#FF7304] px-4 py-2 rounded-full text-xs font-bold hover:bg-[#FF7304] hover:text-white transition-all">Cek
                                    Detail</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty Wishlist -->
                <div id="wishlist-empty"
                    class="hidden text-center py-20 bg-white dark:bg-dark-card rounded-[24px] shadow-sm border border-gray-100 dark:border-dark-border mt-6 transition-colors duration-300">
                    <div class="w-32 h-32 mx-auto mb-6 bg-orange-50 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-heart-crack text-5xl text-orange-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Belum ada destinasi favorit</h3>
                    <p class="text-gray-500 dark:text-[#A1A1AA] mb-8">Simpan dulu biar nggak lupa!</p>
                    <a href="/"
                        class="px-8 py-3 bg-[#FF7304] text-white rounded-full font-bold shadow-lg shadow-orange-200 hover:scale-105 transition-all">Eksplor
                        Sekarang</a>
                </div>
            </div>

            <!-- Komplain Content -->
            <div id="section-komplain" class="dashboard-section hidden">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                    <h1 class="text-3xl md:text-4xl font-black text-gray-800 dark:text-white tracking-tighter">Komplain Saya</h1>
                    <p class="text-[9px] md:text-xs font-black text-gray-400 uppercase tracking-widest bg-gray-50 dark:bg-white/5 px-4 py-2 rounded-full border border-gray-100 dark:border-dark-border w-fit">Pusat Bantuan & Resolusi</p>
                </div>

                <div class="space-y-6">
                    @php
                        $userComplaints = \App\Models\Complaint::where('user_id', auth()->id())->with('booking')->latest()->get();
                    @endphp

                    @forelse($userComplaints as $complaint)
                        <div
                            class="bg-white dark:bg-dark-card rounded-3xl md:rounded-[24px] p-5 md:p-6 shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-5">
                                <div class="flex flex-wrap items-center gap-2 md:gap-3">
                                    <span
                                        class="px-3 py-1 bg-orange-50 dark:bg-orange-500/10 text-[#FF7304] rounded-full text-[9px] font-black uppercase tracking-widest border border-orange-100 dark:border-orange-500/20">
                                        {{ $complaint->booking->booking_code }}
                                    </span>
                                    <h4 class="font-black text-gray-800 dark:text-white text-xs md:text-sm tracking-tight">{{ $complaint->subject }}</h4>
                                </div>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-gray-100 dark:bg-dark-border text-gray-500 dark:text-[#A1A1AA] border-gray-200',
                                        'in_progress' => 'bg-blue-50 text-blue-500 border-blue-100',
                                        'resolved' => 'bg-green-50 text-green-500 border-green-100',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest w-fit border {{ $statusColors[$complaint->status] ?? 'bg-gray-100 dark:bg-dark-border' }}">
                                    {{ str_replace('_', ' ', $complaint->status) }}
                                </span>
                            </div>
                            <p class="text-xs md:text-sm font-medium text-gray-500 dark:text-[#A1A1AA] mb-5 leading-relaxed bg-gray-50 dark:bg-white/5 p-4 rounded-2xl">{{ $complaint->description }}</p>
                            @if($complaint->admin_response)
                                <div class="bg-orange-50 dark:bg-orange-500/10 rounded-2xl p-4 border-l-4 border-orange-400 mb-3 shadow-sm">
                                    <p class="text-[9px] font-black text-orange-400 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                                        <i class="fa-solid fa-user-shield"></i> Respon Admin
                                    </p>
                                    <p class="text-xs md:text-sm text-gray-700 dark:text-gray-300 italic font-medium">"{{ $complaint->admin_response }}"
                                    </p>
                                </div>
                            @endif
 
                            @if($complaint->mitra_response)
                                <div class="bg-emerald-50 dark:bg-emerald-500/10 rounded-2xl p-4 border-l-4 border-emerald-400 shadow-sm">
                                    <p class="text-[9px] font-black text-emerald-500 uppercase tracking-widest mb-1.5 flex items-center gap-2">
                                        <i class="fa-solid fa-shop"></i> Respon Mitra
                                    </p>
                                    <p class="text-xs md:text-sm text-gray-700 dark:text-gray-300 italic font-medium">"{{ $complaint->mitra_response }}"
                                    </p>
                                </div>
                            @endif

                            <div class="mt-4 text-[10px] text-gray-300 font-bold uppercase tracking-widest">
                                Dikirim pada {{ $complaint->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    @empty
                        <div
                            class="text-center py-20 bg-white dark:bg-dark-card rounded-[24px] shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                            <div
                                class="w-24 h-24 mx-auto mb-6 bg-gray-50 dark:bg-[#121212] rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-comments text-3xl text-gray-200"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-1">Belum ada komplain</h3>
                            <p class="text-xs text-gray-400">Hubungi kami jika Anda mengalami kendala pada pesanan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Settings Content -->
            <div id="section-pengaturan" class="dashboard-section hidden">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">Pengaturan Akun</h1>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="bg-white dark:bg-dark-card rounded-[24px] p-8 shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                    @csrf
                    <div class="flex items-center gap-6 mb-8">
                        <div class="relative group">
                            <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : '/images/Avatarprof.jpeg' }}"
                                id="avatar-preview"
                                class="w-24 h-24 rounded-full object-cover border-4 border-orange-50 shadow-md">
                            <label for="avatar-input"
                                class="absolute bottom-0 right-0 w-8 h-8 bg-[#FF7304] text-white rounded-full flex items-center justify-center border-2 border-white shadow-md cursor-pointer hover:scale-110 transition-all">
                                <i class="fa-solid fa-camera text-xs"></i>
                                <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*"
                                    onchange="previewImage(this)">
                            </label>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ auth()->user()->name }}</h2>
                            <p class="text-gray-500 dark:text-[#A1A1AA]">{{ auth()->user()->email }}</p>
                            <span
                                class="mt-2 inline-block px-3 py-1 bg-green-100 text-green-600 rounded-full text-[10px] font-bold">Verified
                                Member</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}" required
                                    class="w-full bg-[#FFFFFF] dark:bg-dark-card border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-gray-700 dark:text-gray-300">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                    class="w-full bg-[#FFFFFF] dark:bg-dark-card border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-gray-700 dark:text-gray-300">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                    placeholder="+62 8xx xxxx xxxx"
                                    class="w-full bg-[#FFFFFF] dark:bg-dark-card border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-gray-700 dark:text-gray-300">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Alamat</label>
                                <input type="text" name="address" value="{{ auth()->user()->address ?? '' }}"
                                    placeholder="Masukkan alamat Anda"
                                    class="w-full bg-[#FFFFFF] dark:bg-dark-card border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-gray-700 dark:text-gray-300">
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end">
                        <button type="submit"
                            class="px-8 py-3 bg-[#FF7304] text-white rounded-full font-bold shadow-lg shadow-orange-200 hover:scale-105 transition-all active:scale-95">Simpan
                            Perubahan</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <style>
        .active-nav {
            background: linear-gradient(135deg, #FF7304, #FFAC63) !important;
            box-shadow: 0 10px 20px -5px rgba(255, 115, 4, 0.4);
        }

        .active-nav span {
            color: white !important;
        }

        .active-nav i {
            color: white !important;
        }

        .status-tab.active-tab {
            background-color: #FF7304 !important;
            color: white !important;
            box-shadow: 0 8px 16px -4px rgba(255, 115, 4, 0.3);
        }

        .status-tab:not(.active-tab):hover {
            background-color: rgba(255, 115, 4, 0.05);
            color: #FF7304 !important;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #2d2d2d;
        }

        /* Premium Tooltip */
        .v-tooltip {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            bottom: calc(100% + 12px);
            left: 50%;
            transform: translateX(-50%) translateY(10px);
            padding: 8px 14px;
            background: #18181b;
            color: white;
            font-size: 9px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            border-radius: 12px;
            white-space: nowrap;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.2);
            z-index: 100;
            pointer-events: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .v-tooltip::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 6px solid transparent;
            border-top-color: #18181b;
        }

        .v-tooltip-btn:hover .v-tooltip {
            visibility: visible;
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }
    </style>

    <!-- Complaint Modal -->
    <div id="complaintModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeComplaintModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white dark:bg-dark-card rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden relative transition-colors duration-300"
                onclick="event.stopPropagation()">
                <div class="bg-gradient-to-r from-red-500 to-red-400 p-6 text-white">
                    <h3 class="text-xl font-bold">Ajukan Komplain</h3>
                    <p class="text-xs opacity-80">Sampaikan keluhan Anda terkait pesanan <span id="complaint-order-code"
                            class="font-black"></span></p>
                </div>

                <form action="{{ route('complaint.store') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <input type="hidden" name="booking_id" id="complaint-booking-id">

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Kategori
                            Komplain</label>
                        <select name="category" required
                            class="w-full bg-gray-50 dark:bg-[#121212] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-red-500 outline-none text-sm font-medium">
                            <option value="">Pilih Kategori</option>
                            <option value="layanan">Layanan Tidak Memuaskan</option>
                            <option value="fasilitas">Fasilitas Bermasalah</option>
                            <option value="pembayaran">Masalah Pembayaran</option>
                            <option value="refund">Permintaan Refund</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Subyek /
                            Judul</label>
                        <input type="text" name="subject" placeholder="Contoh: AC Kamar Tidak Dingin" required
                            class="w-full bg-gray-50 dark:bg-[#121212] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-red-500 outline-none text-sm font-medium">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi
                            Keluhan</label>
                        <textarea name="description" rows="4" placeholder="Jelaskan detail keluhan Anda..." required
                            class="w-full bg-gray-50 dark:bg-[#121212] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-red-500 outline-none text-sm font-medium resize-none"></textarea>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button" onclick="closeComplaintModal()"
                            class="flex-1 px-6 py-4 border-2 border-gray-100 dark:border-dark-border text-gray-400 font-bold rounded-2xl hover:bg-gray-50 dark:bg-[#121212] transition-all text-sm">Batal</button>
                        <button type="submit"
                            class="flex-1 px-6 py-4 bg-red-500 text-white font-bold rounded-2xl shadow-lg shadow-red-100 hover:scale-105 transition-all text-sm">Kirim
                            Komplain</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openComplaintModal(bookingId, bookingCode) {
            document.getElementById('complaint-booking-id').value = bookingId;
            document.getElementById('complaint-order-code').innerText = '#' + bookingCode;
            document.getElementById('complaintModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeComplaintModal() {
            document.getElementById('complaintModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function switchSection(tabId) {
            // Update Sidebar
            document.querySelectorAll('aside button.group').forEach(btn => {
                btn.classList.remove('active-nav');
            });
            document.getElementById('btn-' + tabId).classList.add('active-nav');

            // Update Sections
            document.querySelectorAll('.dashboard-section').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById('section-' + tabId).classList.remove('hidden');

            // Close mobile sidebar menu if it's open
            if (window.innerWidth < 768) {
                const sidebarMenu = document.getElementById('sidebar-menu');
                if (!sidebarMenu.classList.contains('hidden')) {
                    toggleSidebarMenu();
                }
            }
        }

        function toggleSidebarMenu() {
            const menu = document.getElementById('sidebar-menu');
            const chevron = document.getElementById('sidebar-chevron');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                menu.classList.add('flex');
                chevron.classList.add('rotate-180');
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('flex');
                chevron.classList.remove('rotate-180');
            }
        }

        function filterStatus(status) {
            // Update tabs
            document.querySelectorAll('.status-tab').forEach(tab => {
                tab.classList.remove('active-tab');
            });
            event.target.classList.add('active-tab');

            // Filter cards
            const cards = document.querySelectorAll('.booking-card');
            let count = 0;

            cards.forEach(card => {
                const cardStatus = card.getAttribute('data-status').toLowerCase();
                if (status === 'semua') {
                    card.classList.remove('hidden');
                    count++;
                } else if (status === 'upcoming' && (cardStatus === 'pending' || cardStatus === 'confirmed')) {
                    card.classList.remove('hidden');
                    count++;
                } else if (status === 'selesai' && cardStatus === 'completed') {
                    card.classList.remove('hidden');
                    count++;
                } else if (status === 'dibatalkan' && (cardStatus === 'cancelled' || cardStatus === 'refunded')) {
                    card.classList.remove('hidden');
                    count++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Toggle Empty state if count is 0
            // (Simplified logic for demo)
        }

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

            // QR Code Generation
            const qrImg = document.getElementById('modal-qr-code');
            const qrSection = document.getElementById('modal-qr-section');
            const downloadBtn = document.getElementById('modal-ticket-download');

            if (booking.payment_status === 'paid' || booking.status === 'confirmed') {
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

        function continuePayment(snapToken, bookingCode) {
            window.snap.pay(snapToken, {
                onSuccess: async function (result) {
                    try {
                        await fetch('{{ route('simulate.payment') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ booking_code: bookingCode })
                        });
                    } catch (e) {
                        console.error('Failed to sync payment status with server', e);
                    }
                    window.location.reload();
                },
                onPending: function (result) {
                    window.location.reload();
                },
                onError: function (result) {
                    alert("Pembayaran Gagal!");
                    console.log(result);
                },
                onClose: function () {
                    alert('Anda menutup popup pembayaran sebelum menyelesaikan pembayaran.');
                }
            });
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('avatar-preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
@endsection