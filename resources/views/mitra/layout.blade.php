<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyago Partner - SaaS Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
            color: #374151;
        }

        .sidebar-item-active {
            background-color: #f3f4f6;
            color: #111827 !important;
            font-weight: 600;
        }

        .sidebar-item:hover:not(.sidebar-item-active) {
            background-color: #f9fafb;
            color: #111827 !important;
        }

        .premium-card {
            background: #FFFFFF;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease;
        }

        .premium-card:hover {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 4px;
        }
    </style>
</head>

<body class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-gray-200 flex flex-col shrink-0 fixed h-full z-50">
        <div class="p-6 mb-4">
            <a href="/" class="flex items-center gap-2">
                <div class="w-8 h-8 bg-orange-500 rounded flex items-center justify-center">
                    <i class="fa-solid fa-plane-departure text-white text-sm"></i>
                </div>
                <span class="font-bold text-lg tracking-tight text-gray-900 uppercase">Voyago <span
                        class="text-orange-500 text-xs font-medium lowercase">partner</span></span>
            </a>
        </div>

        <nav class="flex-grow flex flex-col px-3 space-y-1 overflow-y-auto">
            <div class="px-3 mb-2">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Main Menu</p>
            </div>

            <a href="{{ route('partner.dashboard') }}"
                class="sidebar-item {{ request()->routeIs('partner.dashboard') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-md text-sm text-gray-500 transition-colors">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                <span>Overview</span>
            </a>

            <a href="{{ route('partner.products') }}"
                class="sidebar-item {{ request()->routeIs('partner.products*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-md text-sm text-gray-500 transition-colors">
                <i class="fa-solid fa-box-open w-5 text-center"></i>
                <span>Inventori Produk</span>
            </a>

            <a href="{{ route('partner.orders') }}"
                class="sidebar-item {{ request()->routeIs('partner.orders*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-md text-sm text-gray-500 transition-colors">
                <i class="fa-solid fa-list-check w-5 text-center"></i>
                <span>Manajemen Pesanan</span>
            </a>

            <div class="px-3 mt-6 mb-2">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Layanan</p>
            </div>

            <a href="{{ route('partner.complaints') }}"
                class="sidebar-item {{ request()->routeIs('partner.complaints*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-md text-sm text-gray-500 transition-colors">
                <i class="fa-solid fa-headset w-5 text-center"></i>
                <span>Komplain Pelanggan</span>
            </a>

            <a href="{{ route('partner.reports') }}"
                class="sidebar-item {{ request()->routeIs('partner.reports*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-md text-sm text-gray-500 transition-colors">
                <i class="fa-solid fa-wallet w-5 text-center"></i>
                <span>Pencairan Dana</span>
            </a>

            <div class="px-3 mt-6 mb-2">
                <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Preferensi</p>
            </div>

            <a href="{{ route('partner.settings') }}"
                class="sidebar-item {{ request()->routeIs('partner.settings*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-3 py-2.5 rounded-md text-sm text-gray-500 transition-colors">
                <i class="fa-solid fa-user-gear w-5 text-center"></i>
                <span>Profil & Settings</span>
            </a>
        </nav>

        <div class="p-4 mt-auto border-t border-gray-100">
            <a href="{{ route('partner.logout') }}"
                class="flex items-center gap-3 px-3 py-2.5 rounded-md text-sm text-red-500 hover:bg-red-50 transition-colors">
                <i class="fa-solid fa-arrow-right-from-bracket w-5 text-center"></i>
                <span>Keluar Aplikasi</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow ml-64 flex flex-col min-w-0">
        <!-- Top Header -->
        <header class="h-16 border-b border-gray-200 bg-white flex items-center justify-between px-8 sticky top-0 z-40">
            <div class="flex items-center gap-2">
                <span class="text-xs font-medium text-gray-400">Dashboard</span>
                <i class="fa-solid fa-chevron-right text-[10px] text-gray-300"></i>
                <span class="text-xs font-semibold text-gray-900">Partner Overview</span>
            </div>

            <div class="flex items-center gap-6">
                <!-- Notifications -->
                <button class="text-gray-400 hover:text-gray-600 transition-colors relative">
                    <i class="fa-solid fa-bell"></i>
                    <span
                        class="absolute -top-1 -right-1 w-2 h-2 bg-orange-500 rounded-full border-2 border-white"></span>
                </button>

                <!-- Divider -->
                <div class="h-6 w-px bg-gray-200"></div>

                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-semibold text-gray-900 leading-none">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-gray-400 mt-1 uppercase tracking-tight">
                            {{ Auth::user()->partner->service_type ?? 'Mitra' }}
                        </span>
                    </div>
                    <img src="/images/Avatarprof.jpeg" alt="Avatar"
                        class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-8 flex-grow">
            @if(session('success'))
                <div
                    class="bg-emerald-50 border border-emerald-100 text-emerald-700 px-4 py-3 rounded-md mb-6 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-3 font-medium text-sm">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-600">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Kinerja Bisnis</h2>
                <p class="text-sm text-gray-500 mt-1">Laporan harian dan ringkasan operasional mitra Voyago</p>
            </div>

            @yield('content')
        </div>

        <footer class="p-8 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
            <p>&copy; 2026 Voyago Technology. Semua Hak Dilindungi.</p>
            <div class="flex items-center gap-4">
                <a href="#" class="hover:text-gray-600">Pusat Bantuan</a>
                <a href="#" class="hover:text-gray-600">Ketentuan Layanan</a>
            </div>
        </footer>
    </main>
</body>

</html>