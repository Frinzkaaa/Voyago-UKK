<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Voyago</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&family=Poppins:wght@400;700&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    html {
      font-size: 15px;
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
      main.max-w-7xl, .max-w-7xl { position: relative; overflow-x: hidden !important; }
      /* ensure grid children won't force horizontal scroll (matches any grid-cols class) */
      [class*="grid-cols-"] > * { min-width: 0; }
      /* limit absolutely-positioned decorative elements */
      [class*="absolute"] { max-width: 100%; box-sizing: border-box; }
   
  </style>
</head>

<body class="bg-[#F8F8F8]">
  <x-header />
  <main class="max-w-7xl mx-auto px-6 py-6">
    @yield('content')
  </main>
  <x-footer />
</body>

</html>