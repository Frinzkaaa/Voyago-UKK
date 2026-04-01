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
      class="bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-[2rem] p-6 hover:border-orange-300 transition-all flex flex-col gap-4 group transition-colors duration-300">
      <div class="flex items-start justify-between">
        <div class="flex flex-col">
          <h3 class="text-orange-500 font-black text-2xl leading-tight">{{ $name }} {{ $code ? "($code)" : '' }}</h3>
          <span class="text-xs font-bold text-orange-400 italic">{{ $class }}</span>
        </div>
        <div class="flex flex-col items-end">
          <div class="flex items-baseline gap-1">
            <span class="text-orange-500 font-black text-2xl tracking-tighter">Rp
              {{ number_format($price, 0, ',', '.') }}</span>
            <span class="text-gray-400 font-bold text-sm">/ {{ isset($ticket->price_per_night) ? 'malam' : 'pax' }}</span>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-between">
        @if(isset($ticket->departure_time))
          <div class="flex items-center gap-12 flex-grow">
            <div class="flex flex-col">
              <span class="text-gray-800 dark:text-white font-black text-[2rem] leading-none">{{ $departureTime }}</span>
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
              <span class="text-gray-800 dark:text-white font-black text-[2rem] leading-none">{{ $arrivalTime }}</span>
            </div>
          </div>
        @else
          <!-- For Hotel/Wisata without specific times -->
          <div class="flex items-center gap-12 flex-grow">
            <div class="flex flex-col">
              <span class="text-gray-600 dark:text-[#A1A1AA] font-bold text-sm"><i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>
                {{ $ticket->location ?? $ticket->category ?? 'Indonesia' }}</span>
              @if(isset($ticket->rating))
                <span class="text-orange-400 font-bold text-sm mt-1"><i class="fas fa-star mr-2"></i>
                  {{ $ticket->rating }}</span>
              @endif
            </div>
          </div>
        @endif

        <button onclick="selectTicket({{ $ticket->id }}, {{ $price }}, '{{ urlencode(json_encode($ticket)) }}')"
          class="bg-orange-100 group-hover:bg-orange-50 dark:hover:bg-[#2A2A2A]0 group-hover:text-white text-orange-400 font-black px-12 py-3 rounded-2xl transition-all shadow-sm">
          Pilih
        </button>
      </div>

      <div class="flex gap-4 border-t border-gray-50 dark:border-dark-border pt-3">
        <button
          class="text-xs font-black text-gray-800 dark:text-white hover:text-orange-500 transition-colors uppercase tracking-widest">Detail
          {{ isset($ticket->price_per_night) ? 'Hotel' : 'Perjalanan' }}</button>
        <button
          class="text-xs font-black text-gray-800 dark:text-white hover:text-orange-500 transition-colors uppercase tracking-widest">Info</button>
      </div>
    </div>
  @empty
    <div class="text-center py-20 bg-white dark:bg-dark-card rounded-[2rem] border-2 border-dashed border-gray-100 dark:border-dark-border transition-colors duration-300">
      <i class="fas fa-ticket text-5xl text-gray-200 mb-4"></i>
      <p class="font-bold text-gray-400">Belum ada tiket tersedia untuk kategori ini.</p>
    </div>
  @endforelse
</div>