@extends('mitra.layout')

@section('content')
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Tambah Inventori
                @if ($type == 'hotel')
                Hotel & Akomodasi @elseif($type == 'pesawat') Tiket Pesawat @elseif($type == 'kereta') Tiket Kereta Api
                @elseif($type == 'bus') Tiket Bus & Travel @else Produk Wisata
                @endif
            </h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi data produk sesuai dengan profil layanan bisnis Anda</p>
        </div>
        <a href="{{ route('partner.products') }}"
            class="text-[10px] font-bold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-widest flex items-center gap-2">
            <i class="fa-solid fa-xmark"></i>
            Batal
        </a>
    </div>

    <form action="{{ route('partner.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Main Form Section -->
            <div class="lg:col-span-8 space-y-8">
                <div class="premium-card p-6 bg-white border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                        Informasi Dasar</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">
                                @if ($type == 'pesawat')
                                    Nama Maskapai / Operator
                                @elseif($type == 'bus')
                                    Nama Operator Bus
                                @else
                                    Nama Produk / @if ($type == 'hotel') Hotel @else Atraksi @endif
                                @endif
                            </label>
                            <input type="text" name="name" required
                                placeholder="Contoh: @if($type == 'hotel') The Ritz-Carlton Mega Kuningan @elseif($type == 'pesawat') Garuda Indonesia Airways @elseif($type == 'kereta') KA Argo Bromo Anggrek @elseif($type == 'bus') PO Lorena Transport @else Tiket Terusan Dufan @endif"
                                class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                        </div>

                        @if ($type == 'pesawat' || $type == 'kereta')
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Kode
                                    @if ($type == 'pesawat') Penerbangan @else Trayek/No Kereta @endif</label>
                                <input type="text" name="code" required
                                    placeholder="Contoh: @if ($type == 'pesawat') GA-402 @else KA-001 @endif"
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                            </div>
                        @endif

                        @if ($type == 'hotel' || $type == 'wisata')
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">
                                    @if ($type == 'hotel') Tipe Kamar/Unit @else Kategori Wisata @endif
                                </label>
                                <input type="text" name="@if ($type == 'hotel') room_type @else category @endif" required
                                    placeholder="@if ($type == 'hotel') Deluxe Ocean View @else Theme Park / Nature @endif"
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                            </div>
                        @else
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Kelas
                                    Layanan</label>
                                <select name="class" required
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium cursor-pointer">
                                    <option value="Economy">Economy Class</option>
                                    <option value="Business">Business Class</option>
                                    <option value="Executive">Executive Class</option>
                                    <option value="Standard">Standard Class</option>
                                </select>
                            </div>
                        @endif

                        @if ($type == 'hotel' || $type == 'wisata')
                            <div class="md:col-span-2">
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Lokasi
                                    Terdaftar</label>
                                <input type="text" name="location" required placeholder="Contoh: Seminyak, Bali - Indonesia"
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                            </div>
                        @else
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Titik
                                    Keberangkatan</label>
                                <input type="text" name="origin" required
                                    placeholder="Contoh: @if($type == 'pesawat') Jakarta (CGK) @elseif($type == 'kereta') Surabaya Gubeng (SGU) @else Terminal Lebak Bulus @endif"
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Titik
                                    Kedatangan</label>
                                <input type="text" name="destination" required
                                    placeholder="Contoh: @if($type == 'pesawat') Singapore (SIN) @elseif($type == 'kereta') Yogyakarta (YK) @else Terminal Bungurasih @endif"
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                            </div>
                        @endif

                        @if ($type != 'hotel' && $type != 'wisata')
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Jadwal
                                    Berangkat</label>
                                <input type="datetime-local" name="departure_time" required
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Estimasi
                                    Tiba & Durasi</label>
                                <div class="flex gap-2">
                                    <input type="datetime-local" name="arrival_time"
                                        class="flex-grow bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                                    <input type="text" name="duration" placeholder="Ex: 2j 15m"
                                        class="w-24 bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium text-center">
                                </div>
                            </div>
                        @endif
                    </div>

                    @if ($type == 'wisata' || $type == 'hotel')
                        <div class="mt-6">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi
                                Produk & Layanan</label>
                            <textarea name="description" rows="5" @if($type == 'wisata') required @endif
                                placeholder="@if($type == 'hotel') Jelaskan fasilitas eksklusif, tipe bed, pemandangan, dan kelengkapan kamar lainnya... @else Deskripsikan daya tarik utama, jam operasional, dan pengalaman unik yang ditawarkan... @endif"
                                class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium resize-none leading-relaxed"></textarea>
                        </div>
                    @endif
                </div>

                <div class="premium-card p-6 bg-white border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                        Kebijakan & Syarat</h3>
                    <textarea name="terms" rows="4"
                        placeholder="Jabarkan syarat pembatalan, pengembalian dana, atau ketentuan khusus lainnya bagi pelanggan..."
                        class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium resize-none leading-relaxed"></textarea>
                </div>
            </div>

            <!-- Price & Media Section -->
            <div class="lg:col-span-4 space-y-8">
                <div class="premium-card p-6 bg-white border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                        Harga & Ketersediaan</h3>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Harga
                                @if($type == 'hotel') per Malam @else per Tiket @endif (IDR)</label>
                            <div class="relative group">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 font-bold text-gray-400 text-xs">Rp</span>
                                <input type="number" name="price" required placeholder="0"
                                    class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 pl-10 rounded outline-none transition-all text-sm font-bold text-gray-900">
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Kuota
                                @if ($type == 'hotel') Kamar @else Stok Tiket @endif</label>
                            <input type="number" name="quota" required placeholder="Ex: 25"
                                class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-bold text-gray-900 text-center">
                            <p class="mt-3 text-[9px] text-gray-400 leading-relaxed italic">Inventori akan terupdate
                                otomatis saat terjadi pemesanan sukses oleh pelanggan.</p>
                        </div>
                    </div>
                </div>

                <div class="premium-card p-6 bg-white border border-gray-100 shadow-sm">
                    <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-1">Visual Produk</h3>
                    <p class="text-[9px] text-gray-400 font-medium uppercase tracking-widest mb-8">Lampirkan foto resolusi
                        terbaik</p>

                    <div class="space-y-10">
                        {{-- Common: Thumbnail --}}
                        <x-Form.image-uploader name="image" label="Foto Utama (Cover)"
                            helper="Rasio 4:3 disarankan (Maks. 2MB)" :required="true" />

                        {{-- Category Specific Media --}}
                        @if ($type == 'pesawat')
                            <x-Form.image-uploader name="airline_logo" label="Logo Maskapai"
                                helper="PNG transparent (Maks. 1MB)" :required="true" />
                            <x-Form.image-uploader name="interior_images" label="Interior Kabin" :multiple="true" />
                        @elseif($type == 'kereta')
                            <x-Form.image-uploader name="train_images" label="Eksterior Kereta" :multiple="true"
                                :required="true" />
                            <x-Form.image-uploader name="seat_images" label="Tampilan Kursi" :multiple="true" />
                        @elseif($type == 'hotel')
                                <x-Form.image-uploader name="front_image" label="Fasad Bangunan" :required="true" />
                                <x-Form.image-uploader name="room_images" label="Interior Kamar" :multiple="true"
                                    :required="true" />
                            </div>
                        @elseif($type == 'wisata' || $type == 'bus')
                        <x-Form.image-uploader name="main_image" label="Foto Ikonik" :required="true" />
                        <x-Form.image-uploader name="spot_images" label="Gallery Spot" :multiple="true" :required="true" />
                    @endif

                    {{-- Common: Gallery --}}
                    <div class="pt-8 border-t border-gray-100">
                        <x-Form.image-uploader name="gallery" label="Media Pendukung" :multiple="true" />
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-gray-900 text-white py-4 rounded text-[10px] font-bold uppercase tracking-widest shadow-md hover:bg-black transition-all flex items-center justify-center gap-2 mt-8">
                    <i class="fa-solid fa-cloud-arrow-up text-[10px]"></i>
                    Publikasikan Inventori
                </button>
            </div>
        </div>
        </div>
    </form>
@endsection