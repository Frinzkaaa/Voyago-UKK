<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Voyago - Your Travel Partner</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8fafc;
        }

        .auth-card {
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.05);
        }

        .input-focus:focus {
            border-color: #FF7304;
            box-shadow: 0 0 0 4px rgba(255, 115, 4, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full" x-data="{ isLogin: true }">
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-2 text-2xl font-bold text-[#FF7304]">
                <i class="fas fa-paper-plane"></i> Voyago
            </a>
            <p class="text-gray-500 mt-2" x-text="isLogin ? 'Masuk ke akun penjelajahmu' : 'Mulai petualangan barumu'">
            </p>
        </div>

        <div class="bg-white p-8 auth-card">
            @if(session('success'))
                <div
                    class="bg-green-50 text-green-600 p-4 rounded-xl mb-6 text-sm flex items-center gap-3 border border-green-100 animate-fade-in">
                    <i class="fas fa-circle-check text-lg"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Toggle Tabs -->
            <div class="flex p-1 bg-gray-100 rounded-xl mb-8">
                <button @click="isLogin = true" :class="isLogin ? 'bg-white shadow-sm text-[#FF7304]' : 'text-gray-500'"
                    class="flex-1 py-2 text-sm font-bold rounded-lg transition-all">Masuk</button>
                <button @click="isLogin = false"
                    :class="!isLogin ? 'bg-white shadow-sm text-[#FF7304]' : 'text-gray-500'"
                    class="flex-1 py-2 text-sm font-bold rounded-lg transition-all">Daftar</button>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-500 p-4 rounded-xl mb-6 text-sm flex items-center gap-3">
                    <i class="fas fa-circle-exclamation text-lg"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" x-show="isLogin" x-transition>
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Email</label>
                        <div class="relative">
                            <i class="far fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" name="email" required
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-50 rounded-xl outline-none input-focus transition-all"
                                placeholder="your@email.com">
                        </div>
                    </div>
                    <div>
                        <label
                            class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" name="password" required
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-50 rounded-xl outline-none input-focus transition-all"
                                placeholder="••••••••">
                        </div>
                    </div>
                    <div class="text-right">
                        <a href="#" class="text-xs font-bold text-[#FF7304] hover:underline">Lupa Password?</a>
                    </div>
                    <button
                        class="w-full bg-[#FF7304] text-white py-4 rounded-xl font-bold hover:bg-[#e66700] transition-colors shadow-lg shadow-orange-100">Masuk
                        Sekarang</button>
                </div>
            </form>

            <!-- Register Form -->
            <form action="{{ route('register.post') }}" method="POST" x-show="!isLogin" x-transition
                style="display: none;">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Nama
                            Lengkap</label>
                        <div class="relative">
                            <i class="far fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="text" name="name" required
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-50 rounded-xl outline-none input-focus transition-all"
                                placeholder="Nama Anda">
                        </div>
                    </div>
                    <div>
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Email</label>
                        <div class="relative">
                            <i class="far fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="email" name="email" required
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-50 rounded-xl outline-none input-focus transition-all"
                                placeholder="your@email.com">
                        </div>
                    </div>
                    <div>
                        <label
                            class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2 block">Password</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input type="password" name="password" required
                                class="w-full pl-12 pr-4 py-3 bg-gray-50 border-2 border-gray-50 rounded-xl outline-none input-focus transition-all"
                                placeholder="Min. 6 karakter">
                        </div>
                    </div>
                    <button
                        class="w-full bg-[#FF7304] text-white py-4 rounded-xl font-bold hover:bg-[#e66700] transition-colors shadow-lg shadow-orange-100">Daftar
                        Akun</button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-center gap-4">
                <span class="text-xs text-gray-400">Atau masuk dengan</span>
                <div class="flex gap-3">
                    <button
                        class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors"><i
                            class="fab fa-google text-gray-600"></i></button>
                    <button
                        class="w-10 h-10 rounded-lg border border-gray-200 flex items-center justify-center hover:bg-gray-50 transition-colors"><i
                            class="fab fa-facebook-f text-gray-600"></i></button>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">Punya bisnis properti atau transportasi? <br>
                <a href="{{ route('partner.auth.page') }}" class="font-bold text-[#FF7304] hover:underline">Gabung
                    sebagai Mitra Voyago</a>
            </p>
        </div>
    </div>

    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</body>

</html>