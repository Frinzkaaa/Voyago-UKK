@extends('admin.layout')

@section('content')
    <div class="mb-6 lg:mb-10 px-2 lg:px-0">
        <h1 class="text-2xl lg:text-3xl font-black text-gray-800 dark:text-white tracking-tight leading-none mb-2 uppercase">Monitoring Transaksi</h1>
        <p class="text-xs lg:text-sm text-gray-400 dark:text-gray-500 font-medium tracking-tight">Performa Voyago real-time ✨</p>
    </div>

    @php
        $totalPemasukan = $bookings->sum('total_price');
        $totalTerbayar = $bookings->where('payment_status', \App\Enums\PaymentStatus::PAID)->sum('total_price');
        $totalPending = $bookings->count();
        $totalSelesai = $bookings->where('status', \App\Enums\BookingStatus::COMPLETED)->count();
        $totalProses = $bookings->whereIn('status', [\App\Enums\BookingStatus::PENDING, \App\Enums\BookingStatus::CONFIRMED])->count();
        $totalBatal = $bookings->where('status', \App\Enums\BookingStatus::CANCELLED)->count();
    @endphp

    <!-- Dashboard Cards Grid (Responsive) -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6 mb-8">
        <div class="bg-gradient-to-br from-orange-400 to-[#FF7304] rounded-3xl p-5 text-white shadow-lg shadow-orange-500/10">
            <p class="text-[9px] uppercase tracking-widest opacity-80 mb-1">Total Order</p>
            <span class="text-2xl font-black">{{ $totalPending }}</span>
        </div>
        <div class="bg-orange-500 rounded-3xl p-5 text-white shadow-lg">
            <p class="text-[9px] uppercase tracking-widest opacity-80 mb-1">Selesai</p>
            <span class="text-2xl font-black">{{ $totalSelesai }}</span>
        </div>
        <div class="bg-[#FF7304] rounded-3xl p-5 text-white shadow-lg">
            <p class="text-[9px] uppercase tracking-widest opacity-80 mb-1">Proses</p>
            <span class="text-2xl font-black">{{ $totalProses }}</span>
        </div>
        <div class="bg-orange-600 rounded-3xl p-5 text-white shadow-lg">
            <p class="text-[9px] uppercase tracking-widest opacity-80 mb-1">Batal</p>
            <span class="text-2xl font-black">{{ $totalBatal }}</span>
        </div>
    </div>

    <!-- Financial Cards (Vertical on Mobile) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6 mb-10">
        <div class="card-modern rounded-[32px] p-6 lg:p-8 lg:col-span-2 shadow-sm border">
            <h3 class="text-xs font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-6">Keuangan Platform</h3>
            <div class="flex flex-col sm:flex-row gap-6 lg:gap-12">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-500/10 flex items-center justify-center text-[#FF7304] shrink-0"><i class="fa-solid fa-wallet"></i></div>
                    <div>
                        <p class="text-[8px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest">Gross Revenue</p>
                        <p class="text-lg lg:text-xl font-black text-gray-800 dark:text-white tracking-tighter leading-none">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-green-50 dark:bg-green-500/10 flex items-center justify-center text-green-500 shrink-0"><i class="fa-solid fa-circle-check"></i></div>
                    <div>
                        <p class="text-[8px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest">Dana Settled</p>
                        <p class="text-lg lg:text-xl font-black text-gray-800 dark:text-white tracking-tighter leading-none">Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-modern rounded-[32px] p-6 lg:p-8 shadow-sm border flex items-center gap-5">
            <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center text-white shadow-lg shadow-orange-500/20 shrink-0"><i class="fa-solid fa-fire text-xl"></i></div>
            <div>
                <p class="text-[8px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest mb-1">Profit Netto</p>
                <p class="text-lg lg:text-xl font-black text-emerald-500 dark:text-orange-400 tracking-tighter leading-none">Rp {{ number_format($bookings->where('payment_status', \App\Enums\PaymentStatus::PAID)->sum('commission_amount'), 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Transaction List (Simplified for Mobile) -->
    <div class="card-modern rounded-[32px] lg:rounded-[48px] p-4 lg:p-10 mb-20 shadow-sm border overflow-hidden">
        <div class="mb-8 p-4 lg:p-0">
            <h3 class="text-xl lg:text-2xl font-black text-gray-800 dark:text-white uppercase tracking-tighter leading-none mb-1">Monitoring Mitra</h3>
            <p class="text-[9px] font-bold text-gray-300 dark:text-gray-500 uppercase tracking-[0.2em] italic">Real-time Transaction logs</p>
        </div>

        <div class="space-y-4">
            @foreach($bookings as $booking)
                <div class="p-5 lg:p-6 rounded-2xl lg:rounded-3xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all border border-gray-50 dark:border-white/5 lg:border-transparent hover:border-gray-100 dark:hover:border-white/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <!-- Left: Identity -->
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 rounded-xl lg:rounded-2xl bg-gray-50 dark:bg-orange-500/10 flex items-center justify-center text-[#FF7304] shrink-0">
                            @php $icons = ['kereta' => 'fa-train', 'pesawat' => 'fa-plane', 'bus' => 'fa-bus', 'hotel' => 'fa-hotel', 'wisata' => 'fa-mountain-sun']; @endphp
                            <i class="fa-solid {{ $icons[$booking->category] ?? 'fa-receipt' }} text-xl lg:text-3xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h4 class="text-sm lg:text-lg font-black text-gray-800 dark:text-white leading-tight uppercase tracking-tighter truncate">{{ $booking->user->name }}</h4>
                            <p class="text-[9px] lg:text-[10px] font-black text-orange-400 uppercase tracking-widest">{{ $booking->category }} • {{ $booking->booking_code }}</p>
                        </div>
                    </div>

                    <!-- Right: Status and Price -->
                    <div class="flex items-center justify-between sm:justify-end gap-4 lg:gap-10 border-t sm:border-none pt-4 sm:pt-0 border-gray-50 dark:border-white/5">
                        <span class="px-4 py-1.5 rounded-lg text-[8px] lg:text-[10px] font-black uppercase tracking-widest shadow-sm
                                    {{ $booking->payment_status === \App\Enums\PaymentStatus::PAID ? 'bg-black text-white dark:bg-white dark:text-black' : ($booking->status === \App\Enums\BookingStatus::CANCELLED ? 'bg-red-500 text-white' : 'bg-orange-100 text-[#FF7304] dark:bg-orange-500/20 dark:text-orange-400') }}">
                            {{ $booking->payment_status === \App\Enums\PaymentStatus::PAID ? 'PAID' : ($booking->status === \App\Enums\BookingStatus::CANCELLED ? 'CANCELLED' : 'UNPAID') }}
                        </span>

                        <div class="text-right min-w-[140px]">
                            <p class="text-xl font-black text-gray-800 dark:text-white leading-none mb-1 uppercase tracking-tighter">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                            <p class="text-[9px] font-bold text-gray-400 dark:text-gray-500 leading-none uppercase tracking-widest">{{ $booking->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection