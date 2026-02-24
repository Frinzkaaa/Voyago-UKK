<div class="bg-white rounded-[2rem] p-8 shadow-sm flex flex-col gap-6">
  <!-- Asal -->
  <div class="flex flex-col gap-2">
    <label class="font-bold text-gray-800 text-sm ml-1" id="label-origin">Asal</label>
    <div class="relative group">
      <div class="absolute left-4 top-1/2 -translate-y-1/2 text-orange-500 z-10">
        <i class="fas fa-map-marker-alt text-xl group-focus-within:scale-110 transition-transform"></i>
      </div>
      <select id="origin" onchange="performSearch()"
        class="w-full bg-white border-2 border-gray-100 rounded-2xl py-3 pl-12 pr-4 font-bold text-gray-800 focus:border-orange-500 focus:outline-none transition-all appearance-none cursor-pointer">
        <option value="">Pilih Asal</option>
      </select>
      <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none">
        <i class="fas fa-chevron-down text-xs"></i>
      </div>
    </div>
  </div>

  <!-- Swap Button -->
  <div class="flex justify-center -my-4 relative z-10">
    <button onclick="swapLocations()"
      class="bg-white border-2 border-gray-100 p-2 rounded-xl text-orange-500 hover:bg-orange-50 transition-all shadow-sm active:scale-95">
      <i class="fas fa-exchange-alt rotate-90"></i>
    </button>
  </div>

  <!-- Tujuan -->
  <div class="flex flex-col gap-2" id="dest-container">
    <label class="font-bold text-gray-800 text-sm ml-1" id="label-destination">Tujuan</label>
    <div class="relative group">
      <div class="absolute left-4 top-1/2 -translate-y-1/2 text-orange-500 z-10">
        <i class="fas fa-location-dot text-xl group-focus-within:scale-110 transition-transform"></i>
      </div>
      <select id="destination" onchange="performSearch()"
        class="w-full bg-white border-2 border-gray-100 rounded-2xl py-3 pl-12 pr-4 font-bold text-gray-800 focus:border-orange-500 focus:outline-none transition-all appearance-none cursor-pointer">
        <option value="">Pilih Tujuan</option>
      </select>
      <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none">
        <i class="fas fa-chevron-down text-xs"></i>
      </div>
    </div>
  </div>

  <!-- Jumlah Penumpang -->
  <div class="flex flex-col gap-2">
    <label class="font-bold text-gray-800 text-sm ml-1">Jumlah Penumpang</label>
    <div class="relative group">
      <div class="absolute left-4 top-1/2 -translate-y-1/2 text-orange-500">
        <i class="fas fa-users text-xl group-focus-within:scale-110 transition-transform"></i>
      </div>
      <input type="number" id="passengers" value="1" min="1" max="4"
        onchange="updateSeatLimit(); updatePaymentSummary();"
        class="w-full bg-white border-2 border-gray-100 rounded-2xl py-3 pl-12 pr-4 font-bold text-gray-800 focus:border-orange-500 focus:outline-none transition-all placeholder:text-gray-300">
    </div>
    <p class="text-[10px] font-bold text-gray-400 ml-1 italic">*Maksimal 4 tiket</p>
  </div>

  <!-- Kelas -->
  <div class="flex flex-col gap-2">
    <label class="font-bold text-gray-800 text-sm ml-1">Kelas</label>
    <div class="relative group">
      <div class="absolute left-4 top-1/2 -translate-y-1/2 text-orange-500">
        <i class="fas fa-couch text-xl group-focus-within:scale-110 transition-transform"></i>
      </div>
      <select id="class" onchange="performSearch()"
        class="w-full appearance-none bg-white border-2 border-gray-100 rounded-2xl py-3 pl-12 pr-4 font-bold text-gray-800 focus:border-orange-500 focus:outline-none transition-all placeholder:text-gray-300">
        <option value="All">Semua Kelas</option>
        <option value="Economy">Economy</option>
        <option value="Business">Business</option>
        <option value="Executive">Executive</option>
      </select>
      <div class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none">
        <i class="fas fa-chevron-down text-xs"></i>
      </div>
    </div>
  </div>

  <!-- Round Trip Toggle -->
  <div class="flex items-center gap-3 px-2">
    <label class="relative inline-flex items-center cursor-pointer">
      <input type="checkbox" id="round_trip" class="sr-only peer" onchange="toggleRoundTrip()">
      <div
        class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-500">
      </div>
      <span class="ml-3 text-sm font-bold text-gray-800">Pulang Pergi</span>
    </label>
  </div>

  <!-- Tanggal -->
  <div class="flex flex-col gap-4">
    <div class="flex flex-col gap-2">
      <label class="font-bold text-gray-800 text-sm ml-1">Tanggal Pergi</label>
      <div class="relative group">
        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-orange-500">
          <i class="fas fa-calendar-alt text-xl group-focus-within:scale-110 transition-transform"></i>
        </div>
        <input type="date" id="departure_date" onchange="performSearch()"
          class="w-full bg-white border-2 border-gray-100 rounded-2xl py-3 pl-12 pr-4 font-bold text-gray-800 focus:border-orange-500 focus:outline-none transition-all text-sm">
      </div>
    </div>

    <!-- Tanggal Pulang -->
    <div class="flex flex-col gap-2" id="return_date_container" style="display: none;">
      <label class="font-bold text-gray-800 text-sm ml-1">Tanggal Pulang</label>
      <div class="relative group">
        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-orange-500">
          <i class="fas fa-calendar-alt text-xl group-focus-within:scale-110 transition-transform"></i>
        </div>
        <input type="date" id="return_date" onchange="performSearch()"
          class="w-full bg-white border-2 border-gray-100 rounded-2xl py-3 pl-12 pr-4 font-bold text-gray-800 focus:border-orange-500 focus:outline-none transition-all text-sm">
      </div>
    </div>
  </div>

  <button onclick="performSearch()"
    class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-4 rounded-2xl shadow-lg shadow-orange-200 transition-all mt-4 transform active:scale-95 uppercase tracking-widest">
    Cari Tiket Sekarang
  </button>
</div>