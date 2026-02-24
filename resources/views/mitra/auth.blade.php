<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voyago Business - Registrasi Mitra</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f1115;
        }

        .auth-accent {
            background: linear-gradient(135deg, #FF7304 0%, #FF8C2B 100%);
        }

        .input-focus:focus {
            border-color: #FF7304;
            box-shadow: 0 0 0 3px rgba(255, 115, 4, 0.1);
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div
        class="max-w-4xl w-full grid grid-cols-1 md:grid-cols-2 bg-white rounded shadow-2xl overflow-hidden border border-gray-100">
        <!-- Left Side: Branding -->
        <div class="relative hidden md:flex flex-col justify-between p-12 bg-[#0f1115] text-white overflow-hidden">
            <div class="absolute -top-24 -left-24 w-64 h-64 bg-orange-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-orange-500/5 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 auth-accent rounded flex items-center justify-center text-white">
                        <i class="fa-solid fa-paper-plane text-lg"></i>
                    </div>
                    <span class="text-xl font-bold tracking-tight">Voyago <span
                            class="text-orange-500">Business</span></span>
                </div>
                <h1 class="text-3xl font-bold leading-tight mb-4">Solusi Cerdas Pengelolaan Inventori Wisata</h1>
                <p class="text-sm text-gray-400 leading-relaxed">Bergabunglah dengan ribuan mitra kami di seluruh
                    Indonesia dan mulai digitalisasikan layanan Anda hari ini.</p>
            </div>

            <div class="relative z-10 space-y-6">
                <div class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-chart-line text-xs text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Analitik Tingkat Lanjut</p>
                        <p class="text-[11px] text-gray-500 mt-1">Pantau performa penjualan secara real-time dengan
                            dashboard intuitif.</p>
                    </div>
                </div>
                <div class="flex items-start gap-4">
                    <div
                        class="w-8 h-8 rounded bg-white/5 border border-white/10 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-shield-check text-xs text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wider text-gray-400">Pembayaran Terjamin</p>
                        <p class="text-[11px] text-gray-500 mt-1">Sistem pencairan dana yang transparan, aman, dan tepat
                            waktu.</p>
                    </div>
                </div>
            </div>

            <div class="relative z-10 pt-10 border-t border-white/10 mt-10">
                <p class="text-[10px] text-gray-500 font-medium">© 2026 Voyago Indonesia. Digitalizing Travel Industry.
                </p>
            </div>
        </div>

        <!-- Right Side: Interaction -->
        <div class="p-8 md:p-12 bg-white" x-data="{ isLogin: true }">
            <div class="flex gap-8 mb-8">
                <button @click="isLogin = true" class="pb-2 text-sm font-bold transition-all relative"
                    :class="isLogin ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-400 hover:text-gray-600'">
                    Masuk Akun
                </button>
                <button @click="isLogin = false" class="pb-2 text-sm font-bold transition-all relative"
                    :class="!isLogin ? 'text-gray-900 border-b-2 border-orange-500' : 'text-gray-400 hover:text-gray-600'">
                    Daftar Mitra
                </button>
            </div>

            @if($errors->any())
                <div
                    class="bg-red-50 border border-red-100 text-red-600 p-3 rounded text-[10px] font-bold mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('partner.auth.login') }}" method="POST" x-show="isLogin" class="fade-in">
                @csrf
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Email
                            Bisnis</label>
                        <div class="relative group">
                            <i
                                class="fa-solid fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-xs transition-colors group-focus-within:text-orange-500"></i>
                            <input type="email" name="email" required
                                class="w-full bg-gray-50 border border-gray-200 p-3 pl-10 rounded text-xs font-medium outline-none transition-all input-focus"
                                placeholder="name@company.com">
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between mb-2">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest">Password</label>
                            <a href="#" class="text-[9px] font-bold text-orange-500 hover:underline">Lupa Password?</a>
                        </div>
                        <div class="relative group">
                            <i
                                class="fa-solid fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-300 text-xs transition-colors group-focus-within:text-orange-500"></i>
                            <input type="password" name="password" required
                                class="w-full bg-gray-50 border border-gray-200 p-3 pl-10 rounded text-xs font-medium outline-none transition-all input-focus"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <div class="flex items-center gap-2 pt-2">
                        <input type="checkbox" id="remember"
                            class="w-3 h-3 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                        <label for="remember" class="text-[10px] text-gray-500 font-medium select-none">Ingat saya di
                            perangkat ini</label>
                    </div>
                    <button
                        class="w-full bg-gray-900 text-white py-3.5 rounded text-[11px] font-bold uppercase tracking-widest shadow-sm hover:bg-black transition-all flex items-center justify-center gap-2 mt-4">
                        Masuk Dashboard
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                    <p class="text-[9px] text-gray-400 text-center leading-relaxed">Gunakan akun partner yang telah
                        terverifikasi oleh tim Voyago.</p>
                </div>
            </form>

            <!-- Register Form -->
            <form action="{{ route('partner.auth.register') }}" method="POST" x-show="!isLogin" class="fade-in"
                style="display: none;">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Nama
                            Entitas Bisnis</label>
                        <input type="text" name="name" required
                            class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded text-xs font-medium outline-none transition-all input-focus"
                            placeholder="Contoh: PT. Travel Maju Jaya">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Email
                            Korespondensi</label>
                        <input type="email" name="email" required
                            class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded text-xs font-medium outline-none transition-all input-focus"
                            placeholder="sales@company.com">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Jenis
                            Layanan Utama</label>
                        <div class="relative">
                            <select name="service_type" required
                                class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded text-xs font-medium outline-none transition-all input-focus appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Kategori Bisnis</option>
                                <option value="Akomodasi (Hotel/Villa)">Akomodasi (Hotel/Villa/Resort)</option>
                                <option value="Maskapai (Pesawat)">Maskapai Penerbangan</option>
                                <option value="Operator Kereta">Operator Kereta Api</option>
                                <option value="Operator Bus">Layanan Bus & Travel</option>
                                <option value="Hiburan (Wisata/Event)">Lembaga Wisata & Rekreasi</option>
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 text-[10px] pointer-events-none"></i>
                        </div>
                    </div>
                    <div>
                        <label
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-1.5">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-gray-50 border border-gray-200 p-2.5 rounded text-xs font-medium outline-none transition-all input-focus"
                            placeholder="Min. 8 karakter">
                    </div>
                    <button
                        class="w-full bg-orange-500 text-white py-3.5 rounded text-[11px] font-bold uppercase tracking-widest shadow-sm hover:bg-orange-600 transition-all flex items-center justify-center gap-2 mt-4">
                        Daftar Jadi Mitra
                        <i class="fa-solid fa-user-plus text-[10px]"></i>
                    </button>
                    <p class="text-[9px] text-gray-400 text-center leading-relaxed">Dengan mendaftar, Anda menyetujui
                        Ketentuan Layanan & Kebijakan Privasi Voyago Business.</p>
                </div>
            </form>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>