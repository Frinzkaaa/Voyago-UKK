@extends('mitra.layout')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Edit Detail Produk</h2>
            <p class="text-sm text-gray-500 mt-1">Sesuaikan informasi dan ketersediaan stok inventori Anda</p>
        </div>
        <a href="{{ route('partner.products') }}"
            class="text-[10px] font-bold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest flex items-center gap-2">
            <i class="fa-solid fa-xmark"></i>
            Batal
        </a>
    </div>

    <form action="{{ route('partner.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Main Form Section -->
            <div class="lg:col-span-8 space-y-8">
                <div class="premium-card p-6 bg-white border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                        Informasi Dasar</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama
                                Produk</label>
                            <input type="text" name="name" value="{{ $product->name }}" required
                                placeholder="Contoh: Tiket Terusan Dunia Fantasi"
                                class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Kategori
                                Bisnis</label>
                            <select name="category" required
                                class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium cursor-pointer">
                                <option value="Wisata" {{ $product->category == 'Wisata' ? 'selected' : '' }}>Wisata / Atraksi
                                </option>
                                <option value="Travel" {{ $product->category == 'Travel' ? 'selected' : '' }}>Paket Tour
                                </option>
                                <option value="Transport" {{ $product->category == 'Transport' ? 'selected' : '' }}>
                                    Transportasi</option>
                                <option value="Stay" {{ $product->category == 'Stay' ? 'selected' : '' }}>Akomodasi / Hotel
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Area
                                Lokasi</label>
                            <input type="text" name="location" value="{{ $product->location }}" required
                                placeholder="Contoh: Jakarta Selatan"
                                class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                        </div>
                    </div>

                    <div class="mb-0">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Detail
                            Deskripsi</label>
                        <textarea name="description" rows="5" required
                            placeholder="Jelaskan secara mendalam tentang layanan atau produk yang Anda tawarkan..."
                            class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium resize-none leading-relaxed">{{ $product->description }}</textarea>
                    </div>
                </div>

                <div class="premium-card p-6 bg-white border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                        Syarat & Ketentuan</h3>
                    <textarea name="terms" rows="4" placeholder="Sebutkan poin pembatalan atau penggunaan produk..."
                        class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium resize-none leading-relaxed">{{ $product->terms ?? '' }}</textarea>
                </div>
            </div>

            <!-- Side Section -->
            <div class="lg:col-span-4 space-y-8">
                <div class="premium-card p-6 bg-white border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                        Harga & Stok</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Harga
                                Jual (IDR)</label>
                            <div class="relative group">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-400 text-xs">Rp</span>
                                <input type="number" name="price" value="{{ (int) $product->price }}" required
                                    placeholder="0"
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 pl-10 rounded outline-none transition-all text-sm font-bold text-gray-900">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Sisa
                                Kuota</label>
                            <input type="number" name="quota" value="{{ $product->availability }}" required placeholder="0"
                                class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-bold text-gray-900 text-center">
                        </div>
                    </div>
                </div>

                <div class="premium-card p-6 bg-white border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                        Cover Produk</h3>

                    <div class="space-y-4">
                        @if($product->image)
                            <div class="rounded border border-gray-100 overflow-hidden bg-gray-50">
                                <img src="{{ asset('storage/' . $product->image) }}"
                                    class="w-full h-32 object-cover grayscale-[20%]">
                            </div>
                        @endif

                        <div class="relative group">
                            <label
                                class="w-full flex flex-col items-center justify-center p-6 border-2 border-dashed border-gray-200 rounded hover:border-orange-500 hover:bg-orange-50/10 transition-all cursor-pointer">
                                <i
                                    class="fa-solid fa-cloud-arrow-up text-gray-300 text-xl group-hover:text-orange-500 mb-2"></i>
                                <span
                                    class="text-[9px] font-bold uppercase tracking-widest text-gray-400 group-hover:text-orange-500">Ganti
                                    Foto Sampul</span>
                                <input type="file" name="image" class="hidden">
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-gray-900 text-white py-4 rounded text-[10px] font-bold uppercase tracking-widest shadow-md hover:bg-black transition-all flex items-center justify-center gap-2 mt-8">
                        <i class="fa-solid fa-save text-[10px]"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection