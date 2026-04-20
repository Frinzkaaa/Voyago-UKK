<div class="flex flex-col gap-6">
  <div class="flex flex-col gap-1">
    <h3 class="font-black text-2xl text-orange-500">Paket Destinasi Luar Negeri Terbaik!</h3>
    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mt-[-0.5rem]">Rekomendasi trip favorit
      dengan harga mulai dari...</p>
  </div>

  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @php
      $intl = [
        ['title' => 'Japan Golden Trip 6D5N', 'sub' => 'Tokyo • Mt. Fuji • Kyoto • Osaka', 'price' => 'Rp 18.500.000 / orang', 'img' => 'https://images.unsplash.com/photo-1493976040374-85c8e12f0c0e?auto=format&fit=crop&w=500&q=80'],
        ['title' => 'Singapore Fun Holiday 3D2N', 'sub' => 'Marina Bay • Garden by the Bay • Universal Studios', 'price' => 'Rp 7.900.000 / orang', 'img' => 'https://plus.unsplash.com/premium_photo-1697730373939-3ebcaa9d295e?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'],
        ['title' => 'Switzerland Alps Dream 7D6N', 'sub' => 'Zurich • Lucerne • Interlaken • Jungfrau', 'price' => 'Rp 39.900.000 / orang', 'img' => 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=500&q=80'],
      ];
    @endphp

    @foreach($intl as $i)
      <div
        class="group relative h-44 md:h-48 rounded-2xl md:rounded-[2rem] overflow-hidden cursor-pointer shadow-md transform hover:scale-[1.02] transition-all">
        <img src="{{ $i['img'] }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="absolute bottom-4 left-6 right-6 flex flex-col">
          <h4 class="text-white font-black text-sm leading-tight group-hover:text-orange-400 transition-colors">
            {{ $i['title'] }}
          </h4>
          <p class="text-[9px] text-white/70 font-bold mt-0.5">{{ $i['sub'] }}</p>
          <div class="mt-2 text-white font-black text-sm md:text-base">{{ $i['price'] }}</div>
        </div>
      </div>
    @endforeach
  </div>
</div>