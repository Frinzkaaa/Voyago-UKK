@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Hi, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-400 font-medium tracking-tight">Ringkasan performa Voyago bulan ini ✨</p>
    </div>

    <!-- Main Stats Grid -->
    <div class="flex flex-col xl:flex-row gap-8 mb-10">
        <!-- Left: 4 Summary Cards -->
        <div class="xl:w-[45%] lg:w-full grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Platform Revenue -->
            <div
                class="bg-[#FF7304] rounded-[32px] p-7 text-white relative overflow-hidden shadow-xl shadow-orange-100/50 group duration-500 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-8 relative z-10">
                    <p class="font-bold text-sm tracking-tight text-white/90">Total Platform Revenue</p>
                    <div
                        class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-all cursor-pointer">
                        <i class="fa-solid fa-wallet text-xs"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-2 mb-2">
                        <h2 class="text-2xl font-black">Rp
                            {{ number_format($stats['total_platform_revenue'], 0, ',', '.') }}
                        </h2>
                    </div>
                    <p class="text-[10px] text-white/70 font-bold uppercase tracking-widest">Total Commission: Rp
                        {{ number_format($stats['total_commission_earned'], 0, ',', '.') }}
                    </p>
                </div>
                <i
                    class="fa-solid fa-chart-line absolute -right-4 -bottom-4 text-8xl text-white/10 -rotate-12 translate-y-4"></i>
            </div>

            <!-- Status Mitra/Partner -->
            <div
                class="bg-orange-500 rounded-[32px] p-7 text-white relative overflow-hidden shadow-xl shadow-orange-100/50 group border border-orange-400/20 duration-500 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-8 relative z-10">
                    <p class="font-bold text-sm tracking-tight text-white/90">Partners & Users</p>
                    <div
                        class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-all cursor-pointer">
                        <i class="fa-solid fa-users text-xs"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center gap-6 mb-6">
                        <div class="flex items-center gap-3" title="Partners">
                            <i class="fa-solid fa-handshake text-2xl opacity-80"></i>
                            <span class="text-2xl font-black">{{ $stats['total_partners'] }}</span>
                        </div>
                        <div class="flex items-center gap-3" title="Users">
                            <i class="fa-solid fa-user-group text-2xl opacity-80"></i>
                            <span class="text-2xl font-black">{{ $stats['total_users'] }}</span>
                        </div>
                    </div>
                    <p class="text-[10px] text-white/80 font-bold tracking-tight">Total Active Products:
                        {{ $stats['total_active_products'] }}
                    </p>
                </div>
            </div>

            <!-- Bookings Stats -->
            <div
                class="bg-[#FF7304] rounded-[32px] p-7 text-white relative overflow-hidden shadow-xl shadow-orange-100/50 group duration-500 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-8 relative z-10">
                    <div class="flex items-center gap-3">
                        <p class="font-bold text-sm tracking-tight text-white/90">Total Bookings</p>
                    </div>
                    <div
                        class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-all cursor-pointer">
                        <i class="fa-solid fa-ticket text-xs"></i>
                    </div>
                </div>
                <div class="relative z-10">
                    <h2 class="text-4xl font-black mb-4">{{ $stats['total_bookings'] }}</h2>
                    <p class="text-[10px] text-white/80 font-bold tracking-tight leading-relaxed">
                        Pantau performa pemesanan real-time dari seluruh kategori layanan.
                    </p>
                </div>
            </div>

            <!-- Activity Logs Summary -->
            <div
                class="bg-orange-500 rounded-[32px] p-7 text-white relative overflow-hidden shadow-xl shadow-orange-100/50 group border border-orange-400/20 duration-500 hover:-translate-y-1">
                <div class="flex items-center justify-between mb-8 relative z-10">
                    <p class="font-bold text-sm tracking-tight text-white/90">Recent Activities</p>
                    <div
                        class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center backdrop-blur-sm group-hover:scale-110 transition-all cursor-pointer">
                        <i class="fa-solid fa-list-check text-xs"></i>
                    </div>
                </div>
                <div class="relative z-10 overflow-hidden">
                    <div class="space-y-4 max-h-[100px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($logs as $log)
                            <div class="flex items-center gap-3 border-b border-white/10 pb-2">
                                <div class="w-2 h-2 rounded-full bg-white"></div>
                                <span class="text-[10px] font-bold truncate">{{ $log->action }}: {{ $log->description }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Total Visits Chart -->
        <div class="xl:w-[55%] lg:w-full bg-white rounded-[40px] p-10 shadow-sm border border-gray-50 flex flex-col">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight">Total visits</h3>
                </div>
                <div class="text-right">
                    <span class="text-2xl font-black text-[#FF7304]">43.18M</span>
                </div>
            </div>
            <div class="flex-grow">
                <canvas id="visitsChart" class="w-full h-[280px]"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8">
        <!-- Traffic Sources -->
        <div class="xl:col-span-4 bg-white rounded-[40px] p-10 shadow-sm border border-gray-50">
            <h3 class="text-2xl font-black text-gray-800 mb-10 tracking-tight">Traffic Sources</h3>

            <div
                class="flex items-center justify-between mb-6 text-gray-400 font-bold text-[10px] uppercase tracking-widest px-2">
                <span>Source</span>
                <span>Traffic source %</span>
            </div>

            <div class="flex items-center flex-col gap-8">
                <div class="w-full space-y-4">
                    <div class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-[14px] bg-orange-500 flex items-center justify-center text-white text-xs font-black">
                                1</div>
                            <span
                                class="text-sm text-gray-800 font-black tracking-tight group-hover:text-orange-500 transition-colors">Direct</span>
                        </div>
                        <span class="text-sm font-black text-gray-800">55</span>
                    </div>
                    <div class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-[14px] bg-[#EEF24F] flex items-center justify-center text-gray-800 text-xs font-black">
                                2</div>
                            <span
                                class="text-sm text-gray-800 font-black tracking-tight group-hover:text-orange-500 transition-colors">Search</span>
                        </div>
                        <span class="text-sm font-black text-gray-800">35</span>
                    </div>
                    <div class="flex items-center justify-between group cursor-pointer">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-[14px] bg-[#97E75B] flex items-center justify-center text-gray-800 text-xs font-black">
                                3</div>
                            <span
                                class="text-sm text-gray-800 font-black tracking-tight group-hover:text-orange-500 transition-colors">Social</span>
                        </div>
                        <span class="text-sm font-black text-gray-800">10</span>
                    </div>
                </div>

                <div class="w-full relative flex justify-center py-4">
                    <canvas id="trafficChart" class="w-full h-48"></canvas>
                    <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
                        <span class="text-3xl font-black text-gray-800 tracking-tighter">55 %</span>
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-widest">Direct</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Chart -->
        <div class="xl:col-span-8 bg-white rounded-[40px] p-10 shadow-sm border border-gray-50">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 tracking-tight">Performance</h3>
                </div>
                <div class="flex gap-6 items-center">
                    <button
                        class="text-[10px] font-bold text-gray-300 uppercase tracking-widest hover:text-gray-800 transition-colors">Day</button>
                    <button
                        class="text-[10px] font-black text-gray-800 uppercase tracking-widest border-b-2 border-orange-500 pb-1">Week</button>
                    <button
                        class="text-[10px] font-bold text-gray-300 uppercase tracking-widest hover:text-gray-800 transition-colors">Month</button>
                </div>
            </div>
            <div class="w-full h-[320px]">
                <canvas id="performanceChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Visits Chart
            const ctxVisits = document.getElementById('visitsChart').getContext('2d');
            const visitsGradient = ctxVisits.createLinearGradient(0, 0, 0, 400);
            visitsGradient.addColorStop(0, 'rgba(255, 115, 4, 0.5)');
            visitsGradient.addColorStop(1, 'rgba(255, 115, 4, 0)');

            new Chart(ctxVisits, {
                type: 'line',
                data: {
                    labels: ['Oct', 'Nov', 'Dec', 'Janv'],
                    datasets: [{
                        label: 'Visits',
                        data: [80000, 45000, 140000, 80000],
                        fill: true,
                        backgroundColor: visitsGradient,
                        borderColor: '#FF7304',
                        borderWidth: 5,
                        tension: 0.4,
                        pointBackgroundColor: '#FF7304',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 4,
                        pointRadius: 6,
                        pointHoverRadius: 9,
                        pointHoverBackgroundColor: '#FF7304'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { color: '#D1D5DB', font: { size: 10, weight: '700' } }
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#f8f9fa' },
                            border: { display: false },
                            ticks: {
                                stepSize: 50000,
                                color: '#9CA3AF',
                                font: { size: 10, weight: '700' },
                                callback: function (value) { return value.toFixed(2); }
                            },
                            min: 0,
                            max: 150000
                        }
                    }
                }
            });

            // Traffic Chart (Donut)
            const ctxTraffic = document.getElementById('trafficChart').getContext('2d');
            new Chart(ctxTraffic, {
                type: 'doughnut',
                data: {
                    datasets: [{
                        data: [55, 35, 10],
                        backgroundColor: ['#FF7304', '#EEF24F', '#97E75B'],
                        borderWidth: 0,
                        borderRadius: 15
                    }]
                },
                options: {
                    cutout: '80%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });

            // Performance Chart (Bar)
            const ctxPerformance = document.getElementById('performanceChart').getContext('2d');
            new Chart(ctxPerformance, {
                type: 'bar',
                data: {
                    labels: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                    datasets: [
                        {
                            label: 'A',
                            data: [75, 55, 65, 30, 45, 85, 65],
                            backgroundColor: (context) => {
                                const chart = context.chart;
                                const { ctx, chartArea } = chart;
                                if (!chartArea) return null;
                                const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                                gradient.addColorStop(0, '#A5B4FC');
                                gradient.addColorStop(1, '#6366F1');
                                return gradient;
                            },
                            borderRadius: 8,
                            barThickness: 16
                        },
                        {
                            label: 'B',
                            data: [95, 50, 75, 35, 45, 95, 50],
                            backgroundColor: (context) => {
                                const chart = context.chart;
                                const { ctx, chartArea } = chart;
                                if (!chartArea) return null;
                                const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                                gradient.addColorStop(0, '#FEF08A');
                                gradient.addColorStop(1, '#FACC15');
                                return gradient;
                            },
                            borderRadius: 8,
                            barThickness: 16
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: {
                            grid: { display: false },
                            border: { display: false },
                            ticks: { color: '#D1D5DB', font: { size: 10, weight: '700' } }
                        },
                        y: { display: false }
                    }
                }
            });
        });
    </script>
@endsection