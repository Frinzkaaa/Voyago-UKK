<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voyago</title>
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            dark: {
              bg: '#121212',
              card: '#1E1E1E',
              border: '#2A2A2A',
            }
          }
        }
      }
    }
  </script>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&family=Poppins:wght@400;700&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Midtrans Snap SDK -->
  <script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

  <!-- Alpine.js -->
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <script>
    // Theme Persistence and Logic
    window.themeLogic = {
        init() {
            const savedTheme = localStorage.getItem('voyago-theme') || 'light';
            this.setTheme(savedTheme);
        },
        setTheme(theme) {
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
            localStorage.setItem('voyago-theme', theme);
            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme } }));
        },
        toggle() {
            const current = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            const next = current === 'dark' ? 'light' : 'dark';
            this.setTheme(next);
        }
    };
    window.themeLogic.init();
  </script>

  <style>
    html {
      font-size: 15px;
    }

    /* Premium Circle Reveal Animation */
    ::view-transition-old(root),
    ::view-transition-new(root) {
        animation: none;
        mix-blend-mode: normal;
    }

    ::view-transition-old(root) {
        z-index: 1;
    }

    ::view-transition-new(root) {
        z-index: 9999;
    }

    .dark::view-transition-old(root) {
        z-index: 9999;
    }

    .dark::view-transition-new(root) {
        z-index: 1;
    }

    body {
      font-family: 'Poppins', sans-serif;
        overflow-x: hidden !important;
    }

    .noto-sans {
      font-family: 'Noto Sans', sans-serif;
    }
      /* allow flex/grid children to shrink instead of overflowing */
      .flex > * { min-width: 0; }
      .grid > * { min-width: 0; }
      /* stronger clipping rules for containers and grid to avoid layout shift */
      html, body { overflow-x: hidden !important; }
      main.max-w-7xl { position: relative; }
      /* ensure grid children won't force horizontal scroll (matches any grid-cols class) */
      [class*="grid-cols-"] > * { min-width: 0; }
      /* limit absolutely-positioned decorative elements */
      [class*="absolute"] { max-width: 100%; box-sizing: border-box; }
   
  </style>
</head>

<body class="bg-[#F8F8F8] dark:bg-dark-bg text-gray-800 dark:text-[#A1A1AA] transition-colors duration-300">
  <x-header />
  <main class="max-w-7xl mx-auto px-4 md:px-6 py-6">
    @yield('content')
  </main>
  <x-footer />

  <!-- Global Toasts -->
  <div class="fixed bottom-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none">
    @if(session('success'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" 
             x-transition:enter="transition ease-out duration-300 transform translate-y-10 opacity-0"
             x-transition:enter-start="translate-y-10 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform translate-y-0 opacity-100"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-10 opacity-0"
             class="bg-green-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3 pointer-events-auto">
            <i class="fa-solid fa-circle-check"></i>
            <span class="font-bold text-sm">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 8000)" x-show="show"
             x-transition:enter="transition ease-out duration-300 transform translate-y-10 opacity-0"
             x-transition:enter-start="translate-y-10 opacity-0"
             x-transition:enter-end="translate-y-0 opacity-100"
             x-transition:leave="transition ease-in duration-200 transform translate-y-0 opacity-100"
             x-transition:leave-start="translate-y-0 opacity-100"
             x-transition:leave-end="translate-y-10 opacity-0"
             class="bg-red-500 text-white px-6 py-3 rounded-2xl shadow-2xl flex items-center gap-3 pointer-events-auto">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="font-bold text-sm">{{ session('error') }}</span>
        </div>
    @endif
  </div>
</body>

</html>