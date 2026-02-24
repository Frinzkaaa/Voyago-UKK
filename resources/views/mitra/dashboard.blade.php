@extends('mitra.layout')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Stat Cards -->
        <div class="premium-card p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Produk Aktif</p>
                <div class="w-8 h-8 bg-gray-50 flex items-center justify-center text-gray-400 rounded">
                    <i class="fa-solid fa-box-open text-sm"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none">{{ $totalProducts }}</h3>
                    <p class="text-[11px] text-emerald-500 font-medium mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                        <span>12.5% dari bulan lalu</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="premium-card p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Total Pesanan</p>
                <div class="w-8 h-8 bg-gray-50 flex items-center justify-center text-gray-400 rounded">
                    <i class="fa-solid fa-receipt text-sm"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none">{{ $totalOrders }}</h3>
                    <p class="text-[11px] text-orange-500 font-medium mt-2 flex items-center gap-1">
                        <i class="fa-solid fa-clock"></i>
                        <span>3 pesanan diproses</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="premium-card p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Gross Pendapatan</p>
                <div class="w-8 h-8 bg-gray-50 flex items-center justify-center text-gray-400 rounded">
                    <i class="fa-solid fa-wallet text-sm"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none">Rp
                        {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-gray-400 font-medium mt-2 flex items-center gap-1">
                        <span>Total akumulasi mitra</span>
                    </p>
                </div>
            </div>
        </div>

        <div class="premium-card p-5">
            <div class="flex items-center justify-between mb-3">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Estimasi Bersih</p>
                <div class="w-8 h-8 bg-emerald-50 flex items-center justify-center text-emerald-600 rounded">
                    <i class="fa-solid fa-money-bill-transfer text-sm"></i>
                </div>
            </div>
            <div class="flex items-end justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-900 leading-none">Rp
                        {{ number_format($totalRevenue - $totalCommission, 0, ',', '.') }}</h3>
                    <p class="text-[11px] text-emerald-600 font-medium mt-2">Dapat ditarik ke rekening</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Chart Section -->
        <div class="lg:col-span-8 space-y-8">
            <div class="premium-card p-6">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Performa Keuangan</h3>
                        <p class="text-xs text-gray-400 mt-1">Data penjualan 6 bulan terakhir</p>
                    </div>
                    <div class="flex gap-2">
                        <select
                            class="bg-gray-50 border border-gray-200 text-[10px] font-semibold text-gray-600 px-3 py-1.5 rounded outline-none cursor-pointer">
                            <option>Tahun 2026</option>
                            <option>Tahun 2025</option>
                        </select>
                    </div>
                </div>
                <div class="relative h-[320px]">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="premium-card overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900">Pesanan Terbaru</h3>
                    <a href="{{ route('partner.orders') }}"
                        class="text-[10px] font-bold text-orange-500 uppercase tracking-wider hover:text-orange-600">Lihat
                        Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-[10px] font-semibold text-gray-400 uppercase">Customer</th>
                                <th class="px-6 py-3 text-[10px] font-semibold text-gray-400 uppercase">Tipe</th>
                                <th class="px-6 py-3 text-[10px] font-semibold text-gray-400 uppercase">Total</th>
                                <th class="px-6 py-3 text-[10px] font-semibold text-gray-400 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-xs">
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">Ramdhani Akbar</td>
                                <td class="px-6 py-4 text-gray-500">Tiket Pesawat</td>
                                <td class="px-6 py-4 font-semibold">Rp 1.450.000</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[10px] font-semibold">Berhasil</span>
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-6 py-4 font-medium text-gray-900">Siti Aminah</td>
                                <td class="px-6 py-4 text-gray-500">Hotel Resort</td>
                                <td class="px-6 py-4 font-semibold">Rp 2.100.000</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-0.5 bg-orange-50 text-orange-600 rounded text-[10px] font-semibold">Pending</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Right Side -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            <div class="premium-card p-6 bg-gray-900 text-white border-none shadow-lg">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-white/10 rounded flex items-center justify-center">
                        <i class="fa-solid fa-rocket text-sm"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold">Upgrade Bisnis</h4>
                        <p class="text-[10px] text-gray-400">Expand pasar Anda hari ini</p>
                    </div>
                </div>
                <p class="text-xs text-gray-300 leading-relaxed mb-6">Tambahkan inventori produk baru untuk meningkatkan
                    potensi pendapatan hingga 40%.</p>
                <a href="{{ route('partner.products.create') }}"
                    class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white py-2.5 rounded text-xs font-semibold transition-colors">
                    + Tambah Produk Baru
                </a>
            </div>

            <div class="premium-card">
                <div class="p-6 border-b border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900">Ringkasan Wallet</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-widest mb-2">Saldo Tersedia</p>
                        <p class="text-2xl font-bold text-gray-900">Rp
                            {{ number_format($totalRevenue - $totalCommission, 0, ',', '.') }}</p>
                    </div>
                    <div class="pt-4 border-t border-gray-50 grid grid-cols-2 gap-3">
                        <button
                            class="bg-gray-50 hover:bg-gray-100 text-gray-900 py-2 rounded text-xs font-semibold transition-colors">
                            Riwayat
                        </button>
                        <button
                            class="bg-gray-900 hover:bg-black text-white py-2 rounded text-xs font-semibold transition-colors">
                            Tarik Dana
                        </button>
                    </div>
                </div>
            </div>

            <div class="premium-card p-6">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Butuh Bantuan?</h3>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="mt-1 text-gray-400"><i class="fa-solid fa-circle-question text-sm"></i></div>
                        <div>
                            <p class="text-xs font-semibold text-gray-800">Panduan Partner</p>
                            <p class="text-[10px] text-gray-500 mt-1">Pelajari cara optimasi produk.</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <div class="mt-1 text-gray-400"><i class="fa-solid fa-envelope text-sm"></i></div>
                        <div>
                            <p class="text-xs font-semibold text-gray-800">Hubungi Support</p>
                            <p class="text-[10px] text-gray-500 mt-1">Bantuan teknis 24/7.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('revenueChart').getContext('2d');

            // Custom Gradient for Chart
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(249, 115, 22, 0.1)');
            gradient.addColorStop(1, 'rgba(249, 115, 22, 0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                    datasets: [{
                        label: 'Gros Revenue',
                        data: [4500000, 3200000, 6800000, 5100000, 9200000, {{ $totalRevenue }}],
                        borderColor: '#f97316',
                        backgroundColor: gradient,
                        borderWidth: 2,
                        tension: 0.35,
                        fill: true,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#f97316',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f3f4f6',
                                drawBorder: false
                            },
                            ticks: {
                                font: { family: 'Inter', size: 9 },
                                color: '#9ca3af',
                                callback: function (value) {
                                    if (value >= 1000000) return (value / 1000000) + 'M';
                                    return value;
                                }
                            }
                        },
                        x: {
                            grid: { display: false },
                            ticks: {
                                font: { family: 'Inter', size: 9 },
                                color: '#9ca3af'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection