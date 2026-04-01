@extends('mitra.layout')

@section('content')
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight">Katalog Inventori</h2>
            <p class="text-sm text-gray-500 dark:text-zinc-400 mt-1 font-medium">Kelola ketersediaan layanan Anda secara real-time.</p>
        </div>
        <a href="{{ route('partner.products.create') }}"
            class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3.5 rounded-2xl text-xs font-black uppercase tracking-widest flex items-center justify-center gap-3 transition-all shadow-xl shadow-orange-500/20 active:scale-95">
            <i class="fa-solid fa-plus-circle text-base"></i>
            Tambah Produk Baru
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-8">
        <div class="lg:col-span-2 relative group">
            <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-orange-500 transition-colors"></i>
            <input type="text" placeholder="Cari nama atau kode produk..." 
                class="w-full bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-2xl py-4 pl-12 pr-4 text-sm font-bold text-gray-800 dark:text-white outline-none focus:border-orange-500 transition-all shadow-sm">
        </div>
        <select class="bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-2xl py-4 px-6 text-xs font-black uppercase tracking-widest outline-none cursor-pointer text-gray-500 dark:text-zinc-400 shadow-sm appearance-none">
            <option>Semua Kategori</option>
            <option>Ekonomi</option>
            <option>Bisnis</option>
        </select>
        <select class="bg-white dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-2xl py-4 px-6 text-xs font-black uppercase tracking-widest outline-none cursor-pointer text-gray-500 dark:text-zinc-400 shadow-sm appearance-none">
            <option>Semua Status</option>
            <option>Aktif</option>
            <option>Nonaktif</option>
        </select>
    </div>

    <div class="bg-white dark:bg-zinc-900 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm overflow-hidden transition-all duration-500">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-zinc-800/30">
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Info Layanan</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center">Detail / Unit</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-right">Harga Satuan</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center">Marketplace</th>
                        <th class="px-8 py-5 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-right">Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-zinc-800">
                    @forelse($products as $product)
                        @php
                            $name = $product->name ?? $product->airline_name ?? $product->operator ?? 'Product';
                            $price = $product->price ?? $product->price_per_night ?? 0;
                            $category = $product->category ?? $product->room_type ?? $product->class ?? $product->seat_type ?? '-';
                            $subInfo = $product->location ?? $product->code ?? $product->flight_code ?? 'N/A';
                            $icon = match ($type ?? 'default') {
                                'hotel' => 'fa-hotel',
                                'pesawat' => 'fa-plane',
                                'kereta' => 'fa-train',
                                'bus' => 'fa-bus',
                                'wisata' => 'fa-mountain-sun',
                                default => 'fa-box-open'
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-zinc-800/50 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-2xl bg-zinc-100 dark:bg-zinc-800 overflow-hidden shrink-0 border border-zinc-100 dark:border-zinc-700 shadow-sm relative group-hover:scale-105 transition-transform">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-zinc-300">
                                                <i class="fa-solid {{ $icon }} text-xl"></i>
                                            </div>
                                        @endif
                                        @if(!$product->is_active)
                                            <div class="absolute inset-0 bg-black/40 backdrop-blur-[1px] flex items-center justify-center">
                                                <i class="fa-solid fa-eye-slash text-white text-xs"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-black text-gray-900 dark:text-white text-sm tracking-tight">{{ $name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5 uppercase tracking-widest font-bold">
                                            {{ $subInfo }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <span class="px-3 py-1 bg-white dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700 rounded-full text-[9px] font-black text-gray-500 dark:text-zinc-400 uppercase tracking-widest">{{ $category }}</span>
                            </td>
                            <td class="px-8 py-6 text-right font-black text-gray-900 dark:text-white text-sm">
                                Rp {{ number_format($price, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex flex-col items-center gap-2">
                                    <form action="{{ route('partner.products.toggle', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none {{ $product->is_active ? 'bg-orange-500' : 'bg-gray-200 dark:bg-zinc-800' }}">
                                            <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform {{ $product->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                        </button>
                                    </form>
                                    <span class="text-[9px] font-black uppercase tracking-widest {{ $product->is_active ? 'text-emerald-500' : 'text-gray-400' }}">
                                        {{ $product->is_active ? 'AKTIF' : 'NONAKTIF' }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('partner.products.edit', $product->id) }}"
                                        class="w-9 h-9 flex items-center justify-center text-gray-400 hover:bg-gray-100 dark:hover:bg-zinc-800 hover:text-gray-900 dark:hover:text-white rounded-xl transition-all">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('partner.products.delete', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus produk ini dari katalog permanen?')">
                                        @csrf @method('DELETE')
                                        <button class="w-9 h-9 flex items-center justify-center text-gray-400 hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-500 rounded-xl transition-all">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-8 py-32 text-center text-zinc-400 italic"> Kategori layanan ini masih kosong. </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
