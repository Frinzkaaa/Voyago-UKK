<div id="section-notif" class="settings-section hidden">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">Notifikasi</h1>
    <div class="bg-white dark:bg-dark-card rounded-[32px] p-6 md:p-10 shadow-sm border border-gray-100 dark:border-dark-border space-y-1 transition-colors duration-300">
        @foreach(['Promo & Diskon', 'Status Booking', 'Pengingat Perjalanan', 'Email Notification', 'Push Notification'] as $item)
            <div class="flex items-center justify-between py-5 group">
                <div class="flex-1 pr-6">
                    <p class="font-black text-gray-800 dark:text-white text-sm md:text-base mb-1 tracking-tight">{{ $item }}</p>
                    <p class="text-[10px] md:text-xs text-gray-400 dark:text-gray-500 font-medium leading-relaxed">Terima informasi {{ strtolower($item) }} terbaru Anda secara langsung.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer shrink-0">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-gray-200 dark:bg-white/10 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#FF7304] shadow-inner transition-all duration-300"></div>
                </label>
            </div>
            @if(!$loop->last)
            <div class="h-px bg-gray-50 dark:bg-white/5 mx-2"></div> @endif
        @endforeach
    </div>
</div>