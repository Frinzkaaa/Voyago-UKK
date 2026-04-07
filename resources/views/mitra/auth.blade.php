<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyago Business - Registrasi Mitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #0c0c0e;
        }
        .auth-gradient {
            background: linear-gradient(135deg, #FF7304 0%, #FF903F 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 bg-[#0c0c0e]">
    <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 bg-white dark:bg-zinc-900 rounded-[40px] shadow-2xl overflow-hidden border border-gray-100 dark:border-zinc-800 transition-all duration-500">
        <!-- Left Side: Branding (Dark/Creative) -->
        <div class="relative hidden md:flex flex-col justify-between p-16 bg-[#0c0c0e] text-white">
            <!-- Animated Background Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-orange-500/10 rounded-full blur-[120px] -mr-48 -mt-48"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#FF7304]/10 rounded-full blur-[100px] -ml-32 -mb-32"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-16">
                    <div class="w-12 h-12 auth-gradient rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                        <i class="fa-solid fa-paper-plane text-xl text-white"></i>
                    </div>
                    <span class="text-2xl font-black tracking-tight">Voyago <span class="text-orange-500">Business</span></span>
                </div>
                <h1 class="text-4xl font-extrabold leading-[1.1] mb-6">Solusi Cerdas <br>Digitalisasi Wisata</h1>
                <p class="text-gray-400 font-medium leading-relaxed max-w-xs">Tingkatkan efisiensi operasional dan jangkau lebih banyak pelanggan secara global.</p>
            </div>

            <div class="relative z-10 space-y-10">
                <div class="flex items-start gap-5 group">
                    <div class="w-12 h-12 rounded-2xl glass-card flex items-center justify-center shrink-0 border border-white/5 transition-all group-hover:border-orange-500/30">
                        <i class="fa-solid fa-chart-pie text-lg text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-500 mb-1">Analitik Reall-Time</p>
                        <p class="text-[13px] text-gray-300">Pantau performa penjualan darimanapun secara instan.</p>
                    </div>
                </div>
                <div class="flex items-start gap-5 group">
                    <div class="w-12 h-12 rounded-2xl glass-card flex items-center justify-center shrink-0 border border-white/5 transition-all group-hover:border-orange-500/30">
                        <i class="fa-solid fa-wallet text-lg text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black uppercase tracking-[0.2em] text-gray-500 mb-1">Settlement Instan</p>
                        <p class="text-[13px] text-gray-300">Pencairan dana otomatis yang aman dan tepat waktu.</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 pt-10 border-t border-white/5 mt-16 flex items-center justify-between">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">© 2026 Voyago Indonesia</p>
                <div class="flex gap-4 opacity-50">
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-linkedin"></i>
                </div>
            </div>
        </div>

        <!-- Right Side: Form Content -->
        <div class="p-10 md:p-16 bg-white dark:bg-zinc-900 flex flex-col justify-center" x-data="{ isLogin: true }">
            <div class="flex gap-10 mb-12">
                <button @click="isLogin = true" class="pb-3 text-sm font-black transition-all relative uppercase tracking-widest"
                    :class="isLogin ? 'text-gray-900 dark:text-white border-b-4 border-orange-500' : 'text-gray-400 hover:text-gray-600 dark:text-zinc-500'">
                    Login
                </button>
                <button @click="isLogin = false" class="pb-3 text-sm font-black transition-all relative uppercase tracking-widest"
                    :class="!isLogin ? 'text-gray-900 dark:text-white border-b-4 border-orange-500' : 'text-gray-400 hover:text-gray-600 dark:text-zinc-500'">
                    Daftar
                </button>
            </div>

            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-900/10 border border-red-100 dark:border-red-900/20 text-red-500 p-4 rounded-2xl text-xs font-bold mb-8 flex items-center gap-3">
                    <i class="fa-solid fa-triangle-exclamation text-lg"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('partner.auth.login') }}" method="POST" x-show="isLogin" x-transition.opacity>
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2rem] mb-3">Email Bisnis</label>
                        <div class="relative group">
                            <i class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 dark:text-zinc-600 text-sm group-focus-within:text-orange-500 transition-colors"></i>
                            <input type="email" name="email" required
                                class="w-full bg-gray-50 dark:bg-zinc-800/40 border border-gray-100 dark:border-zinc-800 p-4 pl-12 rounded-2xl text-sm font-bold text-gray-800 dark:text-white outline-none focus:border-orange-500 transition-all placeholder:text-gray-300 dark:placeholder:text-zinc-700"
                                placeholder="nama@perusahaan.com">
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-3">
                            <label class="block text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2rem]">Password</label>
                            <a href="#" class="text-[10px] font-black text-orange-500 uppercase tracking-widest hover:underline">Lupa?</a>
                        </div>
                        <div class="relative group">
                            <i class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 dark:text-zinc-600 text-sm group-focus-within:text-orange-500 transition-colors"></i>
                            <input type="password" name="password" required
                                class="w-full bg-gray-50 dark:bg-zinc-800/40 border border-gray-100 dark:border-zinc-800 p-4 pl-12 rounded-2xl text-sm font-bold text-gray-800 dark:text-white outline-none focus:border-orange-500 transition-all placeholder:text-gray-300 dark:placeholder:text-zinc-700"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <button class="w-full bg-gray-900 dark:bg-white dark:text-gray-900 text-white py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl hover:bg-black dark:hover:bg-gray-100 transition-all flex items-center justify-center gap-3 mt-4 border-b-4 border-gray-700 dark:border-gray-200">
                        Masuk Dashboard
                        <i class="fa-solid fa-chevron-right text-[10px] opacity-50"></i>
                    </button>
                </div>
            </form>

            <!-- Register Form -->
            <form action="{{ route('partner.auth.register') }}" method="POST" x-show="!isLogin" x-transition.opacity style="display: none;">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2rem] mb-2">Nama Entitas Bisnis</label>
                        <input type="text" name="name" required
                            class="w-full bg-gray-50 dark:bg-zinc-800/40 border border-gray-100 dark:border-zinc-800 p-3.5 rounded-2xl text-sm font-bold text-gray-800 dark:text-white outline-none focus:border-orange-500 transition-all"
                            placeholder="PT. Sukses Selalu">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2rem] mb-2">Email Korespondensi</label>
                        <input type="email" name="email" required
                            class="w-full bg-gray-50 dark:bg-zinc-800/40 border border-gray-100 dark:border-zinc-800 p-3.5 rounded-2xl text-sm font-bold text-gray-800 dark:text-white outline-none focus:border-orange-500 transition-all"
                            placeholder="cs@perusahaan.com">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2rem] mb-2">Jenis Layanan</label>
                        <select name="service_type" required
                            class="w-full bg-gray-50 dark:bg-zinc-800/40 border border-gray-100 dark:border-zinc-800 p-3.5 px-5 rounded-2xl text-sm font-bold text-gray-800 dark:text-white outline-none focus:border-orange-500 transition-all appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih Kategori Bisnis</option>
                            <option value="Akomodasi (Hotel/Villa)">Akomodasi (Hotel/Villa)</option>
                            <option value="Maskapai (Pesawat)">Maskapai Penerbangan</option>
                            <option value="Operator Kereta">Operator Kereta Api</option>
                            <option value="Operator Bus">Layanan Bus & Travel</option>
                            <option value="Hiburan (Wisata/Event)">Wisata & Rekreasi</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2rem] mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-gray-50 dark:bg-zinc-800/40 border border-gray-100 dark:border-zinc-800 p-3.5 rounded-2xl text-sm font-bold text-gray-800 dark:text-white outline-none focus:border-orange-500 transition-all"
                            placeholder="Min. 8 karakter">
                    </div>
                    <button class="w-full bg-orange-500 text-white py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl shadow-orange-500/30 hover:bg-orange-600 transition-all flex items-center justify-center gap-3 mt-4 border-b-4 border-orange-700">
                        Daftar Sebagai Partner
                        <i class="fa-solid fa-plus text-[10px] opacity-50"></i>
                    </button>
                </div>
            </form>
            
            <div class="mt-8 pt-8 border-t border-gray-50 dark:border-zinc-800 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-widest hover:text-orange-500 transition-colors group">
                    <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
                    Kembali Ke Portal User
                </a>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>