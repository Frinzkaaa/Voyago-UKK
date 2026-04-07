<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyago Admin - Premium Dashboard</title>
    <!-- Tailwind CDN & Config -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: {
                            bg: '#0F172A',
                            card: '#1E293B',
                            border: '#334155'
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
/* ... (existing styles) ... */
        .sidebar-item.active {
            background-color: #FF7304;
            color: white !important;
            box-shadow: 0 12px 20px -5px rgba(255, 115, 4, 0.4);
        }

        .sidebar-item:not(.active):hover {
            background-color: #FFF7ED;
            color: #FF7304 !important;
        }

        .dark .sidebar-item:not(.active):hover {
            background-color: #1E293B;
            color: #FF7304 !important;
        }

        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #E5E7EB;
            border-radius: 10px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #334155;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #D1D5DB;
        }
    </style>

    <script>
        // Initialize Theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        // Circular Reveal Function
        async function toggleDarkMode(event) {
            const x = event.clientX;
            const y = event.clientY;
            const endRadius = Math.hypot(
                Math.max(x, innerWidth - x),
                Math.max(y, innerHeight - y)
            );

            if (!document.startViewTransition) {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
                return;
            }

            const transition = document.startViewTransition(() => {
                const isDark = document.documentElement.classList.toggle('dark');
                localStorage.setItem('theme', isDark ? 'dark' : 'light');
            });

            await transition.ready;

            document.documentElement.animate(
                {
                    clipPath: [
                        `circle(0px at ${x}px ${y}px)`,
                        `circle(${endRadius}px at ${x}px ${y}px)`,
                    ],
                },
                {
                    duration: 500,
                    easing: 'ease-in-out',
                    pseudoElement: document.documentElement.classList.contains('dark')
                        ? '::view-transition-new(root)'
                        : '::view-transition-new(root)',
                }
            );
        }
    </script>
</head>

