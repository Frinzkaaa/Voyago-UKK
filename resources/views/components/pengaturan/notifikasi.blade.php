<div id="section-notif" class="settings-section hidden">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">Notifikasi</h1>
    <div class="bg-white dark:bg-dark-card rounded-[24px] p-8 shadow-sm border border-gray-100 dark:border-dark-border space-y-6 transition-colors duration-300">
        @foreach(['Promo & Diskon', 'Status Booking', 'Pengingat Perjalanan', 'Email Notification', 'Push Notification'] as $item)
            <div class="flex items-center justify-between py-2">
                <div>
                    <p class="font-bold text-gray-800 dark:text-white">{{ $item }}</p>
                    <p class="text-xs text-gray-500 dark:text-[#A1A1AA]">Dapatkan informasi terbaru mengenai {{ strtolower($item) }}
                        Anda.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white dark:bg-dark-card after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#FF7304] transition-colors duration-300">
                    </div>
                </label>
            </div>
            @if(!$loop->last)
            <div class="h-px bg-gray-50 dark:bg-[#121212]"></div> @endif
        @endforeach
    </div>
</div>