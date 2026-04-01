<div id="section-security" class="settings-section">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">Akun & Keamanan</h1>
    <div class="bg-white dark:bg-dark-card rounded-[24px] p-8 shadow-sm border border-gray-100 dark:border-dark-border space-y-8 transition-colors duration-300">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Email
                    Utama</label>
                <div class="relative">
                    <input type="email" value="{{ auth()->user()->email }}" readonly
                        class="w-full bg-gray-50 dark:bg-[#121212] border-2 border-gray-50 dark:border-dark-border rounded-2xl px-5 py-3 text-gray-500 dark:text-[#A1A1AA] outline-none cursor-not-allowed">
                    <i class="fa-solid fa-lock absolute right-5 top-1/2 -translate-y-1/2 text-gray-300"></i>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Nomor
                    Telepon</label>
                <input type="text" value="{{ auth()->user()->phone ?? '' }}" placeholder="+62 812 3456 7890"
                    name="phone"
                    class="w-full bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-2xl px-5 py-3 focus:border-orange-100 outline-none transition-al transition-colors duration-300l">
            </div>
        </div>

        <div class="pt-6 border-t border-gray-100 dark:border-dark-border">
            <h3 class="font-bold text-gray-800 dark:text-white mb-4">Password & Keamanan</h3>
            <div class="flex items-center justify-between p-4 bg-orange-50/50 rounded-2xl mb-4 text-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                        <i class="fa-solid fa-shield-check"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 dark:text-white">Two-factor Authentication (2FA)</p>
                        <p class="text-xs text-gray-500 dark:text-[#A1A1AA]">Amankan akun Anda dengan verifikasi tambahan.</p>
                    </div>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white dark:bg-dark-card after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#FF7304] transition-colors duration-300">
                    </div>
                </label>
            </div>
            <button
                class="px-6 py-3 border-2 border-[#FF7304] text-[#FF7304] font-bold rounded-full text-sm hover:bg-[#FF7304] hover:text-white transition-all">Ganti
                Password</button>
        </div>

        <div class="pt-6 border-t border-gray-100 dark:border-dark-border">
            <h3 class="font-bold text-gray-800 dark:text-white mb-4">Aktivitas Login Terakhir</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between text-xs p-3 bg-gray-50 dark:bg-[#121212] rounded-xl">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-desktop text-gray-400"></i>
                        <span>Chrome di Windows (Sesi ini)</span>
                    </div>
                    <span class="font-bold text-green-500 uppercase">Aktif</span>
                </div>
                <div class="flex items-center justify-between text-xs p-3 bg-gray-100 dark:bg-dark-border/50 rounded-xl text-gray-400">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-mobile-screen"></i>
                        <span>Voyago App di iPhone 13</span>
                    </div>
                    <span>2 jam yang lalu</span>
                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button
                class="px-8 py-3 bg-[#FF7304] text-white rounded-full font-bold shadow-lg shadow-orange-100 hover:scale-105 transition-all">Update
                Security</button>
        </div>
    </div>
</div>