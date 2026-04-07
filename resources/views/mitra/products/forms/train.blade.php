@php
    $p = $product ?? null;
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <div class="md:col-span-2">
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Nama Kereta Api</label>
        <input type="text" name="name" required value="{{ $p->name ?? '' }}"
            placeholder="Ex: Argo Bromo Anggrek Luxury"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white placeholder:text-gray-300">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Kode Unik / No. Armada</label>
        <input type="text" name="code" required value="{{ $p->code ?? '' }}" placeholder="Ex: ABA-01"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Kelas Pelayanan</label>
        <select name="class" required
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black text-gray-500 dark:text-zinc-400 appearance-none cursor-pointer">
            <option value="Economy" @if(($p->class ?? '') == 'Economy') selected @endif>Economy</option>
            <option value="Business" @if(($p->class ?? '') == 'Business') selected @endif>Business</option>
            <option value="Executive" @if(($p->class ?? '') == 'Executive') selected @endif>Executive</option>
            <option value="Premium" @if(($p->class ?? '') == 'Premium') selected @endif>Premium</option>
        </select>
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Stasiun Asal (Origin)</label>
        <input type="text" name="origin" required value="{{ $p->origin ?? '' }}" placeholder="Ex: Gambir (GMR)"
            class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
    </div>

    <div>
        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Stasiun Tujuan (Destination)</label>
        <input type="text" name="destination" required value="{{ $p->destination ?? '' }}" placeholder="Ex: Pasar Turi (SBI)"
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
            <input type="text" name="duration" value="{{ $p->duration ?? '' }}" placeholder="8j 0m"
                class="w-32 bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-2 outline-none transition-all text-sm font-bold text-center text-gray-900 dark:text-white">
        </div>
    </div>
</div>
