@extends('mitra.layout')

@section('content')
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12">
        <div class="space-y-1">
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase italic">Laporan & Komisi</h2>
            <p class="text-sm text-gray-500 dark:text-zinc-400 font-medium">Transparansi pendapatan dan rincian bagi hasil ekosistem Voyago</p>
        </div>
        <button
            class="bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 flex items-center gap-3 px-8 py-4 rounded-2xl text-[10px] font-black text-gray-500 dark:text-white hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all shadow-sm uppercase tracking-widest">
            <i class="fa-solid fa-file-invoice-dollar text-orange-500 text-lg"></i>
            Unduh Laporan Keuangan
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
        <!-- Net Income -->
        <div class="bg-white dark:bg-zinc-900 p-10 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-50 dark:bg-emerald-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Total Pendapatan Bersih</p>
            <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">
                <span class="text-sm font-bold text-gray-400 mr-1">Rp</span>{{ number_format($orders->sum('net_income'), 0, ',', '.') }}
            </h3>
            <div class="mt-8 flex items-center gap-3">
                <div class="px-3 py-1 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 text-[10px] font-black uppercase rounded-lg">Settled</div>
                <span class="text-[10px] text-gray-300 font-bold uppercase tracking-tighter">Setelah Pajak & Fee Platform</span>
            </div>
        </div>

        <!-- Commission -->
        <div class="bg-white dark:bg-zinc-900 p-10 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm relative overflow-hidden group">
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-50 dark:bg-orange-500/5 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Potongan Komisi (10%)</p>
            <h3 class="text-3xl font-black text-gray-900 dark:text-white tracking-tighter">
                <span class="text-sm font-bold text-gray-400 mr-1">Rp</span>{{ number_format($orders->sum('commission_amount'), 0, ',', '.') }}
            </h3>
            <div class="mt-8 flex items-center gap-3">
                <div class="px-3 py-1 bg-orange-50 dark:bg-orange-500/10 text-orange-500 text-[10px] font-black uppercase rounded-lg">Standard Fee</div>
                <span class="text-[10px] text-gray-300 font-bold uppercase tracking-tighter">Kontribusi Ekosistem Platform</span>
            </div>
        </div>

        <!-- Prepared Funds -->
        <div class="bg-gray-900 dark:bg-orange-600 p-10 rounded-[40px] text-white shadow-2xl relative overflow-hidden group">
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
            <div class="relative z-10 flex flex-col h-full">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] mb-4 opacity-60 italic">Dana Siap Tarik</p>
                <h3 class="text-3xl font-black tracking-tighter mb-8">
                    <span class="text-sm font-bold opacity-40 mr-1">Rp</span>{{ number_format($orders->sum('net_income'), 0, ',', '.') }}
                </h3>
                <button class="w-full bg-white text-gray-900 py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] shadow-xl hover:scale-105 active:scale-95 transition-all mt-auto border-none">
                    Pencairan Dana Instan
                </button>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="p-10 border-b border-gray-50 dark:border-zinc-800 flex items-center justify-between">
            <div>
                <h4 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest italic">Riwayat Settlement</h4>
                <p class="text-[10px] text-gray-400 font-bold uppercase mt-1">Daftar transaksi yang telah dikonfirmasi dan siap cair</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-3 h-3 bg-emerald-500 rounded-full"></span>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Real-time Sync</span>
            </div>
        </div>

        <div class="overflow-x-auto no-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-zinc-950/50">
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Settlement Date</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Reference ID</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Gross Value</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Commission</th>
                        <th class="px-10 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-right">Net Settlement</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-zinc-800 pb-10">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/30 dark:hover:bg-zinc-800/30 transition-all group">
                            <td class="px-10 py-8">
                                <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter">
                                    {{ ($order->confirmed_at ?? $order->updated_at)->format('d M, Y') }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                <div class="flex flex-col">
                                    <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">#{{ $order->booking_code }}</span>
                                    <span class="text-[9px] text-gray-400 font-bold uppercase mt-1">Payment Reference</span>
                                </div>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-sm font-black text-gray-900 dark:text-white tracking-tighter italic">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-sm font-black text-orange-500 tracking-tighter italic">
                                    -{{ number_format($order->commission_amount, 0, ',', '.') }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <div class="bg-gray-50 dark:bg-emerald-500/5 px-4 py-2 rounded-xl inline-block border border-gray-100 dark:border-emerald-500/10">
                                    <span class="text-sm font-black text-gray-900 dark:text-emerald-400 tracking-tighter">
                                        Rp {{ number_format($order->net_income, 0, ',', '.') }}
                                    </span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-10 py-32 text-center text-gray-400 font-bold uppercase text-[10px] tracking-[0.3em]">
                                <i class="fa-solid fa-receipt text-4xl block mb-6 opacity-20"></i>
                                Belum ada rincian data keuangan yang tercatat
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection