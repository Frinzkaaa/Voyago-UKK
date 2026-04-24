@php
    $p = $product ?? null;
@endphp

<div class="space-y-8">
    <!-- Row: Airline Name -->
    <div class="group">
        <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
            <i class="fa-solid fa-plane mr-2 opacity-50"></i> Nama Maskapai
        </label>
        <div class="relative">
            <input type="text" name="airline_name" required value="{{ $p->airline_name ?? '' }}"
                placeholder="Ex: Garuda Indonesia, Emirates Airways"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-3xl py-5 px-8 outline-none transition-all text-base font-bold text-gray-900 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-700 shadow-sm">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
        <!-- Row: Flight Code & Class -->
        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-hashtag mr-2 opacity-50"></i> Kode Penerbangan
            </label>
            <input type="text" name="flight_code" required value="{{ $p->flight_code ?? '' }}"
                placeholder="Ex: GA-402, EK-034"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-crown mr-2 opacity-50"></i> Kelas Pelayanan
            </label>
            <div class="relative">
                <select name="class" required
                    class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-black text-gray-900 dark:text-white appearance-none cursor-pointer shadow-sm">
                    <option value="Economy" @if(($p->class ?? '') == 'Economy') selected @endif>Economy Class</option>
                    <option value="Business" @if(($p->class ?? '') == 'Business') selected @endif>Business Class</option>
                    <option value="Executive" @if(($p->class ?? '') == 'Executive') selected @endif>Executive Class</option>
                    <option value="Premium" @if(($p->class ?? '') == 'Premium') selected @endif>First Class / Premium</option>
                </select>
                <i class="fa-solid fa-chevron-down absolute right-6 top-1/2 -translate-y-1/2 text-gray-400 text-[10px] pointer-events-none"></i>
            </div>
        </div>

        <!-- Row: Origin & Destination -->
        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-plane-departure mr-2 opacity-50"></i> Bandara Asal (Origin)
            </label>
            <input type="text" name="origin" required value="{{ $p->origin ?? '' }}" placeholder="Ex: Jakarta (CGK)"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-plane-arrival mr-2 opacity-50"></i> Bandara Tujuan (Destination)
            </label>
            <input type="text" name="destination" required value="{{ $p->destination ?? '' }}" placeholder="Ex: Bali (DPS)"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <!-- Row: Departure Time -->
        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-calendar-day mr-2 opacity-50"></i> Waktu Keberangkatan
            </label>
            <input type="datetime-local" name="departure_time" required
                value="{{ isset($p->departure_time) ? \Carbon\Carbon::parse($p->departure_time)->format('Y-m-d\TH:i') : '' }}"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white [color-scheme:dark] shadow-sm">
        </div>

        <!-- Row: Arrival Time -->
        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-clock mr-2 opacity-50"></i> Estimasi Waktu Tiba
            </label>
            <input type="datetime-local" name="arrival_time"
                value="{{ isset($p->arrival_time) ? \Carbon\Carbon::parse($p->arrival_time)->format('Y-m-d\TH:i') : '' }}"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white [color-scheme:dark] shadow-sm">
        </div>

        <!-- Row: Duration -->
        <div class="md:col-span-2 group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-hourglass-half mr-2 opacity-50"></i> Estimasi Durasi Penerbangan
            </label>
            <input type="text" name="duration" value="{{ $p->duration ?? '' }}" placeholder="Ex: 2j 30m"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="md:col-span-2 group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-suitcase mr-2 opacity-50"></i> Informasi Bagasi
            </label>
            <input type="text" name="baggage_info" required value="{{ $p->baggage_info ?? '20kg' }}" placeholder="Ex: Cabin 7kg, Bagasi 20kg"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>
    </div>
</div>


