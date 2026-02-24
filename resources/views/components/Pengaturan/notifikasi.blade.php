<div id="section-notif" class="settings-section hidden">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Notifikasi</h1>
    <div class="bg-white rounded-[24px] p-8 shadow-sm border border-gray-100 space-y-6">
        @foreach(['Promo & Diskon', 'Status Booking', 'Pengingat Perjalanan', 'Email Notification', 'Push Notification'] as $item)
            <div class="flex items-center justify-between py-2">
                <div>
                    <p class="font-bold text-gray-800">{{ $item }}</p>
                    <p class="text-xs text-gray-500">Dapatkan informasi terbaru mengenai {{ strtolower($item) }}
                        Anda.</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div
                        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#FF7304]">
                    </div>
                </label>
            </div>
            @if(!$loop->last)
            <div class="h-px bg-gray-50"></div> @endif
        @endforeach
    </div>
</div>