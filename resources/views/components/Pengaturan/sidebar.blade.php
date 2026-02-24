<aside class="w-full md:w-64 shrink-0">
    <div
        class="bg-white rounded-[24px] p-6 shadow-sm border border-gray-100 flex md:flex-col gap-2 overflow-x-auto md:overflow-x-visible">
        <button onclick="switchSetting('security')" id="btn-security"
            class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group active-nav">
            <i class="fa-solid fa-shield-halved text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Akun &
                Keamanan</span>
        </button>
        <button onclick="switchSetting('notif')" id="btn-notif"
            class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group">
            <i class="fa-solid fa-bell text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Notifikasi</span>
        </button>
        <button onclick="switchSetting('payment')" id="btn-payment"
            class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group">
            <i class="fa-solid fa-credit-card text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Pembayaran</span>
        </button>
        <button onclick="switchSetting('privacy')" id="btn-privacy"
            class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group">
            <i class="fa-solid fa-lock text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Privasi</span>
        </button>
        <button onclick="switchSetting('prefs')" id="btn-prefs"
            class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group">
            <i class="fa-solid fa-sliders text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-gray-600">Preferensi</span>
        </button>
        <div class="h-px bg-gray-100 my-2 hidden md:block"></div>
        <button onclick="switchSetting('delete')" id="btn-delete"
            class="flex items-center gap-3 px-5 py-3 rounded-full w-full transition-all group hover:bg-red-50">
            <i class="fa-solid fa-trash-can text-lg group-[.active-nav]:text-white text-red-400"></i>
            <span class="font-semibold whitespace-nowrap group-[.active-nav]:text-white text-red-600">Hapus
                Akun</span>
        </button>
    </div>
</aside>