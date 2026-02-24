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
        ['title' => 'Singapore Fun Holiday 3D2N', 'sub' => 'Marina Bay • Garden by the Bay • Universal Studios', 'price' => 'Rp 7.900.000 / orang', 'img' => 'https://images.unsplash.com/photo-1525625239114-98444a7036d7?auto=format&fit=crop&w=500&q=80'],
        ['title' => 'Switzerland Alps Dream 7D6N', 'sub' => 'Zurich • Lucerne • Interlaken • Jungfrau', 'price' => 'Rp 39.900.000 / orang', 'img' => 'https://images.unsplash.com/photo-1530122037265-a5f1f91d3b99?auto=format&fit=crop&w=500&q=80'],
      ];
    @endphp

    @foreach($intl as $i)
      <div
        class="group relative h-48 rounded-[2rem] overflow-hidden cursor-pointer shadow-md transform hover:scale-[1.02] transition-all">
        <img src="{{ $i['img'] }}" class="absolute inset-0 w-full h-full object-cover">
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
        <div class="absolute bottom-4 left-6 right-6 flex flex-col">
          <h4 class="text-white font-black text-sm leading-tight group-hover:text-orange-400 transition-colors">
            {{ $i['title'] }}
          </h4>
          <p class="text-[9px] text-white/70 font-bold mt-0.5">{{ $i['sub'] }}</p>
          <div class="mt-2 text-white font-black text-base">{{ $i['price'] }}</div>
        </div>
      </div>
    @endforeach
  </div>
</div>