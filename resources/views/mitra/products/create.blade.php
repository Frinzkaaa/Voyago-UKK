@extends('mitra.layout')

@section('content')
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div class="space-y-1">
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase italic">
                @if ($type == 'hotel') Registrasi Akomodasi @elseif($type == 'pesawat') Flight Listing @elseif($type == 'kereta') Rail Management @elseif($type == 'bus') Transport Entry @else Atraksi Wisata @endif
            </h2>
            <p class="text-sm text-gray-500 dark:text-zinc-400 font-medium">Lengkapi metadata layanan dengan teliti untuk memikat pelanggan.</p>
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

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">
                                @if ($type == 'pesawat') Nama Maskapai @elseif($type == 'bus') PO Bus / Operator @else Judul Layanan / Nama Properti @endif
                            </label>
                            <input type="text" name="name" required
                                placeholder="@if($type == 'hotel') Ex: Villa Tanah Gajah Ubud @elseif($type == 'pesawat') Ex: Emirates Airways @else Ex: Nama Layanan Anda @endif"
                                class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white placeholder:text-gray-300">
                        </div>

                        @if ($type == 'pesawat' || $type == 'kereta')
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Kode Unik / No. Armada</label>
                                <input type="text" name="code" required
                                    placeholder="Ex: EK-034"
                                    class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
                            </div>
                        @endif

                        @if ($type == 'hotel' || $type == 'wisata')
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">
                                    @if ($type == 'hotel') Klasifikasi Kamar @else Kategori @endif
                                </label>
                                <input type="text" name="@if ($type == 'hotel') room_type @else category @endif" required
                                    placeholder="Ex: Superior Luxury"
                                    class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
                            </div>
                        @else
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Kelas Pelayanan</label>
                                <select name="class" required
                                    class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-black text-gray-500 dark:text-zinc-400 appearance-none cursor-pointer">
                                    <option value="Economy">Economy</option>
                                    <option value="Business">Business</option>
                                    <option value="Executive">Executive</option>
                                    <option value="Premium">Premium</option>
                                </select>
                            </div>
                        @endif

                        @if ($type == 'hotel' || $type == 'wisata')
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Alamat / Lokasi Presisi</label>
                                <input type="text" name="location" required placeholder="Jl. Raya Canggu No. 10..."
                                    class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
                            </div>
                        @else
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Origin (Dari)</label>
                                <input type="text" name="origin" required placeholder="Ex: Jakarta (CGK)"
                                    class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Destination (Ke)</label>
                                <input type="text" name="destination" required placeholder="Ex: London (LHR)"
                                    class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
                            </div>
                        @endif

                        @if ($type != 'hotel' && $type != 'wisata')
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Departure (Keberangkatan)</label>
                                <input type="datetime-local" name="departure_time" required
                                    class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Est. Arrival (Tiba)</label>
                                <div class="flex gap-4">
                                    <input type="datetime-local" name="arrival_time"
                                        class="flex-grow bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-6 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white">
                                    <input type="text" name="duration" placeholder="Ex: 8j 45m"
                                        class="w-32 bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-2xl py-4 px-2 outline-none transition-all text-sm font-bold text-center text-gray-900 dark:text-white">
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($type == 'wisata' || $type == 'hotel')
                        <div class="mt-10">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-3">Highlight & Deskripsi</label>
                            <textarea name="description" rows="6" @if($type == 'wisata') required @endif
                                placeholder="Jelaskan detail unik, fasilitas, dan apa yang membuat layanan ini spesial..."
                                class="w-full bg-white dark:bg-zinc-950 border border-gray-200 dark:border-zinc-800 focus:border-orange-500 rounded-[32px] py-6 px-8 outline-none transition-all text-sm font-bold text-gray-900 dark:text-white leading-relaxed resize-none"></textarea>
                        </div>
                    @endif
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
                    <textarea name="terms" rows="4"
                        placeholder="Jabarkan syarat pembatalan, refund, atau peraturan khusus bagi tamu..."
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
                                <input type="number" name="price" required placeholder="0"
                                    class="w-full bg-white/10 border border-white/20 focus:border-white focus:bg-white/20 rounded-2xl py-5 pl-16 pr-6 outline-none transition-all text-xl font-black text-white placeholder:text-white/20">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] mb-4 text-orange-200/80">Stok Inventori (@if ($type == 'hotel') Kamar @else Tiket @endif)</label>
                            <input type="number" name="quota" required placeholder="Ex: 50"
                                class="w-full bg-white/10 border border-white/20 focus:border-white focus:bg-white/20 rounded-2xl py-4 px-6 outline-none transition-all text-lg font-black text-white text-center">
                            <p class="mt-4 text-[10px] text-orange-200/50 leading-relaxed font-bold italic">Sistem akan melakukan reservasi otomatis dan mengurangi quota secara real-time.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-zinc-900 p-10 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="w-10 h-10 bg-zinc-100 dark:bg-zinc-800 text-zinc-500 rounded-xl flex items-center justify-center">
                            <i class="fa-solid fa-images"></i>
                        </div>
                        <h3 class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-widest italic">Aset Visual</h3>
                    </div>

                    <div class="space-y-10">
                        <x-Form.image-uploader name="image" label="Foto Cover Profil" helper="Rasio 16:9 disarankan" :required="true" />

                        @if ($type == 'pesawat')
                            <x-Form.image-uploader name="airline_logo" label="Logo Maskapai" />
                        @elseif($type == 'kereta')
                            <x-Form.image-uploader name="train_images" label="Foto Exterior" :multiple="true" />
                        @elseif($type == 'hotel')
                                <x-Form.image-uploader name="front_image" label="Fasad Bangunan" :required="true" />
                                <x-Form.image-uploader name="room_images" label="Interior Kamar" :multiple="true" />
                        @elseif($type == 'wisata' || $type == 'bus')
                            <x-Form.image-uploader name="main_image" label="Foto Ikonik" :required="true" />
                        @endif

                        <div class="pt-8 border-t border-gray-50 dark:border-zinc-800">
                             <x-Form.image-uploader name="gallery" label="Media Tambahan" :multiple="true" />
                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-black dark:bg-orange-500 text-white py-6 rounded-3xl text-sm font-black uppercase tracking-[0.3em] shadow-2xl hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-4 group">
                    <i class="fa-solid fa-sparkles group-hover:rotate-45 transition-transform"></i>
                    Publish Sekarang
                </button>
            </div>
        </div>
    </form>
@endsection