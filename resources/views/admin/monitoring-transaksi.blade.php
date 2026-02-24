@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Hi, Admin Voyago!</h1>
        <p class="text-gray-400 font-medium tracking-tight">Ringkasan performa Voyago bulan ini ✨</p>
    </div>

    <!-- Stats Grid -->
    @php
        $totalPemasukan = $bookings->sum('total_price');
        $totalTerbayar = $bookings->where('payment_status', \App\Enums\PaymentStatus::PAID)->sum('total_price');
        $totalPending = $bookings->count();
        $totalSelesai = $bookings->where('status', \App\Enums\BookingStatus::COMPLETED)->count();
        $totalProses = $bookings->whereIn('status', [\App\Enums\BookingStatus::PENDING, \App\Enums\BookingStatus::CONFIRMED])->count();
        $totalBatal = $bookings->where('status', \App\Enums\BookingStatus::CANCELLED)->count();
    @endphp

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Total Pesanan -->
        <div class="bg-[#FF7304] rounded-[32px] p-7 text-white flex justify-between items-center shadow-xl shadow-orange-100/30 hover:-translate-y-1 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-1">Total Pesanan</p>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-black">{{ $totalPending }}</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-list-check text-xl"></i>
            </div>
        </div>

        <!-- Selesai -->
        <div class="bg-orange-500 rounded-[32px] p-7 text-white flex justify-between items-center shadow-xl shadow-orange-100/30 hover:-translate-y-1 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-1">Selesai</p>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-black">{{ $totalSelesai }}</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-circle-check text-xl"></i>
            </div>
        </div>

        <!-- Dalam Proses -->
        <div class="bg-[#FF7304] rounded-[32px] p-7 text-white flex justify-between items-center shadow-xl shadow-orange-100/30 hover:-translate-y-1 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-1">Dalam Proses</p>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-black">{{ $totalProses }}</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-clock text-xl"></i>
            </div>
        </div>

        <!-- Dibatalkan -->
        <div class="bg-orange-500 rounded-[32px] p-7 text-white flex justify-between items-center shadow-xl shadow-orange-100/30 hover:-translate-y-1 transition-all duration-300">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-80 mb-1">Dibatalkan</p>
                <div class="flex items-center gap-2">
                    <span class="text-3xl font-black">{{ $totalBatal }}</span>
                </div>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                <i class="fa-solid fa-ban text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-[32px] p-10 mb-10 shadow-sm border border-gray-50">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h3 class="text-xl font-black text-gray-800 tracking-tight">Monitoring Semua Mitra</h3>
                <p class="text-xs font-bold text-gray-300 uppercase tracking-widest mt-1">Daftar transaksi real-time dari seluruh layanan</p>
            </div>
        </div>

        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-gray-50 transition-all border border-transparent hover:border-gray-100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-[#FF7304] shadow-sm">
                            @php
                                $icons = [
                                    'kereta' => 'fa-train',
                                    'pesawat' => 'fa-plane',
                                    'bus' => 'fa-bus',
                                    'hotel' => 'fa-hotel',
                                    'wisata' => 'fa-mountain-sun'
                                ];
                            @endphp
                            <i class="fa-solid {{ $icons[$booking->category] ?? 'fa-receipt' }} text-xl"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-black text-gray-800 leading-none mb-1">{{ $booking->user->name }}</h4>
                            <p class="text-[10px] font-black text-[#FF7304] uppercase tracking-widest">{{ $booking->category }} - {{ $booking->booking_code }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-12">
                        <div class="hidden lg:block">
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Mitra Penyedia</p>
                            <p class="text-xs font-bold text-gray-800">{{ $booking->partner->name ?? 'System' }}</p>
                        </div>

                        <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest 
                                    {{ $booking->payment_status === \App\Enums\PaymentStatus::PAID ? 'bg-black text-white' : ($booking->payment_status === \App\Enums\PaymentStatus::PENDING ? 'bg-orange-100 text-[#FF7304]' : 'bg-red-500 text-white') }}">
                            {{ $booking->payment_status === \App\Enums\PaymentStatus::PAID ? 'PAID' : ($booking->status === \App\Enums\BookingStatus::CANCELLED ? 'CANCELLED' : 'UNPAID') }}
                        </span>

                        <div class="text-right min-w-[150px]">
                            <p class="text-sm font-black text-gray-800 leading-none mb-1">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            <p class="text-[10px] font-bold text-gray-300">{{ $booking->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        <!-- Ringkasan Card -->
        <div class="bg-white rounded-[40px] p-8 shadow-sm border border-gray-50">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-xl font-black text-gray-800 tracking-tight">Ringkasan Keuangan</h3>
                    <p class="text-xs font-bold text-gray-300 uppercase tracking-widest mt-1">Total arus kas dari seluruh Mitra Voyago.</p>
                </div>
            </div>

            <div class="bg-[#F8F9FB] rounded-[32px] p-8">
                <div class="grid grid-cols-2 gap-8 mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-[#FF7304]">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Total Nilai Order</p>
                            <p class="text-lg font-black text-gray-800">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm text-green-500">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">Dana Terbayar</p>
                            <p class="text-lg font-black text-gray-800">Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

                <div class="flex items-end justify-between h-40 px-2">
                    <div class="w-8 bg-orange-500 rounded-full h-[40%]"></div>
                    <div class="w-8 bg-orange-200 rounded-full h-[25%]"></div>
                    <div class="w-8 bg-orange-500 rounded-full h-[85%]"></div>
                    <div class="w-8 bg-orange-500 rounded-full h-[75%]"></div>
                    <div class="w-8 bg-orange-200 rounded-full h-[60%]"></div>
                    <div class="w-8 bg-orange-100 rounded-full h-[50%]"></div>
                    <div class="w-8 bg-orange-500 rounded-full h-[100%]"></div>
                    <div class="w-8 bg-orange-200 rounded-full h-[70%]"></div>
                </div>
            </div>
        </div>

        <!-- Aktivitas Card -->
        <div class="bg-white rounded-[40px] p-8 shadow-sm border border-gray-50">
            <div class="mb-8">
                <h3 class="text-xl font-black text-gray-800 tracking-tight">Aktivitas</h3>
                <p class="text-xs font-bold text-gray-300 uppercase tracking-widest mt-1">Lacak Aktivitas Ekonomi Seluruh Mitra.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Transaksi Activity -->
                <div class="bg-gray-50 rounded-[32px] p-6 relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-file-invoice text-sm text-gray-800"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-800">Transaksi Berhasil</span>
                        </div>
                        <p class="text-[10px] font-black text-green-500 mb-1"><i class="fa-solid fa-check"></i> Pesanan Lunas</p>
                        <p class="text-lg font-black text-gray-800">Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Kontribusi Activity -->
                <div class="bg-gray-50 rounded-[32px] p-6 relative overflow-hidden group">
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-fire text-sm text-gray-800"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest text-gray-800">Profit Platform</span>
                        </div>
                        <p class="text-[10px] font-black text-orange-500 mb-1"><i class="fa-solid fa-arrow-up rotate-45"></i> Total Komisi</p>
                        <p class="text-lg font-black text-gray-800">Rp {{ number_format($bookings->where('payment_status', \App\Enums\PaymentStatus::PAID)->sum('commission_amount'), 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Tagihan Activity -->
                <div class="bg-[#3D2305] rounded-[32px] p-6 relative overflow-hidden group">
                    <div class="relative z-10 text-white">
                        <div class="flex items-center gap-2 mb-4">
                            <i class="fa-solid fa-clock text-sm text-white/80"></i>
                            <span class="text-[10px] font-black uppercase tracking-widest text-white/80">Belum Terbayar</span>
                        </div>
                        <p class="text-[10px] font-black text-white/60 mb-1"><i class="fa-solid fa-hourglass-start"></i> Dana Tertunda</p>
                        <p class="text-lg font-black text-white">Rp {{ number_format($totalPemasukan - $totalTerbayar, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection