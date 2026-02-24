@extends('mitra.layout')

@section('content')
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 tracking-tight">Akun & Preferensi</h2>
        <p class="text-sm text-gray-500 mt-1">Kelola identitas bisnis dan konfigurasi finansial mitra</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 space-y-8">
            <div class="premium-card p-6 bg-white border border-gray-100">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                    Profil Bisnis</h3>
                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Entitas
                            Bisnis</label>
                        <input type="text" value="{{ Auth::user()->name }}"
                            class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Email
                                Korespondensi</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled
                                class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-sm font-medium text-gray-400 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Tipe
                                Layanan</label>
                            <input type="text" value="{{ Auth::user()->partner->service_type ?? 'Penyedia Layanan' }}"
                                disabled
                                class="w-full bg-gray-50 border border-gray-200 p-3 rounded text-sm font-medium text-gray-400 cursor-not-allowed">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Deskripsi
                            Bisnis (Bio)</label>
                        <textarea rows="3" placeholder="Gambarkan keunggulan layanan bisnis Anda..."
                            class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium resize-none"></textarea>
                    </div>
                </div>
            </div>

            <div class="premium-card p-6 bg-white border border-gray-100">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                    Informasi Pembayaran</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Institusi
                            Perbankan</label>
                        <select
                            class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                            <option>BCA</option>
                            <option>Mandiri</option>
                            <option>BNI</option>
                            <option>BRI</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nomor
                            Rekening</label>
                        <input type="text" placeholder="1234xxxxxx"
                            class="w-full bg-gray-50 border border-gray-200 focus:border-orange-500 focus:bg-white p-3 rounded outline-none transition-all text-sm font-medium">
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="premium-card p-6 bg-white border border-gray-100">
                <h3 class="text-xs font-bold text-gray-900 uppercase tracking-widest mb-6 pb-4 border-b border-gray-50">
                    Status Kemitraan</h3>
                <div class="flex items-center gap-4 p-4 bg-emerald-50 border border-emerald-100 rounded">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-shield-check text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-emerald-700 text-sm">Terverifikasi</p>
                        <p class="text-[9px] text-emerald-500 font-bold uppercase tracking-widest">Active Partner</p>
                    </div>
                </div>

                <p class="text-[10px] text-gray-400 mt-6 leading-relaxed">Bergabung dengan Voyago sejak
                    {{ Auth::user()->created_at->format('d F Y') }}. Semua fitur dashboard anda telah terbuka sepenuhnya.
                </p>

                <button
                    class="w-full bg-gray-900 text-white py-3 rounded text-[10px] font-bold uppercase tracking-widest mt-8 shadow-sm hover:bg-black transition-colors">
                    Perbarui Profil
                </button>
            </div>
        </div>
    </div>
@endsection