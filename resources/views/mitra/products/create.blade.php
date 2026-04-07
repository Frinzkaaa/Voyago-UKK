@extends('mitra.layout')

@section('content')
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase italic">
                @if ($type == 'hotel') Akomodasi Baru @elseif($type == 'pesawat') Flight Listing @elseif($type == 'kereta') Rail Management @elseif($type == 'bus') Transport Entry @else Atraksi Wisata @endif
            </h2>
            <p class="text-sm text-gray-500 dark:text-zinc-400 font-medium">Lengkapi detail untuk mendaftarkan layanan inventori baru Anda.</p>
        </div>
        <a href="{{ route('partner.products') }}"
            class="flex items-center gap-3 px-6 py-3 bg-gray-50 dark:bg-zinc-900 text-gray-400 hover:text-gray-900 dark:hover:text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all border border-transparent hover:border-gray-200">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <form action="{{ route('partner.products.store') }}" method="POST" enctype="multipart/form-data" class="pb-20">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Main Form Section -->
            <div class="lg:col-span-8 space-y-10">
                <!-- Section: Basic Info -->
                <div class="bg-white dark:bg-zinc-900 p-10 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-10 pb-6 border-b border-gray-50 dark:border-zinc-800">
                        <div class="w-10 h-10 bg-orange-100 dark:bg-orange-950/20 text-orange-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-circle-info"></i>
                        </div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest italic">Informasi Utama</h3>
                    </div>

                    @include('mitra.products.forms.' . ($type == 'pesawat' ? 'flight' : ($type == 'kereta' ? 'train' : ($type == 'bus' ? 'bus' : ($type == 'hotel' ? 'hotel' : 'wisata')))))

                </div>

                <!-- Section: T&C -->
                <div class="bg-white dark:bg-zinc-900 p-10 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 dark:bg-orange-950/10 rounded-full blur-3xl -mr-10 -mt-10 group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-800 text-zinc-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-scroll"></i>
                        </div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest italic">Ketentuan Layanan</h3>
                    </div>
                    <textarea name="terms" rows="4" placeholder="Sebutkan poin pembatalan, refund, atau syarat penggunaan produk secara detail..."
                        class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-[32px] py-6 px-8 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white leading-relaxed resize-none"></textarea>
                </div>
            </div>

            <!-- Price & Sidebar Section -->
            <div class="lg:col-span-4 space-y-10">
                <div class="bg-gray-900 dark:bg-orange-600 p-10 rounded-[40px] text-white shadow-2xl relative overflow-hidden group">
                    <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl group-hover:scale-125 transition-transform duration-700"></div>
                    <h3 class="text-[10px] font-black uppercase tracking-[0.3em] mb-10 opacity-70 italic">Monetisasi & Quota</h3>

                    <div class="space-y-8 relative z-10">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] mb-3 text-orange-200/80">Rate Harga (Nett)</label>
                            <div class="relative group">
                                <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-xl opacity-40">Rp</span>
                                <input type="number" name="price" required placeholder="0" value="{{ $product->price ?? $product->price_per_night ?? '' }}"
                                    class="w-full bg-white/10 border border-white/20 focus:border-white focus:bg-white/20 rounded-2xl py-5 pl-16 pr-6 outline-none transition-all text-xl font-black text-white placeholder:text-white/20">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] mb-4 text-orange-200/80">Stok Inventori (@if ($type == 'hotel') Kamar @else Tiket @endif)</label>
                            <input type="number" name="stock" required placeholder="Ex: 50" value="{{ $product->seats_available ?? $product->availability ?? '' }}"
                                class="w-full bg-white/10 border border-white/20 focus:border-white focus:bg-white/20 rounded-2xl py-4 px-6 outline-none transition-all text-lg font-black text-white text-center">
                            <p class="mt-4 text-[10px] text-orange-200/50 leading-relaxed font-bold italic">Sistem akan melakukan reservasi otomatis dan mengurangi quota secara real-time.</p>
                        </div>
                    </div>
                </div>

                @if ($type != 'pesawat' && $type != 'kereta')
                <div class="bg-white dark:bg-zinc-900 p-10 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-800 text-zinc-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest italic">Aset Visual</h3>
                    </div>

                    <div class="space-y-10">
                        <x-Form.image-uploader name="image" label="Foto Cover Profil" helper="Rasio 16:9 disarankan" />

                        @if($type == 'hotel')
                                <x-Form.image-uploader name="front_image" label="Fasad Bangunan" />
                                <x-Form.image-uploader name="room_images" label="Interior Kamar" :multiple="true" />
                        @elseif($type == 'wisata' || $type == 'bus')
                            <x-Form.image-uploader name="main_image" label="Foto Ikonik" />
                        @endif

                        <div class="pt-8 border-t border-gray-50 dark:border-zinc-800">
                             <x-Form.image-uploader name="gallery" label="Media Tambahan" :multiple="true" />
                        </div>
                    </div>
                </div>
                @endif

                <button type="submit"
                    class="w-full bg-black dark:bg-orange-500 text-white py-6 rounded-3xl text-sm font-black uppercase tracking-[0.3em] shadow-2xl hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-4 group">
                    <i class="fa-solid fa-rocket group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
                    Daftarkan Produk
                </button>
            </div>
        </div>
    </form>
@endsection