<body class="flex min-h-screen text-gray-800 dark:text-gray-100 bg-[#F8F9FB] dark:bg-dark-bg transition-colors" x-data="{ sidebarOpen: false }">
    <!-- Sidebar Overlay (Mobile) -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[60] lg:hidden">
    </div>

    <!-- Sidebar -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="w-24 bg-white dark:bg-dark-card border-r border-gray-100 dark:border-dark-border flex flex-col items-center py-8 shrink-0 fixed h-full z-[70] transition-all duration-300 transform lg:translate-x-0 shadow-2xl lg:shadow-none">
        
        <div class="lg:hidden absolute top-4 right-4">
            <button @click="sidebarOpen = false" class="text-gray-400 hover:text-orange-500">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <a href="/" class="mb-12">
            <img src="/images/Logo.png" alt="Voyago" class="w-10 brightness-100 dark:brightness-110">
        </a>

        <nav class="flex flex-col gap-6 w-full px-4 text-gray-400">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }} w-full aspect-square rounded-2xl flex items-center justify-center transition-all hover:text-[#FF7304]">
                <i class="fa-solid fa-table-cells-large text-xl"></i>
            </a>
            <a href="{{ route('admin.verifikasi.mitra') }}"
                class="sidebar-item {{ request()->routeIs('admin.verifikasi.mitra') ? 'active' : '' }} w-full aspect-square rounded-2xl flex items-center justify-center transition-all hover:text-[#FF7304]">
                <i class="fa-solid fa-handshake text-xl"></i>
            </a>
            <a href="{{ route('admin.monitoring.transaksi') }}"
                class="sidebar-item {{ request()->routeIs('admin.monitoring.transaksi') ? 'active' : '' }} w-full aspect-square rounded-2xl flex items-center justify-center transition-all hover:text-[#FF7304]">
                <i class="fa-solid fa-clipboard-list text-xl"></i>
            </a>
            <a href="{{ route('admin.monitoring.komplain') }}"
                class="sidebar-item {{ request()->routeIs('admin.monitoring.komplain') ? 'active' : '' }} w-full aspect-square rounded-2xl flex items-center justify-center transition-all hover:text-[#FF7304]">
                <i class="fa-solid fa-headset text-xl"></i>
            </a>
            <a href="{{ route('admin.cetak.laporan') }}"
                class="sidebar-item {{ request()->routeIs('admin.cetak.laporan') ? 'active' : '' }} w-full aspect-square rounded-2xl flex items-center justify-center transition-all hover:text-[#FF7304]">
                <i class="fa-solid fa-chart-pie text-xl"></i>
            </a>
        </nav>

        <div class="mt-auto">
            <a href="{{ route('partner.logout') }}"
                class="w-full aspect-square rounded-2xl flex items-center justify-center text-gray-400 hover:text-red-500 transition-all">
                <i class="fa-solid fa-arrow-right-from-bracket text-xl rotate-180"></i>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow lg:ml-24 flex flex-col min-w-0 bg-[#F8F9FB] dark:bg-dark-bg transition-colors min-h-screen">
        <!-- Header -->
        <header
            class="px-4 lg:px-8 py-6 flex items-center justify-between sticky top-0 z-40 bg-[#F8F9FB]/80 dark:bg-dark-bg/80 backdrop-blur-md border-b border-gray-100 dark:border-dark-border lg:border-none">
            
            <div class="flex items-center gap-4 lg:gap-10 flex-grow max-w-4xl">
                <button @click="sidebarOpen = true" class="lg:hidden w-11 h-11 flex items-center justify-center bg-white dark:bg-dark-card rounded-2xl border dark:border-dark-border shadow-sm text-gray-500">
                    <i class="fa-solid fa-bars-staggered"></i>
                </button>

                <div class="relative w-full group hidden md:block">
                    <i
                        class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-orange-400 group-focus-within:scale-110 transition-transform"></i>
                    <input type="text" placeholder="Cari apapun..."
                        class="w-full bg-white dark:bg-dark-card border border-gray-100 dark:border-dark-border rounded-full py-3.5 pl-14 pr-6 shadow-sm focus:ring-4 focus:ring-orange-50 dark:focus:ring-orange-900/10 focus:border-orange-200 outline-none text-sm transition-all dark:text-gray-100">
                </div>
            </div>

            <div class="flex items-center gap-2 lg:gap-4 ml-6">
                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode(event)"
                    class="w-11 h-11 lg:w-12 lg:h-12 bg-white dark:bg-dark-card rounded-2xl border dark:border-dark-border shadow-sm text-orange-400 hover:scale-105 transition-all flex items-center justify-center">
                    <i class="fa-solid fa-moon dark:hidden"></i>
                    <i class="fa-solid fa-sun hidden dark:block text-yellow-400"></i>
                </button>

                <button
                    class="w-11 h-11 lg:w-12 lg:h-12 bg-white dark:bg-dark-card rounded-2xl border dark:border-dark-border shadow-sm text-orange-400 hover:scale-105 transition-all flex items-center justify-center relative">
                    <i class="fa-solid fa-bell"></i>
                    <span
                        class="absolute top-3 right-3 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-dark-card"></span>
                </button>
                <div class="relative">
                    <img src="/images/Avatarprof.jpeg" alt="Admin"
                        class="w-10 h-10 lg:w-12 lg:h-12 rounded-2xl border-2 border-white dark:border-dark-border shadow-sm object-cover">
                </div>
            </div>
        </header>

        <div class="px-6 lg:px-8 pb-12 flex-grow overflow-x-hidden">
            @if(session('success'))
                <div
                    class="bg-green-50 dark:bg-green-900/10 border border-green-100 dark:border-green-800 text-green-700 dark:text-green-400 px-6 py-4 rounded-2xl mb-8 flex items-center gap-3 animate-bounce">
                    <i class="fa-solid fa-circle-check"></i>
                    <span class="font-bold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</body>

</html>