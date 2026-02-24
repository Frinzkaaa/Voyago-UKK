<div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-50 flex flex-col gap-5 h-full">
  @php
    $chatUsers = [
      ['name' => 'Frinzka', 'img' => 'https://i.pravatar.cc/100?u=1'],
      ['name' => 'Ning', 'img' => 'https://i.pravatar.cc/100?u=2'],
      ['name' => 'Ucup', 'img' => 'https://i.pravatar.cc/100?u=3'],
      ['name' => 'Bayu', 'img' => 'https://i.pravatar.cc/100?u=4'],
      ['name' => 'Rino', 'img' => 'https://i.pravatar.cc/100?u=5'],
      ['name' => 'Ipeh', 'img' => 'https://i.pravatar.cc/100?u=6'],
    ];
  @endphp

  @foreach($chatUsers as $cu)
    <div class="flex items-center justify-between p-2 hover:bg-orange-50 rounded-2xl transition-all cursor-pointer group">
      <div class="flex items-center gap-3">
        <div class="flex gap-1.5 opacity-20 group-hover:opacity-100 transition-opacity">
          <i class="far fa-file text-[10px] text-gray-400 group-hover:text-orange-500"></i>
          <i class="far fa-comment-dots text-[10px] text-gray-400 group-hover:text-orange-500"></i>
        </div>
        <span
          class="font-black text-gray-800 text-xs tracking-tight group-hover:text-orange-600 transition-colors">{{ $cu['name'] }}</span>
      </div>
      <div class="relative">
        <img src="{{ $cu['img'] }}"
          class="w-8 h-8 rounded-full border-2 border-white shadow-sm transition-transform group-hover:scale-110">
        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></div>
      </div>
    </div>
  @endforeach
</div>  