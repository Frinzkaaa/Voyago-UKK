<aside class="w-full md:w-64 shrink-0 overflow-hidden">
    <div
        class="bg-white dark:bg-dark-card rounded-2xl md:rounded-[24px] p-2 md:p-6 shadow-sm border border-gray-100 dark:border-dark-border flex md:flex-col gap-1 md:gap-2 overflow-x-auto md:overflow-x-visible no-scrollbar transition-colors duration-300">
        <button onclick="switchSetting('security')" id="btn-security"
            class="flex-none md:flex-1 flex items-center gap-2 md:gap-3 px-4 md:px-5 py-2.5 md:py-3 rounded-full transition-all group active-nav">
            <i class="fa-solid fa-shield-halved text-base md:text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-bold text-xs md:text-sm whitespace-nowrap group-[.active-nav]:text-white text-gray-600 dark:text-[#A1A1AA]">Akun</span>
        </button>
        <button onclick="switchSetting('notif')" id="btn-notif"
            class="flex-none md:flex-1 flex items-center gap-2 md:gap-3 px-4 md:px-5 py-2.5 md:py-3 rounded-full transition-all group">
            <i class="fa-solid fa-bell text-base md:text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-bold text-xs md:text-sm whitespace-nowrap group-[.active-nav]:text-white text-gray-600 dark:text-[#A1A1AA]">Notif</span>
        </button>
        <button onclick="switchSetting('privacy')" id="btn-privacy"
            class="flex-none md:flex-1 flex items-center gap-2 md:gap-3 px-4 md:px-5 py-2.5 md:py-3 rounded-full transition-all group">
            <i class="fa-solid fa-lock text-base md:text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-bold text-xs md:text-sm whitespace-nowrap group-[.active-nav]:text-white text-gray-600 dark:text-[#A1A1AA]">Privasi</span>
        </button>
        <button onclick="switchSetting('prefs')" id="btn-prefs"
            class="flex-none md:flex-1 flex items-center gap-2 md:gap-3 px-4 md:px-5 py-2.5 md:py-3 rounded-full transition-all group">
            <i class="fa-solid fa-sliders text-base md:text-lg group-[.active-nav]:text-white text-gray-400"></i>
            <span class="font-bold text-xs md:text-sm whitespace-nowrap group-[.active-nav]:text-white text-gray-600 dark:text-[#A1A1AA]">Pref</span>
        </button>
        <div class="h-8 md:h-px w-px md:w-full bg-gray-100 dark:bg-dark-border mx-2 md:my-2"></div>
        <button onclick="switchSetting('delete')" id="btn-delete"
            class="flex-none md:flex-1 flex items-center gap-2 md:gap-3 px-4 md:px-5 py-2.5 md:py-3 rounded-full transition-all group hover:bg-red-50">
            <i class="fa-solid fa-trash-can text-base md:text-lg group-[.active-nav]:text-white text-red-400"></i>
            <span class="font-bold text-xs md:text-sm whitespace-nowrap group-[.active-nav]:text-white text-red-600">Hapus</span>
        </button>
    </div>
</aside>