@php
    $p = $product ?? null;
@endphp

<div class="space-y-8">
    <!-- Row: Wisata Name -->
    <div class="group">
        <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
            <i class="fa-solid fa-camera-retro mr-2 opacity-50"></i> Nama Atraksi / Wisata
        </label>
        <div class="relative">
            <input type="text" name="name" required value="{{ $p->name ?? '' }}"
                placeholder="Ex: Tanah Lot Sunset Tour, Pura Uluwatu"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-3xl py-5 px-8 outline-none transition-all text-base font-bold text-gray-900 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-700 shadow-sm">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Row: Category & Location -->
        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-layer-group mr-2 opacity-50"></i> Kategori
            </label>
            <input type="text" name="category" required value="{{ $p->category ?? 'Culture' }}"
                placeholder="Ex: Nature, Adventure, Culture, Theme Park"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-location-dot mr-2 opacity-50"></i> Area Lokasi
            </label>
            <input type="text" name="location" required value="{{ $p->location ?? '' }}" placeholder="Ex: Tabanan, Bali"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="md:col-span-2 group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-circle-check mr-2 opacity-50"></i> Highlight & Fasilitas
            </label>
            <textarea name="description" rows="4" required
                placeholder="Sebutkan highlight paket wisata atau fasilitas yang didapat..."
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-[32px] py-6 px-8 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white leading-relaxed resize-none shadow-sm">{{ $p->description ?? '' }}</textarea>
        </div>
    </div>
</div>

