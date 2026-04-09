<div class="flex flex-col gap-6 mb-12">
  <div class="flex flex-col gap-1">
    <h3 class="font-black text-2xl text-gray-800 dark:text-white flex items-center gap-2">
      <i class="fas fa-globe-americas text-teal-400 text-xl"></i>
      Tamasya keliling dunia, cek panduannya!
    </h3>
  </div>

  <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-6">
    @php
      $guides = [
        ['city' => 'Bali', 'country' => 'Indonesia', 'img' => 'https://plus.unsplash.com/premium_photo-1661878915254-f3163e91d870?q=80&w=1171&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
        ['city' => 'Bangkok', 'country' => 'Thailand', 'img' => 'https://images.unsplash.com/photo-1562602833-0f4ab2fc46e3?q=80&w=736&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
        ['city' => 'Seoul', 'country' => 'Korea Selatan', 'img' => 'https://images.unsplash.com/photo-1570191913384-7b4ff11716e7?q=80&w=687&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
        ['city' => 'Istanbul', 'country' => 'Turki', 'img' => 'https://images.unsplash.com/photo-1527838832700-5059252407fa?q=80&w=698&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
        ['city' => 'Liverpool', 'country' => 'United Kingdom', 'img' => 'https://plus.unsplash.com/premium_photo-1694475284460-51ace2ec7cfd?q=80&w=774&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
      ];
    @endphp

    @foreach($guides as $g)
      <div
        class="group relative h-72 rounded-3xl overflow-hidden cursor-pointer shadow-md transform hover:scale-[1.05] transition-all">
        <img src="{{ $g['img'] }}"
          class="absolute inset-0 w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 w-full text-center px-4">
          <h4 class="text-white font-black text-lg leading-tight group-hover:text-orange-400 transition-colors">
            {{ $g['city'] }}
          </h4>
          <p class="text-[10px] text-white/70 font-bold uppercase tracking-widest mt-0.5">{{ $g['country'] }}</p>
        </div>
        <!-- Bottom border accent on hover -->
        <div
          class="absolute bottom-0 left-0 w-full h-1 bg-orange-500 scale-x-0 group-hover:scale-x-100 transition-transform origin-center">
        </div>
      </div>
    @endforeach
  </div>
</div>