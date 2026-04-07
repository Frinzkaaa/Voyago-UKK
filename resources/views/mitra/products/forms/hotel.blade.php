@php
    $p = $product ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="md:col-span-2">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Nama Properti Hotel</label>
        <input type="text" name="name" required value="{{ $p->name ?? '' }}"
            placeholder="Ex: The St. Regis Bali Resort"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white placeholder:text-gray-300">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Klasifikasi Kamar</label>
        <input type="text" name="room_type" required value="{{ $p->room_type ?? '' }}"
            placeholder="Ex: Ocean Suite, Deluxe King"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Alamat / Lokasi Presisi</label>
        <input type="text" name="location" required value="{{ $p->location ?? '' }}" placeholder="Ex: Nusa Dua, Bali"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
    </div>

    <div class="md:col-span-2">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Highlight & Fasilitas</label>
        <textarea name="description" rows="4" 
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-[32px] py-6 px-8 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white leading-relaxed resize-none">{{ $p->description ?? '' }}</textarea>
    </div>
</div>
