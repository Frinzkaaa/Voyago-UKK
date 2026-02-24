@extends('mitra.layout')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Katalog Layanan</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola listing properti, transportasi, atau tiket wisata Anda</p>
        </div>
        <a href="{{ route('partner.products.create') }}"
            class="bg-orange-500 hover:bg-orange-600 text-white px-5 py-2.5 rounded text-xs font-semibold flex items-center gap-2 transition-colors shadow-sm">
            <i class="fa-solid fa-plus"></i>
            Tambah Inventori
        </a>
    </div>

    <div class="premium-card overflow-hidden">
        <div class="p-4 border-b border-gray-100 flex items-center justify-between bg-white">
            <div class="flex items-center gap-4">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[10px]"></i>
                    <input type="text" placeholder="Cari nama produk..." 
                        class="bg-gray-50 border border-gray-200 rounded py-2 pl-9 pr-4 text-xs font-medium focus:outline-none focus:ring-1 focus:ring-orange-500 focus:border-orange-500 w-64 transition-all">
                </div>
                <select class="bg-gray-50 border border-gray-200 rounded py-2 px-3 text-xs font-medium focus:outline-none text-gray-600">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Ditinjau</option>
                </select>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400">Info Layanan</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400 text-center">Tipe/Unit</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400 text-right">Harga Satuan</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400 text-center">Status</th>
                        <th class="px-6 py-4 text-[10px] font-semibold uppercase tracking-wider text-gray-400 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        @php
                            $name = $product->name ?? $product->airline_name ?? $product->operator ?? 'Product';
                            $price = $product->price ?? $product->price_per_night ?? 0;
                            $category = $product->category ?? $product->room_type ?? $product->class ?? $product->seat_type ?? '-';
                            $subInfo = $product->location ?? $product->code ?? $product->flight_code ?? 'N/A';
                            $icon = match ($type) {
                                'hotel' => 'fa-hotel',
                                'pesawat' => 'fa-plane',
                                'kereta' => 'fa-train',
                                'bus' => 'fa-bus',
                                'wisata' => 'fa-mountain-sun',
                                default => 'fa-box-open'
                            };
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-gray-50 overflow-hidden shrink-0 border border-gray-100">
                                        @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                                <i class="fa-solid {{ $icon }} text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 text-xs">{{ $name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-1 uppercase tracking-tighter">
                                            {{ $subInfo }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-0.5 border border-gray-200 rounded text-[9px] font-semibold text-gray-500 uppercase">{{ $category }}</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <p class="font-bold text-gray-900 text-xs text-right">Rp {{ number_format($price, 0, ',', '.') }}</p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex justify-center">
                                    @if($product->status->value ?? $product->status == 'active')
                                        <span class="px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded text-[9px] font-semibold">Live</span>
                                    @elseif($product->status->value ?? $product->status == 'pending_review')
                                        <span class="px-2 py-0.5 bg-orange-50 text-orange-600 rounded text-[9px] font-semibold">Verifikasi</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-gray-50 text-gray-500 rounded text-[9px] font-semibold">Tutup</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('partner.products.edit', $product->id) }}"
                                        class="p-1.5 text-gray-400 hover:text-gray-900 hover:bg-gray-100 rounded transition-colors">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>
                                    <form action="{{ route('partner.products.delete', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus inventori ini?')">
                                        @csrf @method('DELETE')
                                        <button class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-gray-100">
                                    <i class="fa-solid fa-box-open text-2xl text-gray-200"></i>
                                </div>
                                <p class="font-semibold text-gray-900 text-sm mb-1">Inventori Kosong</p>
                                <p class="text-xs text-gray-500 mb-6">Belum ada produk yang didaftarkan ke Voyago.</p>
                                <a href="{{ route('partner.products.create') }}"
                                    class="bg-gray-900 text-white px-4 py-2 rounded text-[10px] font-bold uppercase tracking-wider transition-colors hover:bg-black">
                                    Daftarkan Produk Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between">
            <p class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">Total: {{ $products->count() }} Listing</p>
            <div class="flex gap-1.5">
                <button class="px-2.5 py-1.5 border border-gray-200 bg-white rounded text-[10px] font-bold text-gray-400 cursor-not-allowed">Previous</button>
                <button class="px-2.5 py-1.5 border border-gray-200 bg-white rounded text-[10px] font-bold text-gray-900">Next</button>
            </div>
        </div>
    </div>
@endsection
