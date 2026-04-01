<div class="grid grid-cols-5 bg-white dark:bg-dark-card rounded-3xl p-6 shadow-sm flex-1 transition-colors duration-300">
  <button onclick="selectCategory('kereta', this)"
    class="category-tab active-tab flex flex-col items-center gap-2 group">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors">
      <i class="fa-solid fa-train text-2xl text-[#FA812F] group-[.active-tab]:text-white"></i>
    </div>
    <span class="font-bold text-lg group-[.active-tab]:text-orange-500 text-gray-400">Kereta</span>
  </button>
  <button onclick="selectCategory('pesawat', this)" class="category-tab flex flex-col items-center gap-2 group">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors">
      <i class="fa-solid fa-plane text-2xl text-[#FA812F] group-[.active-tab]:text-white"></i>
    </div>
    <span class="font-bold text-lg text-gray-400 group-[.active-tab]:text-orange-500">Pesawat</span>
  </button>
  <button onclick="selectCategory('bus', this)" class="category-tab flex flex-col items-center gap-2 group">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors">
      <i class="fa-solid fa-bus text-2xl text-[#FA812F] group-[.active-tab]:text-white"></i>
    </div>
    <span class="font-bold text-lg text-gray-400 group-[.active-tab]:text-orange-500">Bus</span>
  </button>
  <button onclick="selectCategory('hotel', this)" class="category-tab flex flex-col items-center gap-2 group">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors">
      <i class="fa-solid fa-hotel text-2xl text-[#FA812F] group-[.active-tab]:text-white"></i>
    </div>
    <span class="font-bold text-lg text-gray-400 group-[.active-tab]:text-orange-500">Hotel</span>
  </button>
  <button onclick="selectCategory('wisata', this)" class="category-tab flex flex-col items-center gap-2 group">
    <div
      class="w-14 h-14 rounded-2xl flex items-center justify-center bg-orange-50 dark:bg-[#121212] group-[.active-tab]:bg-orange-500 transition-colors">
      <i class="fa-solid fa-mountain-sun text-2xl text-[#FA812F] group-[.active-tab]:text-white"></i>
    </div>
    <span class="font-bold text-lg text-gray-400 group-[.active-tab]:text-orange-500">Wisata</span>
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