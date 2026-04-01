<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyago Business - Premium Partner Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --brand-orange: #FF7304;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #FAFAFA;
            color: #18181B;
        }
        .sidebar-item-active {
            background-color: #18181B;
            color: #FFFFFF !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        .dark .sidebar-item-active {
            background-color: var(--brand-orange);
            color: #FFFFFF !important;
        }
        .sidebar-item:hover:not(.sidebar-item-active) {
            background-color: #F4F4F5;
            transform: translateX(4px);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        .premium-blur {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
    </style>
</head>

<body class="flex min-h-screen bg-[#FAFAFA] dark:bg-black transition-colors duration-500">
    <!-- Sidebar -->
    <aside class="w-72 bg-white dark:bg-zinc-950 border-r border-gray-100 dark:border-zinc-900 flex flex-col shrink-0 fixed h-full z-50 transition-all duration-500">
        <div class="p-8 mb-6">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-black dark:bg-orange-500 rounded-2xl flex items-center justify-center transition-transform group-hover:rotate-12">
                    <i class="fa-solid fa-rocket text-white text-base"></i>
                </div>
                <div class="flex flex-col">
                    <span class="font-black text-lg tracking-tighter text-gray-900 dark:text-white uppercase leading-none">Voyago</span>
                    <span class="text-[10px] font-black text-orange-500 uppercase tracking-[0.3em] mt-1">Business</span>
                </div>
            </a>
        </div>

        <nav class="flex-grow flex flex-col px-4 space-y-1 overflow-y-auto no-scrollbar">
            <p class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 mt-2">Menu Utama</p>

            <a href="{{ route('partner.dashboard') }}"
                class="sidebar-item {{ request()->routeIs('partner.dashboard') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold text-gray-500 dark:text-zinc-400 transition-all duration-300">
                <i class="fa-solid fa-grid-2 w-5 text-center"></i>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('partner.products') }}"
                class="sidebar-item {{ request()->routeIs('partner.products*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold text-gray-500 dark:text-zinc-400 transition-all duration-300">
                <i class="fa-solid fa-layer-group w-5 text-center"></i>
                <span>Katalog Produk</span>
            </a>

            <a href="{{ route('partner.orders') }}"
                class="sidebar-item {{ request()->routeIs('partner.orders*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold text-gray-500 dark:text-zinc-400 transition-all duration-300">
                <i class="fa-solid fa-calendar-check w-5 text-center"></i>
                <span>Transaksi</span>
            </a>

            <p class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 mt-10">Layanan & Support</p>

            <a href="{{ route('partner.complaints') }}"
                class="sidebar-item {{ request()->routeIs('partner.complaints*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold text-gray-500 dark:text-zinc-400 transition-all duration-300">
                <i class="fa-solid fa-comments w-5 text-center"></i>
                <span>Komplain</span>
            </a>

            <a href="{{ route('partner.reports') }}"
                class="sidebar-item {{ request()->routeIs('partner.reports*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold text-gray-500 dark:text-zinc-400 transition-all duration-300">
                <i class="fa-solid fa-landmark w-5 text-center"></i>
                <span>Pencairan</span>
            </a>

            <a href="{{ route('partner.settings') }}"
                class="sidebar-item {{ request()->routeIs('partner.settings*') ? 'sidebar-item-active' : '' }} flex items-center gap-3 px-4 py-3.5 rounded-2xl text-sm font-bold text-gray-500 dark:text-zinc-400 transition-all duration-300">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                <span>Pengaturan</span>
            </a>
        </nav>

        <div class="p-6 mt-auto">
            <div class="bg-gray-50 dark:bg-zinc-900 rounded-3xl p-4 mb-4">
                <p class="text-[10px] font-black text-gray-400 uppercase mb-2">Service Mode</p>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                    <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ Auth::user()->partner->service_type ?? 'Generic' }}</span>
                </div>
            </div>
            <a href="{{ route('partner.logout') }}"
                class="flex items-center justify-center gap-2 w-full py-4 rounded-2xl text-xs font-black text-red-500 hover:bg-red-50 dark:hover:bg-red-950/20 transition-all uppercase tracking-widest">
                <i class="fa-solid fa-power-off"></i>
                Logout
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow ml-72 flex flex-col min-w-0">
        <!-- Top Header -->
        <header class="h-24 bg-white/80 dark:bg-black/80 premium-blur flex items-center justify-between px-10 sticky top-0 z-40 transition-all duration-500 border-b border-gray-100 dark:border-zinc-900">
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 flex items-center justify-center text-gray-400 lg:hidden">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>
                <div class="hidden sm:flex flex-col">
                    <h1 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest">{{ request()->route()->getName() == 'partner.dashboard' ? 'Overview' : 'Manajemen' }}</h1>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-tighter mt-0.5">Voyago Business Network</p>
                </div>
            </div>

            <div class="flex items-center gap-6">
                <!-- System Alerts -->
                <button class="w-12 h-12 flex items-center justify-center text-gray-400 hover:text-orange-500 bg-gray-50 dark:bg-zinc-900 rounded-2xl transition-all relative">
                    <i class="fa-solid fa-bell text-lg"></i>
                    <span class="absolute top-3 right-3 w-2.5 h-2.5 bg-orange-500 border-2 border-white dark:border-black rounded-full"></span>
                </button>

                <!-- Profile -->
                <div class="flex items-center gap-4 bg-gray-50 dark:bg-zinc-900 pr-2 pl-6 py-2 rounded-2xl border border-gray-100 dark:border-zinc-800">
                    <div class="flex flex-col items-end">
                        <span class="text-xs font-black text-gray-900 dark:text-white leading-none">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-orange-500 font-bold mt-1 uppercase">Partner ID #{{ Auth::id() }}</span>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center overflow-hidden border-2 border-white dark:border-zinc-800 shadow-sm">
                        <img src="/images/Avatarprof.jpeg" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <div class="p-10 flex-grow max-w-[1600px] mx-auto w-full">
            @if(session('success'))
                <div class="bg-emerald-500 text-white px-8 py-5 rounded-[32px] mb-10 flex items-center justify-between shadow-xl shadow-emerald-500/20 animate-bounce">
                    <div class="flex items-center gap-4 font-black text-xs uppercase tracking-widest">
                        <i class="fa-solid fa-circle-check text-xl"></i>
                        {{ session('success') }}
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-white/60 hover:text-white transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            @yield('content')
        </div>

        <footer class="p-10 flex flex-col md:flex-row items-center justify-between gap-6 border-t border-gray-100 dark:border-zinc-900 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
            <p>&copy; 2026 Voyago Tech Ecosystem. All rights reserved.</p>
            <div class="flex items-center gap-8">
                <a href="#" class="hover:text-orange-500 transition-colors">Security</a>
                <a href="#" class="hover:text-orange-500 transition-colors">Terms</a>
                <a href="#" class="hover:text-orange-500 transition-colors">Privacy</a>
            </div>
        </footer>
    </main>
</body>

</html>