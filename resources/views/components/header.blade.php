<!-- Header/Navbar Component -->
<header id="main-header" class="py-2 px-6 sticky top-0 z-50 transition-all duration-500 ease-in-out dark:bg-dark-bg/40">
  <div class="flex items-center gap-3">

    <!-- Logo Section -->
    <div
      class="bg-white dark:bg-dark-card rounded-[20px] flex items-center justify-center min-w-[60px] min-h-[60px] shadow-sm border dark:border-dark-border">
      <div class="flex flex-col items-center">
        <img src="/images/logo.png" alt="Logo" srcset="" class="h-14 brightness-100 dark:brightness-110">
      </div>
    </div>

    <!-- Navigation Section -->
    <nav
      class="bg-white dark:bg-dark-card rounded-[20px] flex items-center justify-around py-3 px-10 shadow-sm flex-grow border dark:border-dark-border">
      <a href="/"
        class="flex items-center gap-2 {{ request()->is('/') ? 'text-[#FF7304]' : 'text-[#000000] dark:text-gray-300' }} font-semibold text-[14px] hover:text-[#FF7304] transition-colors whitespace-nowrap">
        <i class="fa-solid fa-house text-md"></i>
        <span>Beranda</span>
      </a>
      @auth
        <a href="/pemesanan"
          class="flex items-center gap-2 {{ request()->is('pemesanan') ? 'text-[#FF7304]' : 'text-[#000000] dark:text-gray-300' }} font-semibold text-[14px] hover:text-[#FF7304] transition-colors whitespace-nowrap">
          <i class="fa-solid fa-briefcase text-md"></i>
          <span>Pemesanan</span>
        </a>
        <a href="/planning"
          class="flex items-center gap-2 {{ request()->is('planning') ? 'text-[#FF7304]' : 'text-[#000000] dark:text-gray-300' }} font-semibold text-[14px] hover:text-[#FF7304] transition-colors whitespace-nowrap">
          <i class="fa-solid fa-people-group text-md"></i>
          <span>Planning Room</span>
        </a>
        <a href="/pesanan-saya"
          class="flex items-center gap-2 {{ request()->is('pesanan-saya') ? 'text-[#FF7304]' : 'text-[#000000] dark:text-gray-300' }} font-semibold text-[14px] hover:text-[#FF7304] transition-colors whitespace-nowrap">
          <i class="fa-solid fa-receipt text-md"></i>
          <span>Aktivitas Saya</span>
        </a>

        <a href="/settings"
          class="flex items-center gap-2 {{ request()->is('settings') ? 'text-[#FF7304]' : 'text-[#000000] dark:text-gray-300' }} font-semibold text-[14px] hover:text-[#FF7304] transition-colors whitespace-nowrap">
          <i class="fa-solid fa-gear text-md"></i>
          <span>Pengaturan</span>
        </a>
      @endauth
    </nav>

    <!-- Search & Profile Section -->
    <div
      class="bg-white dark:bg-dark-card rounded-[20px] py-2 px-3 flex items-center gap-3 shadow-sm min-w-[380px] border dark:border-dark-border">
      <div class="flex-grow bg-[#EAEAEA] dark:bg-slate-700/50 rounded-full flex items-center px-4 py-2 gap-2">
        <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
        <input type="text" placeholder="Mau rencanain liburan kemana nih?"
          class="bg-transparent border-none outline-none text-[13px] w-full placeholder:text-gray-400 font-medium dark:text-white">
      </div>

      <!-- Dark Mode Toggle Button -->
      <button onclick="toggleDarkMode(event)"
        class="w-10 h-10 rounded-full bg-[#EAEAEA] dark:bg-slate-700 flex items-center justify-center text-[#000000] dark:text-yellow-400 hover:bg-gray-300 dark:hover:bg-slate-600 transition-all">
        <i class="fa-solid fa-moon dark:hidden"></i>
        <i class="fa-solid fa-sun hidden dark:block"></i>
      </button>

      <button
        class="w-10 h-10 rounded-full bg-[#EAEAEA] dark:bg-slate-700 flex items-center justify-center text-[#000000] dark:text-white hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
        <i class="fa-regular fa-bell text-lg"></i>
      </button>

      @auth
        <!-- Profile Dropdown -->
        <div class="relative">
          <div onclick="event.stopPropagation(); toggleProfileDropdown()"
            class="w-10 h-10 rounded-full bg-[#FF7304] overflow-hidden border-2 border-white dark:border-slate-700 cursor-pointer shadow-sm hover:scale-105 transition-all">
            <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : '/images/Avatarprof.jpeg' }}"
              alt="Profile" class="w-full h-full object-cover">
          </div>

          <!-- Dropdown Menu -->
          <div id="profile-dropdown" onclick="event.stopPropagation()"
            class="hidden absolute right-0 mt-3 w-56 bg-white dark:bg-dark-card rounded-[20px] shadow-xl border border-gray-100 dark:border-dark-border overflow-hidden z-50">
            <div class="p-4 border-b border-gray-50 dark:border-dark-border bg-orange-50/30 dark:bg-orange-950/20">
              <p class="font-bold text-gray-800 dark:text-white text-sm">User Voyago</p>
              <p class="text-[10px] text-gray-500 dark:text-gray-400">Member since 2025</p>
            </div>
            <div class="py-2">
              <a href="/profile"
                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:text-[#FF7304] transition-all">
                <i class="fa-solid fa-user-circle w-5"></i> Profil Saya
              </a>
              <a href="/pesanan-saya"
                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:text-[#FF7304] transition-all">
                <i class="fa-solid fa-receipt w-5"></i> Aktivitas
              </a>
              <a href="{{ route('partner.auth.page') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm font-bold text-[#FF7304] hover:bg-orange-50 dark:hover:bg-orange-900/20 transition-all">
                <i class="fa-solid fa-handshake w-5"></i> Dashboard Mitra
              </a>
              <a href="/planning"
                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:text-[#FF7304] transition-all">
                <i class="fa-solid fa-people-group w-5"></i> Planning Room
              </a>
              <a href="/settings"
                class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-orange-50 dark:hover:bg-orange-900/20 hover:text-[#FF7304] transition-all">
                <i class="fa-solid fa-gear w-5"></i> Pengaturan
              </a>
            </div>
            <div class="border-t border-gray-50 dark:border-dark-border py-2">
              <a href="{{ route('logout') }}"
                class="flex items-center gap-3 px-4 py-2.5 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 transition-all font-bold">
                <i class="fa-solid fa-right-from-bracket w-5"></i> Logout
              </a>
            </div>
          </div>
        </div>
      @else
        <a href="{{ route('login') }}"
          class="bg-[#FF7304] text-white px-6 py-2.5 rounded-full font-bold text-sm hover:bg-[#e66700] transition-all shadow-md active:scale-95">
          Masuk
        </a>
      @endauth
    </div>

  </div>
</header>

<script>
  window.addEventListener('scroll', function () {
    const header = document.getElementById('main-header');
    if (window.scrollY > 20) {
      header.classList.add('bg-white/40', 'backdrop-blur-md', 'shadow-md');
      header.classList.remove('py-2');
      header.classList.add('py-1');
    } else {
      header.classList.remove('bg-white/40', 'backdrop-blur-md', 'shadow-md', 'py-1');
      header.classList.add('py-2');
    }
  });

  function toggleProfileDropdown() {
    const dropdown = document.getElementById('profile-dropdown');
    dropdown.classList.toggle('hidden');
  }

  // Global click listener to close dropdown when clicking outside
  document.addEventListener('click', function (event) {
    const dropdown = document.getElementById('profile-dropdown');
    if (dropdown && !dropdown.classList.contains('hidden')) {
      dropdown.classList.add('hidden');
    }
  });
</script>