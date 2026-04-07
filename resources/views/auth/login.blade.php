<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Voyago - Your Travel Partner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #fcfcfc;
        }
        .bg-auth {
            background-image: radial-gradient(circle at 0% 0%, rgba(255, 115, 4, 0.05) 0%, transparent 50%),
                              radial-gradient(circle at 100% 100%, rgba(255, 115, 4, 0.05) 0%, transparent 50%);
        }
        .auth-card {
            border-radius: 32px;
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6 bg-auth dark:bg-[#09090b] transition-colors duration-500">
    <div class="max-w-md w-full" x-data="{ isLogin: true }">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white dark:bg-zinc-900 rounded-[22px] shadow-lg mb-6 border border-gray-100 dark:border-zinc-800 transition-all">
                <i class="fas fa-paper-plane text-[#FF7304] text-2xl"></i>
            </div>
            <h1 class="text-3xl font-black text-gray-900 dark:text-white tracking-tight">Voyago</h1>
            <p class="text-gray-500 dark:text-zinc-400 mt-2 font-medium" x-text="isLogin ? 'Selamat datang kembali, Penjelajah!' : 'Mari mulai perjalanan baru bersamamu!'"></p>
        </div>

        <div class="bg-white dark:bg-zinc-900 p-6 md:p-10 auth-card border border-gray-100 dark:border-zinc-800 relative overflow-hidden transition-all duration-300">
            <!-- Form Header/Toggle -->
            <div class="flex p-1.5 bg-gray-100/80 dark:bg-zinc-800/50 rounded-[18px] mb-8">
                <button @click="isLogin = true" :class="isLogin ? 'bg-white dark:bg-zinc-700 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-zinc-400'"
                    class="flex-1 py-2.5 text-sm font-black rounded-[14px] transition-all">Masuk</button>
                <button @click="isLogin = false" :class="!isLogin ? 'bg-white dark:bg-zinc-700 shadow-sm text-gray-900 dark:text-white' : 'text-gray-500 dark:text-zinc-400'"
                    class="flex-1 py-2.5 text-sm font-black rounded-[14px] transition-all">Daftar</button>
            </div>

            @if($errors->any())
                <div class="bg-red-50 dark:bg-red-900/10 text-red-500 text-xs font-bold p-4 rounded-2xl mb-6 flex items-start gap-3 border border-red-100 dark:border-red-900/20">
                    <i class="fas fa-circle-exclamation text-base mt-0.5"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" x-show="isLogin" x-transition.opacity>
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-2.5 block">Alamat Email</label>
                        <div class="relative group">
                            <i class="far fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#FF7304] transition-colors"></i>
                            <input type="email" name="email" required
                                class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-zinc-800/50 border border-gray-200 dark:border-zinc-700 rounded-2xl outline-none focus:ring-2 focus:ring-[#FF7304]/10 focus:border-[#FF7304] transition-all text-sm font-bold text-gray-800 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-600"
                                placeholder="nama@email.com">
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between items-center mb-2.5">
                            <label class="text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] block">Password</label>
                            <a href="#" class="text-[10px] font-black text-[#FF7304] uppercase tracking-widest hover:underline">Lupa?</a>
                        </div>
                        <div class="relative group">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#FF7304] transition-colors"></i>
                            <input type="password" name="password" required
                                class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-zinc-800/50 border border-gray-200 dark:border-zinc-700 rounded-2xl outline-none focus:ring-2 focus:ring-[#FF7304]/10 focus:border-[#FF7304] transition-all text-sm font-bold text-gray-800 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-600"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <button class="w-full bg-[#FF7304] text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-[#e66700] transform active:scale-95 transition-all shadow-2xl shadow-orange-500/30 mt-2 border-b-4 border-orange-700">
                        Masuk Sekarang
                        <i class="fas fa-chevron-right ml-2 text-[10px] opacity-50"></i>
                    </button>
                </div>
            </form>

            <!-- Register Form -->
            <form action="{{ route('register.post') }}" method="POST" x-show="!isLogin" x-transition.opacity style="display: none;">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-2.5 block">Nama Lengkap</label>
                        <div class="relative group">
                            <i class="far fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#FF7304] transition-colors"></i>
                            <input type="text" name="name" required
                                class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-zinc-800/50 border border-gray-200 dark:border-zinc-700 rounded-2xl outline-none focus:ring-2 focus:ring-[#FF7304]/10 focus:border-[#FF7304] transition-all text-sm font-bold text-gray-800 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-600"
                                placeholder="Nama Lengkap">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-2.5 block">Email</label>
                        <div class="relative group">
                            <i class="far fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#FF7304] transition-colors"></i>
                            <input type="email" name="email" required
                                class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-zinc-800/50 border border-gray-200 dark:border-zinc-700 rounded-2xl outline-none focus:ring-2 focus:ring-[#FF7304]/10 focus:border-[#FF7304] transition-all text-sm font-bold text-gray-800 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-600"
                                placeholder="your@email.com">
                        </div>
                    </div>
                    <div>
                        <label class="text-[10px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-2.5 block">Password</label>
                        <div class="relative group">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#FF7304] transition-colors"></i>
                            <input type="password" name="password" required
                                class="w-full pl-12 pr-4 py-4 bg-gray-50 dark:bg-zinc-800/50 border border-gray-200 dark:border-zinc-700 rounded-2xl outline-none focus:ring-2 focus:ring-[#FF7304]/10 focus:border-[#FF7304] transition-all text-sm font-bold text-gray-800 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-600"
                                placeholder="Min. 6 karakter">
                        </div>
                    </div>
                    <button class="w-full bg-[#FF7304] text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] hover:bg-[#e66700] transform active:scale-95 transition-all shadow-2xl shadow-orange-500/30 mt-2 border-b-4 border-orange-700">
                        Buat Akun Baru
                        <i class="fas fa-plus ml-2 text-[10px] opacity-50"></i>
                    </button>
                </div>
            </form>

            <div class="mt-10 flex items-center justify-between gap-4">
                <div class="h-px bg-gray-100 dark:bg-zinc-800 flex-1"></div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest whitespace-nowrap">Atau Media Sosial</span>
                <div class="h-px bg-gray-100 dark:bg-zinc-800 flex-1"></div>
            </div>

            <div class="mt-8">
                <a href="{{ route('auth.google') }}" class="w-full py-4.5 bg-white dark:bg-zinc-800 rounded-2xl flex items-center justify-center gap-4 hover:bg-gray-50 dark:hover:bg-zinc-700 transition-all border-2 border-gray-100 dark:border-zinc-800 shadow-md group">
                    <img src="https://www.gstatic.com/images/branding/product/1x/gsa_512dp.png" class="w-6 h-6 group-hover:scale-110 transition-transform" alt="Google">
                    <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">Lanjutkan dengan Google</span>
                </a>
            </div>
        </div>

        <div class="mt-8 text-center px-6">
            <p class="text-xs font-bold text-gray-400 dark:text-zinc-500 leading-relaxed">
                Punya bisnis properti atau transportasi? <br>
                <a href="{{ route('partner.auth.page') }}" class="text-[#FF7304] hover:underline">Gabung sebagai Mitra Voyago & Digitalisasikan Layananmu</a>
            </p>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        // Check for theme
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>