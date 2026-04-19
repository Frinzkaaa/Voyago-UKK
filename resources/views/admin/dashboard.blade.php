@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight leading-none mb-2 uppercase">Dashboard Admin</h1>
        <p class="text-gray-400 dark:text-gray-500 font-medium tracking-tight">Selamat datang kembali di pusat kendali Voyago ✨</p>
    </div>

    <!-- Stats Grid (Bento Style) -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
        <!-- Card 1: Revenue -->
        <div class="bg-gradient-to-br from-orange-400 to-[#FF7304] rounded-[40px] p-8 text-white shadow-xl shadow-orange-500/20 relative overflow-hidden group h-64 flex flex-col justify-between">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-black uppercase tracking-widest opacity-80 leading-tight">Total Platform<br>Revenue</h3>
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md"><i class="fa-solid fa-wallet"></i></div>
                </div>
                <p class="text-3xl font-black tracking-tighter mb-1">Rp {{ number_format($stats['total_platform_revenue'] ?? 0, 0, ',', '.') }}</p>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Total Commission: Rp {{ number_format($stats['total_commission_earned'] ?? 0, 0, ',', '.') }}</p>
            </div>
            <i class="fa-solid fa-chart-line absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-500"></i>
        </div>

        <!-- Card 2: Partners & Users -->
        <div class="bg-gradient-to-br from-orange-400 to-[#FF7304] rounded-[40px] p-8 text-white shadow-xl shadow-orange-500/20 relative overflow-hidden group h-64 flex flex-col justify-between">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-black uppercase tracking-widest opacity-80 leading-tight">Partners & Users</h3>
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md"><i class="fa-solid fa-users"></i></div>
                </div>
                <div class="flex items-center gap-6 mb-6">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-handshake text-2xl opacity-50"></i>
                        <span class="text-3xl font-black tracking-tighter">{{ $stats['total_partners'] ?? 0 }}</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-user-group text-2xl opacity-50"></i>
                        <span class="text-3xl font-black tracking-tighter">{{ $stats['total_users'] ?? 0 }}</span>
                    </div>
                </div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Total Active Products: {{ $stats['total_active_products'] ?? 0 }}</p>
            </div>
            <i class="fa-solid fa-users absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-500"></i>
        </div>

        <!-- Card 3: Bookings -->
        <div class="bg-gradient-to-br from-orange-400 to-[#FF7304] rounded-[40px] p-8 text-white shadow-xl shadow-orange-500/20 relative overflow-hidden group h-64 flex flex-col justify-between">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-black uppercase tracking-widest opacity-80 leading-tight">Total Bookings</h3>
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md"><i class="fa-solid fa-ticket"></i></div>
                </div>
                <p class="text-6xl font-black tracking-tighter mb-4">{{ $stats['total_bookings'] ?? 0 }}</p>
                <p class="text-[10px] font-bold opacity-80 leading-relaxed">Pantau performa pemesanan real-time dari seluruh kategori layanan.</p>
            </div>
            <i class="fa-solid fa-calendar-check absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-500"></i>
        </div>

        <!-- Card 4: Recent Activities -->
        <div class="bg-gradient-to-br from-orange-400 to-[#FF7304] rounded-[40px] p-8 text-white shadow-xl shadow-orange-500/20 relative overflow-hidden group h-64 flex flex-col justify-between">
            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-sm font-black uppercase tracking-widest opacity-80 leading-tight">Recent Activities</h3>
                    <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-md"><i class="fa-solid fa-list-ul"></i></div>
                </div>
                <div class="space-y-3">
                    @forelse($logs ?? [] as $activity)
                        <div class="flex items-center gap-3">
                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                            <p class="text-[10px] font-bold uppercase tracking-tight truncate">{{ $activity->description ?? $activity->action }}</p>
                        </div>
                    @empty
                        <p class="text-[10px] italic opacity-70">Tidak ada aktivitas terbaru.</p>
                    @endforelse
                </div>
            </div>
            <i class="fa-solid fa-bell absolute -right-4 -bottom-4 text-9xl opacity-10 group-hover:scale-110 transition-transform duration-500"></i>
        </div>
    </div>

    <!-- Main Charts Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-10">
        <div class="lg:col-span-2 card-modern rounded-[40px] p-10 shadow-sm overflow-hidden">
            <div class="flex justify-between items-start mb-8">
                <div>
                    <h3 class="text-2xl font-black text-gray-800 dark:text-white uppercase tracking-tighter leading-none mb-1">Total visits</h3>
                    <p class="text-[10px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest">Statistik pengunjung bulanan</p>
                </div>
                <span class="text-3xl font-black text-[#FF7304] tracking-tighter">43.18M</span>
            </div>
            <div class="h-64 relative">
                 <canvas id="visitsChart"></canvas>
            </div>
        </div>

        <div class="card-modern rounded-[40px] p-10 shadow-sm flex flex-col">
            <h3 class="text-xl font-black text-gray-800 dark:text-white uppercase tracking-tighter mb-8 leading-none">Traffic Sources</h3>
            <div class="flex-grow flex items-center justify-center relative">
                <canvas id="trafficChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Row Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-20">
        <div class="lg:col-span-2 card-modern rounded-[40px] p-10 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-xl font-black text-gray-800 dark:text-white uppercase tracking-tighter leading-none">Performance</h3>
                <div class="flex gap-4">
                    <button class="text-[9px] font-black uppercase tracking-widest text-gray-300 hover:text-[#FF7304] transition-colors">Day</button>
                    <button class="text-[9px] font-black uppercase tracking-widest text-[#FF7304]">Week</button>
                    <button class="text-[9px] font-black uppercase tracking-widest text-gray-300 hover:text-[#FF7304] transition-colors">Month</button>
                </div>
            </div>
            <div class="h-48">
                 <canvas id="performanceChart"></canvas>
            </div>
        </div>

        <div class="card-modern rounded-[40px] p-10 shadow-sm flex flex-col justify-center items-center text-center">
            <div class="w-16 h-16 bg-orange-50 dark:bg-orange-500/10 rounded-3xl flex items-center justify-center text-[#FF7304] mb-4">
                <i class="fa-solid fa-server text-2xl"></i>
            </div>
            <h4 class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-widest mb-1 leading-none">System Status</h4>
            <p class="text-[10px] font-bold text-gray-400 dark:text-gray-600 uppercase tracking-[0.2em] mb-4">All systems operational</p>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest leading-none">Online & Secure</span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const isDarkMode = document.documentElement.classList.contains('dark');
            const textColor = isDarkMode ? '#94A3B8' : '#64748B';
            const gridColor = isDarkMode ? 'rgba(51, 65, 85, 0.2)' : 'rgba(226, 232, 240, 0.5)';

            Chart.defaults.color = textColor;
            Chart.defaults.font.family = "'Poppins', sans-serif";
            Chart.defaults.font.weight = '600';

            new Chart(document.getElementById('visitsChart'), {
                type: 'line',
                data: {
                    labels: ['Oct', 'Nov', 'Dec', 'Jan'],
                    datasets: [{
                        label: 'Visits',
                        data: [80000, 65000, 140000, 95000],
                        borderColor: '#FF7304',
                        backgroundColor: 'rgba(255, 115, 4, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 4,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#FF7304',
                        pointBorderWidth: 2,
                        pointRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { grid: { color: gridColor }, border: { display: false } },
                        x: { grid: { display: false }, border: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('trafficChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Direct', 'Social', 'Referral'],
                    datasets: [{
                        data: [55, 25, 20],
                        backgroundColor: ['#FF7304', '#0F172A', '#E2E8F0'],
                        borderWidth: 0,
                        hoverOffset: 10
                    }]
                },
                options: {
                    cutout: '75%',
                    plugins: { 
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                font: { size: 10, weight: '900' }
                            }
                        } 
                    }
                }
            });

            new Chart(document.getElementById('performanceChart'), {
                type: 'bar',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Sales',
                        data: [45, 52, 38, 65, 48, 72, 58],
                        backgroundColor: '#FF7304',
                        borderRadius: 12,
                        barThickness: 12
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { grid: { color: gridColor }, border: { display: false } },
                        x: { grid: { display: false }, border: { display: false } }
                    }
                }
            });
        });
    </script>
@endsection