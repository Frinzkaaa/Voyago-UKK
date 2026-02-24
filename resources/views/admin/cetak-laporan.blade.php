@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Hi, Admin Voyago!</h1>
        <p class="text-gray-400 font-medium tracking-tight">Generate laporan excel & pdf disini</p>
    </div>

    <!-- Report Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <!-- Report Generation Section -->
        <div class="space-y-10">
            <div class="bg-white rounded-[40px] p-10 shadow-sm border border-gray-50">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-8 mb-10">
                    <div>
                        <h3 class="text-2xl font-black text-gray-800 tracking-tight">Pengaturan Laporan</h3>
                        <p class="text-xs font-bold text-gray-300 uppercase tracking-widest mt-1">Pilih periode dan kategori
                            untuk rekapitulasi data</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="flex items-center gap-2 bg-red-50 px-6 py-3 rounded-2xl">
                            <i class="fa-solid fa-file-pdf text-red-500"></i>
                            <span class="text-xs font-black text-red-500">Auto-PDF</span>
                        </div>
                        <div class="flex items-center gap-2 bg-green-50 px-6 py-3 rounded-2xl">
                            <i class="fa-solid fa-file-excel text-green-500"></i>
                            <span class="text-xs font-black text-green-500">Auto-Excel</span>
                        </div>
                    </div>
                </div>

                <form id="reportForm" action="{{ route('admin.export.laporan') }}" method="GET" target="_blank"
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                    <input type="hidden" name="format" id="exportFormat" value="pdf">
                    <!-- Filter Kategori -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Kategori
                            Laporan</label>
                        <div class="relative group">
                            <i class="fa-solid fa-layer-group absolute left-5 top-1/2 -translate-y-1/2 text-orange-400"></i>
                            <select name="category" required
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-14 pr-6 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-orange-50 appearance-none outline-none transition-all">
                                <option value="transaksi">Monitoring Transaksi</option>
                                <option value="mitra">Verifikasi Mitra</option>
                                <option value="komplain">Monitoring Komplain</option>
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 text-[10px] pointer-events-none group-hover:text-orange-400 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Filter Bulan -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Bulan</label>
                        <div class="relative group">
                            <i
                                class="fa-solid fa-calendar-alt absolute left-5 top-1/2 -translate-y-1/2 text-orange-400"></i>
                            <select name="month"
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-14 pr-6 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-orange-50 appearance-none outline-none transition-all">
                                <option value="">Semua Bulan</option>
                                @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $name)
                                    <option value="{{ $index + 1 }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 text-[10px] pointer-events-none group-hover:text-orange-400 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Filter Tahun -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Tahun</label>
                        <div class="relative group">
                            <i
                                class="fa-solid fa-clock-rotate-left absolute left-5 top-1/2 -translate-y-1/2 text-orange-400"></i>
                            <select name="year"
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-14 pr-6 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-orange-50 appearance-none outline-none transition-all">
                                @for($y = date('Y'); $y >= 2024; $y--)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endfor
                            </select>
                            <i
                                class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 text-[10px] pointer-events-none group-hover:text-orange-400 transition-colors"></i>
                        </div>
                    </div>

                    <!-- Tanggal Mulai -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Dari
                            Tanggal</label>
                        <div class="relative group">
                            <i
                                class="fa-solid fa-calendar-day absolute left-5 top-1/2 -translate-y-1/2 text-orange-400"></i>
                            <input type="date" name="start_date"
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-14 pr-6 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-orange-50 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Tanggal Selesai -->
                    <div class="space-y-3">
                        <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest ml-4">Sampai
                            Tanggal</label>
                        <div class="relative group">
                            <i class="fa-solid fa-calendar-day absolute left-5 top-1/2 -translate-y-1/2 text-[#3D2305]"></i>
                            <input type="date" name="end_date"
                                class="w-full bg-gray-50 border-none rounded-2xl py-4 pl-14 pr-6 text-sm font-bold text-gray-700 focus:ring-4 focus:ring-orange-50 outline-none transition-all">
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="lg:col-span-4 grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <button type="submit" onclick="submitReport('pdf')"
                            class="bg-[#FF7304] text-white py-5 rounded-[24px] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-orange-100 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-4">
                            <i class="fa-solid fa-print text-lg"></i>
                            CETAK LAPORAN (PDF)
                        </button>
                        <button type="submit" onclick="submitReport('excel')"
                            class="bg-gray-900 text-white py-5 rounded-[24px] font-black text-xs uppercase tracking-[0.2em] shadow-xl shadow-gray-200 hover:bg-black hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-4">
                            <i class="fa-solid fa-file-excel text-lg text-green-400"></i>
                            UNDUH EXCEL (CSV)
                        </button>
                    </div>
                </form>

                <script>
                    function submitReport(format) {
                        document.getElementById('exportFormat').value = format;
                    }
                </script>
            </div>

            <!-- Preview Section (Real-time dummy indicator) -->
            <div
                class="bg-gray-50 border-2 border-dashed border-gray-200 rounded-[40px] p-20 flex flex-col items-center justify-center text-center">
                <div
                    class="w-24 h-24 bg-white rounded-full flex items-center justify-center text-orange-400 shadow-sm mb-6">
                    <i class="fa-solid fa-file-circle-check text-4xl"></i>
                </div>
                <h4 class="text-lg font-black text-gray-800 mb-2">Siap untuk Generate Laporan</h4>
                <p class="text-sm text-gray-400 max-w-sm font-medium">Laporan akan mencakup seluruh data transaksi,
                    verifikasi mitra, dan monitoring komplain sesuai periode yang Anda pilih.</p>
            </div>
        </div>
    </div>
@endsection