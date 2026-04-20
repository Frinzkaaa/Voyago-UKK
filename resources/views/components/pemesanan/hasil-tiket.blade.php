@props(['tickets' => []])

<div id="ticketList" class="flex flex-col gap-4">
  @forelse($tickets as $ticket)
    @php
      // Determine time and route fields based on the type of ticket
      $departureTime = \Carbon\Carbon::parse($ticket->departure_time)->format('H:i');
      $arrivalTime = isset($ticket->arrival_time) ? \Carbon\Carbon::parse($ticket->arrival_time)->format('H:i') : '-';
      $name = $ticket->name ?? $ticket->airline_name ?? $ticket->operator ?? 'Product';
      $code = $ticket->code ?? $ticket->flight_code ?? '';
      $class = $ticket->class ?? $ticket->seat_type ?? $ticket->room_type ?? 'Standard';
      $price = $ticket->price ?? $ticket->price_per_night ?? 0;
      $duration = $ticket->duration ?? '';
    @endphp

    <div
      class="bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-3xl p-4 md:p-6 hover:border-orange-300 transition-all flex flex-col gap-4 md:gap-6 group transition-colors duration-300">
      
      @php
        $category = strtolower($ticket->category ?? $category ?? '');
        $showImage = in_array($category, ['bus', 'hotel', 'wisata', 'pesawat', 'kereta', 'attraction', 'attractions', 'atraksi', 'tour']);
        
        // Prioritas gambar dari mitra (DB), fallback ke Unsplash jika kosong
        $imagePath = $ticket->image;
        $mainImage = $imagePath 
            ? (str_starts_with($imagePath, 'http') ? $imagePath : asset('storage/' . str_replace('storage/', '', $imagePath)))
            : null;
        
        if (!$mainImage) {
            if ($category === 'bus') $mainImage = 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&q=80&w=800';
            elseif ($category === 'hotel') $mainImage = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=800';
            elseif (in_array($category, ['wisata', 'attraction', 'attractions', 'atraksi', 'tour'])) $mainImage = 'https://images.unsplash.com/photo-1506461883276-594a12b11cf3?auto=format&fit=crop&q=80&w=800';
            elseif ($category === 'pesawat') $mainImage = 'https://images.unsplash.com/photo-1436491865332-7a61a109c0f?auto=format&fit=crop&q=80&w=800';
            elseif ($category === 'kereta') $mainImage = 'https://images.unsplash.com/photo-1474487056235-9d6a20b17b1e?auto=format&fit=crop&q=80&w=800';
        }
      @endphp

      @if($showImage)
      <div class="relative w-full h-40 md:h-48 rounded-2xl md:rounded-[2rem] overflow-hidden">
        <img src="{{ $mainImage }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        <div class="absolute bottom-4 left-6">
           <h3 class="text-white font-black text-2xl leading-tight">{{ $name }}</h3>
           <span class="text-xs font-bold text-orange-400 italic">{{ $class }}</span>
        </div>
      </div>
      @endif

      <div class="flex items-start justify-between {{ $showImage ? '' : 'hidden' }}">
          <div class="flex items-center gap-4">
             @if($showImage && $mainImage)
             <div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm border border-gray-100 dark:border-dark-border shrink-0">
                <img src="{{ $mainImage }}" class="w-full h-full object-cover">
             </div>
             @endif
              <div>
                 <h3 class="text-lg md:text-xl font-black text-gray-900 dark:text-white">{{ $name }}</h3>
                 <span class="px-3 py-1 bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 rounded-full text-[9px] font-black uppercase tracking-widest">{{ $class }}</span>
              </div>
          </div>
      </div>

      <div class="flex items-start justify-between {{ $showImage ? 'hidden' : '' }}">
        <div class="flex flex-col">
          <h3 class="text-orange-500 font-black text-lg md:text-2xl leading-tight">{{ $name }} {{ $code ? "($code)" : '' }}</h3>
          <span class="text-xs font-bold text-orange-400 italic">{{ $class }}</span>
        </div>
        <div class="flex flex-col items-end">
          <div class="flex items-baseline gap-1">
            <span class="text-orange-500 font-black text-xl md:text-2xl tracking-tighter">Rp
              {{ number_format($price, 0, ',', '.') }}</span>
            <span class="text-gray-400 font-bold text-xs md:text-sm">/ {{ isset($ticket->price_per_night) ? 'malam' : 'pax' }}</span>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-between">
        @if(isset($ticket->departure_time))
          <div class="flex items-center gap-4 md:gap-12 flex-grow">
            <div class="flex flex-col">
              <span class="text-gray-800 dark:text-white font-black text-2xl md:text-[2rem] leading-none">{{ $departureTime }}</span>
              @if($showImage) <span class="text-[10px] md:text-xs font-bold text-gray-400 mt-1 uppercase">{{ $ticket->origin ?? '' }}</span> @endif
            </div>

            <div class="flex flex-col items-center flex-grow max-w-[120px]">
              <span class="text-[10px] font-bold text-gray-400">{{ $duration }}</span>
              <div class="w-full flex items-center gap-1 py-1">
                <div class="h-[1.5px] bg-gray-200 dark:bg-dark-border flex-grow rounded-full"></div>
                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
              </div>
              <span class="text-[10px] font-bold text-gray-400">Langsung</span>
            </div>

            <div class="flex flex-col">
              <span class="text-gray-800 dark:text-white font-black text-2xl md:text-[2rem] leading-none">{{ $arrivalTime }}</span>
              @if($showImage) <span class="text-[10px] md:text-xs font-bold text-gray-400 mt-1 uppercase text-right">{{ $ticket->destination ?? '' }}</span> @endif
            </div>
          </div>
        @else
          <!-- For Hotel/Wisata without specific times -->
          <div class="flex items-center gap-12 flex-grow">
            <div class="flex flex-col">
              <span class="text-gray-600 dark:text-[#A1A1AA] font-bold text-sm"><i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>
                {{ $ticket->location ?? $ticket->category ?? 'Indonesia' }}</span>
              @if(isset($ticket->rating) && !$showImage)
                <span class="text-orange-400 font-bold text-sm mt-1"><i class="fas fa-star mr-2"></i>
                  {{ $ticket->rating }}</span>
              @endif
            </div>
          </div>
        @endif

        <div class="flex flex-col items-end gap-2 shrink-0">
           @if($showImage)
           <div class="flex items-baseline gap-1 mb-1">
              <span class="text-orange-500 font-black text-xl md:text-2xl tracking-tighter">Rp {{ number_format($price, 0, ',', '.') }}</span>
              <span class="text-gray-400 font-bold text-xs md:text-sm">/ {{ isset($ticket->price_per_night) ? 'malam' : 'pax' }}</span>
           </div>
           @endif
           <button onclick="selectTicket({{ $ticket->id }}, {{ $price }}, '{{ urlencode(json_encode($ticket)) }}')"
             class="bg-orange-100 dark:bg-orange-500/10 text-orange-500 group-hover:bg-orange-500 group-hover:text-white font-black px-6 md:px-12 py-2 md:py-3 rounded-xl md:rounded-2xl transition-all shadow-sm text-xs md:text-base">
             Pilih
           </button>
        </div>
      </div>

      <div class="flex gap-4 border-t border-gray-50 dark:border-dark-border pt-4">
        <button onclick="showDetail('{{ urlencode(json_encode($ticket)) }}')"
          class="text-xs font-black text-gray-800 dark:text-white hover:text-orange-500 transition-colors uppercase tracking-widest flex items-center gap-2">
          <i class="fas fa-info-circle text-orange-500"></i>
          Detail {{ isset($ticket->price_per_night) ? 'Hotel' : 'Perjalanan' }}
        </button>
      </div>
    </div>
  @empty
    <div class="text-center py-20 bg-white dark:bg-dark-card rounded-[2rem] border-2 border-dashed border-gray-100 dark:border-dark-border transition-colors duration-300">
      <i class="fas fa-ticket text-5xl text-gray-200 mb-4"></i>
      <p class="font-bold text-gray-400">Belum ada tiket tersedia untuk kategori ini.</p>
    </div>
  @endforelse
</div>