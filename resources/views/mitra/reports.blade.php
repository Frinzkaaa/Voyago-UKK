@extends('mitra.layout')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Laporan & Komisi</h2>
            <p class="text-sm text-gray-500 mt-1">Transparansi pendapatan dan rincian bagi hasil platform</p>
        </div>
        <button
            class="bg-white border border-gray-200 flex items-center gap-2 px-4 py-2 rounded text-[10px] font-bold text-gray-600 hover:bg-gray-50 transition-colors shadow-sm">
            <i class="fa-solid fa-file-export text-gray-400"></i>
            Unduh Laporan
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="premium-card p-6 border-l-4 border-gray-900 bg-white shadow-sm">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Pendapatan Bersih</p>
            <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($orders->sum('net_income'), 0, ',', '.') }}
            </h3>
            <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-50">
                <span class="text-[9px] text-gray-400 uppercase font-bold">Setelah Pajak & Fee</span>
                <span class="text-[9px] font-bold text-emerald-600">Terakumulasi</span>
            </div>
        </div>
        <div class="premium-card p-6 border-l-4 border-red-500 bg-white shadow-sm">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Total Komisi Platform</p>
            <h3 class="text-2xl font-bold text-gray-900">Rp
                {{ number_format($orders->sum('commission_amount'), 0, ',', '.') }}</h3>
            <div class="mt-4 flex items-center justify-between pt-4 border-t border-gray-50">
                <span class="text-[9px] text-gray-400 uppercase font-bold">Standard 10% Fee</span>
                <span class="text-[9px] font-bold text-red-500">- 10.0%</span>
            </div>
        </div>
        <div class="premium-card p-6 border-l-4 border-orange-500 bg-gray-900 text-white shadow-md">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1">Dana Siap Tarik</p>
            <h3 class="text-2xl font-bold text-white">Rp {{ number_format($orders->sum('net_income'), 0, ',', '.') }}</h3>
            <button
                class="mt-4 w-full bg-white text-gray-900 py-2 rounded text-[10px] font-bold uppercase tracking-widest hover:bg-orange-500 hover:text-white transition-all shadow-sm">Tarik
                Pendapatan</button>
        </div>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-white">
            <h4 class="font-bold text-gray-900 text-xs">Riwayat Transaksi Terkonfirmasi</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Tanggal
                            Settlement</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Kode Booking
                        </th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Nilai
                            Transaksi</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Potongan
                            Komisi</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400 text-right">
                            Settlement Bersih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors text-xs">
                            <td class="px-6 py-4 text-gray-500 font-medium">
                                {{ ($order->confirmed_at ?? $order->updated_at)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-bold text-gray-900">#{{ $order->booking_code }}</span>
                            </td>
                            <td class="px-6 py-4 text-gray-900 font-semibold">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-red-500 font-semibold">
                                - Rp {{ number_format($order->commission_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-bold text-gray-900">Rp
                                    {{ number_format($order->net_income, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div
                                    class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                    <i class="fa-solid fa-receipt text-gray-200"></i>
                                </div>
                                <p class="text-xs font-semibold text-gray-400">Belum ada rincian data keuangan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection