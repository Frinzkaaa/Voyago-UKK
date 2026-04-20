<div id="section-prefs" class="settings-section hidden">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">Preferensi Aplikasi</h1>
    <div class="bg-white dark:bg-dark-card rounded-[24px] p-8 shadow-sm border border-gray-100 dark:border-dark-border space-y-6 transition-colors duration-300">
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Bahasa
                Display</label>
            <select
                class="w-full bg-[#FFFFFF] dark:bg-dark-card border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-sm">
                <option value="id" selected>Bahasa Indonesia</option>
                <option value="en">English (US)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Mata Uang</label>
            <select
                class="w-full bg-[#FFFFFF] dark:bg-dark-card border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none font-medium text-sm">
                <option value="idr" selected>IDR - Rupiah Indonesia</option>
                <option value="usd">USD - US Dollar</option>
            </select>
        </div>
        <div x-data="{ currentTheme: localStorage.getItem('voyago-theme') || 'light' }" 
             @theme-changed.window="currentTheme = $event.detail.theme">
            <label class="block text-xs font-bold text-gray-400 mb-2 uppercase tracking-wider">Tema</label>
            <div class="grid grid-cols-2 gap-4">
                <button @click="window.themeLogic.setTheme('light')"
                    :class="currentTheme === 'light' ? 'border-[#FF7304] text-[#FF7304] bg-white dark:bg-dark-card shadow-lg shadow-orange-500/10 scale-[1.02]' : 'border-gray-100 dark:border-dark-border bg-gray-50 dark:bg-[#121212] text-gray-400'"
                    class="p-4 border-2 rounded-2xl font-bold flex items-center justify-center gap-2 transition-all duration-300">
                    <i class="fa-solid fa-sun text-sm"></i> Light Mode
                </button>
                <button @click="window.themeLogic.setTheme('dark')"
                    :class="currentTheme === 'dark' ? 'border-[#FF7304] text-[#FF7304] bg-white dark:bg-dark-card shadow-lg shadow-orange-500/10 scale-[1.02]' : 'border-gray-100 dark:border-dark-border bg-gray-50 dark:bg-[#121212] text-gray-400'"
                    class="p-4 border-2 rounded-2xl font-bold flex items-center justify-center gap-2 transition-all duration-300">
                    <i class="fa-solid fa-moon text-sm"></i> Dark Mode
                </button>
            </div>
        </div>
    </div>
</div>