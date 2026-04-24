@php
    $p = $product ?? null;
@endphp

<div class="space-y-8">
    <!-- Row: Operator Name -->
    <div class="group">
        <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
            <i class="fa-solid fa-bus mr-2 opacity-50"></i> Operator Bus / PO
        </label>
        <div class="relative">
            <input type="text" name="operator" required value="{{ $p->operator ?? '' }}"
                placeholder="Ex: Rosalia Indah, DAMRI"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-3xl py-5 px-8 outline-none transition-all text-base font-bold text-gray-900 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-700 shadow-sm">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
        <!-- Row: Origin & Destination -->
        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-location-dot mr-2 opacity-50"></i> Terminal Asal (Origin)
            </label>
            <input type="text" name="origin_terminal" required value="{{ $p->origin_terminal ?? '' }}" placeholder="Ex: Bekasi"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-map-pin mr-2 opacity-50"></i> Terminal Tujuan (Destination)
            </label>
            <input type="text" name="destination_terminal" required value="{{ $p->destination_terminal ?? '' }}" placeholder="Ex: Yogyakarta"
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

        <!-- Row: Duration (Full Width) -->
        <div class="md:col-span-2 group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-hourglass-half mr-2 opacity-50"></i> Estimasi Durasi Perjalanan
            </label>
            <input type="text" name="duration" value="{{ $p->duration ?? '' }}" placeholder="Ex: 10j 0m"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>
    </div>
</div>


