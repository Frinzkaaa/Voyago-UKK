@php
    $p = $product ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="md:col-span-2">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Operator Bus / PO</label>
        <input type="text" name="operator" required value="{{ $p->operator ?? '' }}"
            placeholder="Ex: Rosalia Indah, DAMRI"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white placeholder:text-gray-300">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Terminal Asal (Origin)</label>
        <input type="text" name="origin_terminal" required value="{{ $p->origin_terminal ?? '' }}" placeholder="Ex: Bekasi"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Terminal Tujuan (Destination)</label>
        <input type="text" name="destination_terminal" required value="{{ $p->destination_terminal ?? '' }}" placeholder="Ex: Yogyakarta"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Waktu Keberangkatan</label>
        <input type="datetime-local" name="departure_time" required
            value="{{ isset($p->departure_time) ? \Carbon\Carbon::parse($p->departure_time)->format('Y-m-d\TH:i') : '' }}"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Estimasi Kedatangan & Durasi</label>
        <div class="flex gap-4">
            <input type="datetime-local" name="arrival_time"
                value="{{ isset($p->arrival_time) ? \Carbon\Carbon::parse($p->arrival_time)->format('Y-m-d\TH:i') : '' }}"
                class="flex-grow bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
            <input type="text" name="duration" value="{{ $p->duration ?? '' }}" placeholder="10j 0m"
                class="w-32 bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-2 outline-none transition-all text-sm font-bold text-center text-gray-900 dark:text-white">
        </div>
    </div>
</div>
