@extends('mitra.layout')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Ringkasan Performa</h2>
        <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1 font-medium">Selamat datang kembali, ini pencapaian bisnismu hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Stat Cards -->
        <div class="bg-white dark:bg-zinc-900 p-6 rounded-[32px] border border-gray-100 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-orange-50 dark:bg-orange-950/20 flex items-center justify-center text-orange-500 rounded-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-box-open text-base"></i>
                </div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Katalog</span>
            </div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalProducts }}</h3>
            <p class="text-[10px] text-gray-400 mt-1 font-bold">Produk Terdaftar</p>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 rounded-[32px] border border-gray-100 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-blue-50 dark:bg-blue-950/20 flex items-center justify-center text-blue-500 rounded-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-receipt text-base"></i>
                </div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Orders</span>
            </div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white">{{ $totalOrders }}</h3>
            <p class="text-[10px] text-emerald-500 mt-1 font-bold flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-up"></i> 8% Kenaikan
            </p>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 rounded-[32px] border border-gray-100 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-950/20 flex items-center justify-center text-emerald-500 rounded-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-wallet text-base"></i>
                </div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Income</span>
            </div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-gray-400 mt-1 font-bold">Total Pendapatan</p>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 rounded-[32px] border border-gray-100 dark:border-zinc-800 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 bg-purple-50 dark:bg-purple-950/20 flex items-center justify-center text-purple-500 rounded-2xl group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-money-bill-transfer text-base"></i>
                </div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Settlement</span>
            </div>
            <h3 class="text-2xl font-black text-gray-900 dark:text-white">Rp {{ number_format($totalRevenue - $totalCommission, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-purple-500 mt-1 font-bold">Siap Dicairkan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Analytics & List -->
        <div class="lg:col-span-8 flex flex-col gap-8">
            <!-- Chart Card -->
            <div class="bg-white dark:bg-zinc-900 p-8 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 p-8">
                    <select class="bg-gray-50 dark:bg-zinc-800 border-none rounded-xl text-[10px] font-black uppercase tracking-widest px-4 py-2 outline-none cursor-pointer text-gray-500 dark:text-zinc-400">
                        <option>6 Bulan Terakhir</option>
                        <option>1 Tahun Terakhir</option>
                    </select>
                </div>
                <div class="mb-10">
                    <h3 class="text-lg font-black text-gray-900 dark:text-white">Visualisasi Revenue</h3>
                    <p class="text-xs text-gray-400 font-medium">Statistik pertumbuhan bisnismu bulan ini.</p>
                </div>
                <div class="relative h-[300px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Orders list -->
            <div class="bg-white dark:bg-zinc-900 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="p-8 border-b border-gray-50 dark:border-zinc-800 flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-black text-gray-900 dark:text-white">Aktivitas Pesanan</h3>
                        <p class="text-xs text-gray-400 font-medium mt-1">Pantau transaksi masuk secara reall-time.</p>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-zinc-800/30">
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Customer</th>
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Produk</th>
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Total</th>
                                <th class="px-8 py-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-zinc-800">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-gray-50/80 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <p class="text-xs font-black text-gray-900 dark:text-white">{{ $order->user_name ?? 'Premium Guest' }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1">{{ $order->created_at->format('d M, H:i') }}</p>
                                    </td>
                                    <td class="px-8 py-5">
                                        <div class="px-2.5 py-1 bg-zinc-100 dark:bg-zinc-800 rounded-lg text-[10px] font-bold text-gray-600 dark:text-zinc-400 inline-block uppercase whitespace-nowrap">
                                            {{ $order->category }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-5">
                                        <p class="text-xs font-black text-gray-900 dark:text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </td>
                                    <td class="px-8 py-5">
                                        @if($order->status == 'confirmed')
                                            <span class="px-3 py-1 bg-emerald-50 dark:bg-emerald-950/30 text-emerald-500 rounded-full text-[9px] font-black uppercase tracking-widest italic">PAID</span>
                                        @else
                                            <span class="px-3 py-1 bg-zinc-100 dark:bg-zinc-800 text-zinc-400 rounded-full text-[9px] font-black uppercase tracking-widest">{{ $order->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-8 py-20 text-center text-gray-400 text-xs font-medium italic">
                                        Belum ada pesanan masuk hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <div class="bg-gray-900 dark:bg-orange-600 p-10 rounded-[40px] text-white relative overflow-hidden group shadow-2xl">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform"></div>
                <div class="relative z-10">
                    <h4 class="text-xl font-black mb-2">Expansi Bisnis</h4>
                    <p class="text-xs text-orange-200/70 font-medium leading-relaxed mb-10">Mulai daftarkan produk baru dan tingkatkan eksposur layananmu ke ribuan user harian.</p>
                    <a href="{{ route('partner.products.create') }}" class="flex items-center justify-center gap-3 bg-white text-gray-900 py-4 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-orange-50 transition-all shadow-lg">
                        <i class="fa-solid fa-plus-circle"></i>
                        Tambah Inventori
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-zinc-900 p-8 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm group">
                <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest mb-8">Pusat Bantuan</h3>
                <div class="space-y-6">
                    <a href="#" class="flex items-center gap-4 group">
                        <div class="w-10 h-10 bg-gray-50 dark:bg-zinc-800 flex items-center justify-center rounded-xl text-gray-400 group-hover:bg-orange-500 group-hover:text-white transition-all">
                            <i class="fa-solid fa-book-open text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-gray-900 dark:text-white">Dokumentasi API</p>
                            <p class="text-[10px] text-gray-400 font-medium">Integrasi eksternal mudah</p>
                        </div>
                    </a>
                    <a href="#" class="flex items-center gap-4 group">
                        <div class="w-10 h-10 bg-gray-50 dark:bg-zinc-800 flex items-center justify-center rounded-xl text-gray-400 group-hover:bg-orange-500 group-hover:text-white transition-all">
                            <i class="fa-solid fa-headset text-sm"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black text-gray-900 dark:text-white">Bantuan Teknis</p>
                            <p class="text-[10px] text-gray-400 font-medium">Chat tim support 24/7</p>
                        </div>
                    </a>
                </div>
                <div class="mt-10 pt-8 border-t border-gray-50 dark:border-zinc-800">
                    <p class="text-[10px] text-gray-400 font-bold leading-relaxed">System Status: <span class="text-emerald-500">OPERATIONAL</span></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart').getContext('2d');

            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(249, 115, 22, 0.4)');
            gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Gross Profit',
                        data: [5, 12, 10, 25, 18, 30],
                        borderColor: '#f97316',
                        backgroundColor: gradient,
                        borderWidth: 4,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 8,
                        pointHoverBackgroundColor: '#f97316',
                        pointHoverBorderColor: '#fff',
                        pointHoverBorderWidth: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { drawBorder: false, color: 'rgba(0,0,0,0.03)' },
                            ticks: { font: { size: 10, weight: '900' }, color: '#94a3b8' }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: '900' }, color: '#94a3b8' }
                        }
                    }
                }
            });
        });
    </script>
@endsection