@php
    $p = $product ?? null;
@endphp

<div class="space-y-8">
    <!-- Row: Hotel Name -->
    <div class="group">
        <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
            <i class="fa-solid fa-hotel mr-2 opacity-50"></i> Nama Properti Hotel
        </label>
        <div class="relative">
            <input type="text" name="name" required value="{{ $p->name ?? '' }}"
                placeholder="Ex: The St. Regis Bali Resort"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-3xl py-5 px-8 outline-none transition-all text-base font-bold text-gray-900 dark:text-white placeholder:text-gray-300 dark:placeholder:text-zinc-700 shadow-sm">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Row: Room Type & Location -->
        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-bed mr-2 opacity-50"></i> Klasifikasi Kamar
            </label>
            <input type="text" name="room_type" required value="{{ $p->room_type ?? '' }}"
                placeholder="Ex: Ocean Suite, Deluxe King"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-location-dot mr-2 opacity-50"></i> Alamat / Lokasi Presisi
            </label>
            <input type="text" name="location" required value="{{ $p->location ?? '' }}" placeholder="Ex: Nusa Dua, Bali"
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-7 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white shadow-sm">
        </div>

        <div class="md:col-span-2 group">
            <label class="block text-[11px] font-black text-gray-400 dark:text-zinc-500 uppercase tracking-[0.2em] mb-4 group-focus-within:text-orange-500 transition-colors">
                <i class="fa-solid fa-circle-check mr-2 opacity-50"></i> Highlight & Fasilitas
            </label>
            <textarea name="description" rows="4" 
                placeholder="Sebutkan fasilitas unggulan seperti Free WiFi, Breakfast, Pool Access, dll..."
                class="w-full bg-gray-50 dark:bg-zinc-950/50 border border-gray-100 dark:border-zinc-800 focus:border-orange-500 rounded-[32px] py-6 px-8 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white leading-relaxed resize-none shadow-sm">{{ $p->description ?? '' }}</textarea>
        </div>
    </div>
</div>

