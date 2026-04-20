<div class="flex overflow-x-auto md:grid md:grid-cols-5 gap-4 bg-white dark:bg-dark-card rounded-3xl p-4 md:p-6 shadow-sm flex-1 transition-colors duration-300 no-scrollbar">
  <button type="button" onclick="selectCategory('kereta', this)"
    class="category-tab active-tab flex flex-col items-center gap-2 group shrink-0 px-2 min-w-[80px]">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors shadow-sm pointer-events-none">
      <i class="fa-solid fa-train text-2xl text-[#FA812F] group-[.active-tab]:text-white pointer-events-none"></i>
    </div>
    <span class="font-bold text-sm md:text-lg group-[.active-tab]:text-orange-500 text-gray-400 pointer-events-none">Kereta</span>
  </button>
  <button type="button" onclick="selectCategory('pesawat', this)" class="category-tab flex flex-col items-center gap-2 group shrink-0 px-2 min-w-[80px]">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors shadow-sm pointer-events-none">
      <i class="fa-solid fa-plane text-2xl text-[#FA812F] group-[.active-tab]:text-white pointer-events-none"></i>
    </div>
    <span class="font-bold text-sm md:text-lg text-gray-400 group-[.active-tab]:text-orange-500 pointer-events-none">Pesawat</span>
  </button>
  <button type="button" onclick="selectCategory('bus', this)" class="category-tab flex flex-col items-center gap-2 group shrink-0 px-2 min-w-[80px]">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors shadow-sm overflow-hidden relative pointer-events-none">
      <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=100&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20 group-[.active-tab]:opacity-40 pointer-events-none">
      <i class="fa-solid fa-bus text-2xl text-[#FA812F] group-[.active-tab]:text-white relative z-10 pointer-events-none"></i>
    </div>
    <span class="font-bold text-sm md:text-lg text-gray-400 group-[.active-tab]:text-orange-500 pointer-events-none">Bus</span>
  </button>
  <button type="button" onclick="selectCategory('hotel', this)" class="category-tab flex flex-col items-center gap-2 group shrink-0 px-2 min-w-[80px]">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors shadow-sm overflow-hidden relative pointer-events-none">
      <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=100&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20 group-[.active-tab]:opacity-40 pointer-events-none">
      <i class="fa-solid fa-hotel text-2xl text-[#FA812F] group-[.active-tab]:text-white relative z-10 pointer-events-none"></i>
    </div>
    <span class="font-bold text-sm md:text-lg text-gray-400 group-[.active-tab]:text-orange-500 pointer-events-none">Hotel</span>
  </button>
  <button type="button" onclick="selectCategory('wisata', this)" class="category-tab flex flex-col items-center gap-2 group shrink-0 px-2 min-w-[80px]">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors shadow-sm overflow-hidden relative pointer-events-none">
      <img src="https://images.unsplash.com/photo-1502602898657-3e91760cbb34?q=80&w=100&auto=format&fit=crop" class="absolute inset-0 w-full h-full object-cover opacity-20 group-[.active-tab]:opacity-40 pointer-events-none">
      <i class="fa-solid fa-mountain-sun text-2xl text-[#FA812F] group-[.active-tab]:text-white relative z-10 pointer-events-none"></i>
    </div>
    <span class="font-bold text-sm md:text-lg text-gray-400 group-[.active-tab]:text-orange-500 pointer-events-none">Wisata</span>
  </button>
</div>

<style>
  .active-tab .w-14 {
    background-color: #FA812F !important;
  }

  .active-tab img {
    filter: brightness(0) invert(1);
  }

  .active-tab span {
    color: #FA812F !important;
  }
</style>