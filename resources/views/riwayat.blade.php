@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row gap-8 min-h-[600px]">

        <!-- Left Sidebar -->
        <aside class="w-full md:w-64 shrink-0">
            <div
                class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex md:flex-col gap-2 overflow-x-auto md:overflow-x-visible">
                <button onclick="switchTab('pesanan')" id="btn-pesanan"
                    class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group active-nav">
                    <i class="fa-solid fa-receipt text-lg group-[.active-nav]:text-white text-gray-400"></i>
                    <span class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Pesanan
                        Saya</span>
                </button>
                <button onclick="switchTab('wishlist')" id="btn-wishlist"
                    class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group">
                    <i class="fa-solid fa-heart text-lg group-[.active-nav]:text-white text-gray-400"></i>
                    <span
                        class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Wishlist</span>
                </button>
                <button onclick="switchTab('komplain')" id="btn-komplain"
                    class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group">
                    <i class="fa-solid fa-headset text-lg group-[.active-nav]:text-white text-gray-400"></i>
                    <span
                        class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Komplain</span>
                </button>
                <button onclick="switchTab('pengaturan')" id="btn-pengaturan"
                    class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group">
                    <i class="fa-solid fa-user-gear text-lg group-[.active-nav]:text-white text-gray-400"></i>
                    <span
                        class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Pengaturan</span>
                </button>

                <div
                    class="mt-6 p-6 bg-gradient-to-br from-[#FF7304] to-[#FFAC63] rounded-[24px] text-white hidden md:block">
                    <h4 class="font-bold mb-2">Jadi Mitra Voyago</h4>
                    <p class="text-[10px] opacity-90 mb-4">Punya bisni travel? Bergabunglah dengan kami!</p>
                    <a href="{{ route('partner.auth.page') }}"
                        class="block text-center py-2 bg-white text-[#FF7304] rounded-full text-xs font-bold shadow-md hover:scale-105 transition-all">Daftar
                        Sekarang</a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-grow">

            <!-- Pesanan Saya Content -->
            <div id="section-pesanan" class="dashboard-section">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold text-gray-800">Pesanan Saya</h1>
                </div>

                <!-- Tabs -->
                <div class="flex items-center gap-8 border-b border-gray-200 mb-8 overflow-x-auto">
                    <button onclick="filterStatus('semua')"
                        class="status-tab active-tab pb-3 font-semibold text-gray-500 hover:text-[#FF7304] transition-all relative">Semua</button>
                    <button onclick="filterStatus('upcoming')"
                        class="status-tab pb-3 font-semibold text-gray-500 hover:text-[#FF7304] transition-all relative">Upcoming</button>
                    <button onclick="filterStatus('selesai')"
                        class="status-tab pb-3 font-semibold text-gray-500 hover:text-[#FF7304] transition-all relative">Selesai</button>
                    <button onclick="filterStatus('dibatalkan')"
                        class="status-tab pb-3 font-semibold text-gray-500 hover:text-[#FF7304] transition-all relative">Dibatalkan</button>
                </div>

                <!-- Booking Lists -->
                <div class="space-y-4" id="booking-list">
                    @forelse($bookings as $booking)
                        <div class="booking-card bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex flex-col lg:flex-row items-center gap-6"
                            data-status="{{ $booking->payment_status }}">
                            <!-- Left Part -->
                            <div class="flex items-center gap-4 w-full lg:w-1/4">
                                <div class="w-14 h-14 rounded-[18px] bg-orange-50 flex items-center justify-center shrink-0">
                                    @if($booking->category == 'kereta')
                                        <i class="fa-solid fa-train text-[#FF7304] text-xl"></i>
                                    @elseif($booking->category == 'pesawat')
                                        <i class="fa-solid fa-plane text-[#FF7304] text-xl"></i>
                                    @elseif($booking->category == 'hotel')
                                        <i class="fa-solid fa-hotel text-[#FF7304] text-xl"></i>
                                    @else
                                        <i class="fa-solid fa-mountain-sun text-[#FF7304] text-xl"></i>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[12px] font-bold text-[#FF7304] uppercase tracking-wider mb-1">
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
                                            $statusClass = 'bg-blue-100 text-blue-600';
                                            $statusLabel = 'Terkonfirmasi';
                                        } elseif ($booking->payment_status === \App\Enums\PaymentStatus::PENDING) {
                                            $statusClass = 'bg-orange-100 text-orange-600';
                                            $statusLabel = 'Menunggu Bayar';
                                        }
                                    @endphp
                                    <span
                                        class="px-3 py-1 rounded-full text-[10px] font-bold {{ $statusClass }}">{{ $statusLabel }}</span>
                                </div>
                            </div>

                            <!-- Center Part -->
                            <div class="flex-grow grid grid-cols-2 md:grid-cols-3 gap-4 w-full">
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">Tujuan / Nama</p>
                                    <p class="font-bold text-gray-700 text-sm">Destinasi Populer</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">Tanggal Keberangkatan</p>
                                    <p class="font-bold text-gray-700 text-sm">{{ $booking->created_at->format('d M Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">Penumpang</p>
                                    <p class="font-bold text-gray-700 text-sm">{{ $booking->passenger_count }} Penumpang</p>
                                </div>
                            </div>

                            <!-- Right Part -->
                            <div class="flex flex-col items-end gap-3 w-full lg:w-auto">
                                <p class="font-bold text-[#FF7304] text-lg">Rp
                                    {{ number_format($booking->total_price, 0, ',', '.') }}
                                </p>
                                <div class="flex gap-2 w-full lg:w-auto">
                                    <button onclick="showOrderDetail({{ json_encode($booking) }})"
                                        class="flex-grow lg:flex-grow-0 px-4 py-2 border-2 border-[#FF7304] text-[#FF7304] rounded-full font-bold text-xs hover:bg-[#FF7304] hover:text-white transition-all">Lihat
                                        Detail</button>
                                    @if($booking->payment_status == \App\Enums\PaymentStatus::PAID)
                                        <button onclick="openComplaintModal({{ $booking->id }}, '{{ $booking->booking_code }}')"
                                            class="flex-grow lg:flex-grow-0 px-4 py-2 bg-red-50 text-red-500 rounded-full font-bold text-xs hover:bg-red-500 hover:text-white transition-all flex items-center justify-center gap-2">
                                            <i class="fa-solid fa-circle-exclamation"></i> Komplain
                                        </button>
                                        <button
                                            class="p-2 border-2 border-[#FF7304] text-[#FF7304] rounded-full hover:bg-[#FF7304] hover:text-white transition-all">
                                            <i class="fa-solid fa-download"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-white rounded-[24px] shadow-sm border border-gray-100">
                            <div class="w-32 h-32 mx-auto mb-6 bg-orange-50 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-suitcase-rolling text-5xl text-orange-300"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada perjalanan nih 😢</h3>
                            <p class="text-gray-500 mb-8">Yuk rencanakan liburan pertamamu!</p>
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
                <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm" onclick="closeOrderModal()"></div>

                <!-- Modal Content -->
                <div
                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-xl animate-in fade-in zoom-in duration-300">
                    <div class="bg-white rounded-[2rem] overflow-hidden shadow-2xl mx-4 md:mx-0">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-[#FF7304] to-[#FFAC63] p-8 text-white relative">
                            <button onclick="closeOrderModal()"
                                class="absolute top-6 right-6 text-white/50 hover:text-white transition-all">
                                <i class="fa-solid fa-xmark text-xl"></i>
                            </button>
                            <h3 class="text-xs font-black uppercase tracking-[0.2em] mb-2 text-white/70">Order Details</h3>
                            <h2 class="text-3xl font-black" id="modal-order-code">#VYG-12345678</h2>
                        </div>

                        <!-- Body -->
                        <div class="p-6 md:p-10">
                            <div class="grid grid-cols-2 gap-8 mb-10">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Tipe
                                        Pesanan</p>
                                    <p class="font-bold text-gray-800 text-lg mb-1 capitalize" id="modal-product-name">
                                        Pesawat</p>
                                    <p class="text-xs text-[#FF7304] uppercase font-bold" id="modal-payment-status">Paid</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Waktu
                                        Pemesanan</p>
                                    <p class="font-bold text-gray-800" id="modal-order-date">23 Feb 2026</p>
                                    <p class="text-xs text-gray-400" id="modal-order-time">11:18</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 rounded-3xl p-6 mb-10">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-[#FF7304] shadow-sm">
                                            <i class="fa-solid fa-plane text-xl" id="modal-product-icon"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                                Status Perjalanan</p>
                                            <h4 class="font-black text-gray-800 text-lg capitalize"
                                                id="modal-travel-status">Upcoming</h4>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1">
                                            Jumlah</p>
                                        <p class="font-black text-gray-800 text-xl" id="modal-passenger-count">2 Pax</p>
                                    </div>
                                </div>

                                <div class="h-px bg-gray-200/50 mb-6"></div>

                                <div class="space-y-4">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500 font-bold">Harga Satuan</span>
                                        <span class="font-bold text-gray-800" id="modal-unit-price">Rp 0</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-gray-500 font-bold">Metode Pembayaran</span>
                                        <span class="font-bold text-[#FF7304] uppercase tracking-wider"
                                            id="modal-payment-method">Transfer Bank</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2">
                                        <span class="text-gray-800 font-black uppercase text-xs tracking-widest">Total
                                            Bayar</span>
                                        <span class="text-2xl font-black text-[#FF7304]" id="modal-total-price">Rp 0</span>
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

            <!-- Wishlist Content -->
            <div id="section-wishlist" class="dashboard-section hidden">
                <h1 class="text-2xl font-bold text-gray-800 mb-8">Wishlist Saya</h1>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Sample Wishlist Card -->
                    <div
                        class="bg-white rounded-[24px] overflow-hidden shadow-sm border border-gray-100 group hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?auto=format&fit=crop&w=400"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <button
                                class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-[#FF7304]">
                                <i class="fa-solid fa-heart text-xl"></i>
                            </button>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-1 mb-2">
                                <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                <span class="text-xs font-bold text-gray-600">4.8</span>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">Bali, Indonesia</h3>
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
                        class="bg-white rounded-[24px] overflow-hidden shadow-sm border border-gray-100 group hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
                        <div class="relative h-48 overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?auto=format&fit=crop&w=400"
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <button
                                class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full shadow-md flex items-center justify-center text-[#FF7304]">
                                <i class="fa-solid fa-heart text-xl"></i>
                            </button>
                        </div>
                        <div class="p-5">
                            <div class="flex items-center gap-1 mb-2">
                                <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                <span class="text-xs font-bold text-gray-600">4.9</span>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-1">Kyoto, Japan</h3>
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
                    class="hidden text-center py-20 bg-white rounded-[24px] shadow-sm border border-gray-100 mt-6">
                    <div class="w-32 h-32 mx-auto mb-6 bg-orange-50 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-heart-crack text-5xl text-orange-300"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Belum ada destinasi favorit</h3>
                    <p class="text-gray-500 mb-8">Simpan dulu biar nggak lupa!</p>
                    <a href="/"
                        class="px-8 py-3 bg-[#FF7304] text-white rounded-full font-bold shadow-lg shadow-orange-200 hover:scale-105 transition-all">Eksplor
                        Sekarang</a>
                </div>
            </div>

            <!-- Komplain Content -->
            <div id="section-komplain" class="dashboard-section hidden">
                <div class="flex items-center justify-between mb-8">
                    <h1 class="text-2xl font-bold text-gray-800">Komplain Saya</h1>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Pusat Bantuan & Resolusi</p>
                </div>

                <div class="space-y-6">
                    @php
                        $userComplaints = \App\Models\Complaint::where('user_id', auth()->id())->with('booking')->latest()->get();
                    @endphp

                    @forelse($userComplaints as $complaint)
                        <div class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="px-3 py-1 bg-orange-50 text-[#FF7304] rounded-full text-[10px] font-black uppercase tracking-widest">
                                        {{ $complaint->booking->booking_code }}
                                    </span>
                                    <h4 class="font-bold text-gray-800 text-sm">{{ $complaint->subject }}</h4>
                                </div>
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-gray-100 text-gray-500',
                                        'in_progress' => 'bg-blue-50 text-blue-500',
                                        'resolved' => 'bg-green-50 text-green-500',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $statusColors[$complaint->status] ?? 'bg-gray-100' }}">
                                    {{ str_replace('_', ' ', $complaint->status) }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mb-4">{{ $complaint->description }}</p>

                            @if($complaint->admin_response)
                                <div class="bg-gray-50 rounded-2xl p-4 border-l-4 border-orange-400">
                                    <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest mb-1">Respon Admin
                                    </p>
                                    <p class="text-sm text-gray-700 italic">"{{ $complaint->admin_response }}"</p>
                                </div>
                            @endif
                            <div class="mt-4 text-[10px] text-gray-300 font-bold uppercase tracking-widest">
                                Dikirim pada {{ $complaint->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-white rounded-[24px] shadow-sm border border-gray-100">
                            <div class="w-24 h-24 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-comments text-3xl text-gray-200"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-800 mb-1">Belum ada komplain</h3>
                            <p class="text-xs text-gray-400">Hubungi kami jika Anda mengalami kendala pada pesanan.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Settings Content -->
            <div id="section-pengaturan" class="dashboard-section hidden">
                <h1 class="text-2xl font-bold text-gray-800 mb-8">Pengaturan Akun</h1>
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data"
                    class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100">
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
                            <h2 class="text-xl font-bold text-gray-800">{{ auth()->user()->name }}</h2>
                            <p class="text-gray-500">{{ auth()->user()->email }}</p>
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
                                    class="w-full bg-[#F5F5F5] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-gray-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Email</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}" required
                                    class="w-full bg-[#F5F5F5] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-gray-700">
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Nomor Telepon</label>
                                <input type="text" name="phone" value="{{ auth()->user()->phone ?? '' }}"
                                    placeholder="+62 8xx xxxx xxxx"
                                    class="w-full bg-[#F5F5F5] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-gray-700">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Alamat</label>
                                <input type="text" name="address" value="{{ auth()->user()->address ?? '' }}"
                                    placeholder="Masukkan alamat Anda"
                                    class="w-full bg-[#F5F5F5] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-gray-700">
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
            background-color: #FF7304 !important;
        }

        .active-nav span {
            color: white !important;
        }

        .active-nav i {
            color: white !important;
        }

        .active-tab {
            color: #FF7304 !important;
        }

        .active-tab::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #FF7304;
            border-radius: 10px;
        }

        .hidden {
            display: none !important;
        }
    </style>

    <!-- Complaint Modal -->
    <div id="complaintModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeComplaintModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden relative"
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
                            class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-red-500 outline-none text-sm font-medium">
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
                            class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-red-500 outline-none text-sm font-medium">
                    </div>

                    <div>
                        <label
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi
                            Keluhan</label>
                        <textarea name="description" rows="4" placeholder="Jelaskan detail keluhan Anda..." required
                            class="w-full bg-gray-50 border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-red-500 outline-none text-sm font-medium resize-none"></textarea>
                    </div>

                    <div class="pt-4 flex gap-4">
                        <button type="button" onclick="closeComplaintModal()"
                            class="flex-1 px-6 py-4 border-2 border-gray-100 text-gray-400 font-bold rounded-2xl hover:bg-gray-50 transition-all text-sm">Batal</button>
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
            document.querySelectorAll('aside button').forEach(btn => {
                btn.classList.remove('active-nav');
            });
            document.getElementById('btn-' + tabId).classList.add('active-nav');

            // Update Sections
            document.querySelectorAll('.dashboard-section').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById('section-' + tabId).classList.remove('hidden');
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
                const cardStatus = card.getAttribute('data-status');
                if (status === 'semua') {
                    card.classList.remove('hidden');
                    count++;
                } else if (status === 'upcoming' && (cardStatus === 'pending' || cardStatus === 'paid')) {
                    card.classList.remove('hidden');
                    count++;
                } else if (status === 'selesai' && cardStatus === 'completed') {
                    card.classList.remove('hidden');
                    count++;
                } else if (status === 'dibatalkan' && cardStatus === 'cancelled') {
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