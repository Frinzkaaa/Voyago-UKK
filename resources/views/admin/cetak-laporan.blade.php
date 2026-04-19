@extends('admin.layout')

@section('content')
    <div class="mb-8 lg:mb-14">
        <h1 class="text-2xl lg:text-3xl font-black text-gray-800 dark:text-white tracking-tight leading-none mb-3 uppercase">Cetak Laporan</h1>
        <p class="text-xs lg:text-sm text-gray-400 dark:text-gray-500 font-medium tracking-tight italic">Generate laporan excel & pdf secara otomatis ✨</p>
    </div>

    <!-- Report Generator Card (Responsive Padding) -->
    <div class="card-modern rounded-[32px] lg:rounded-[48px] p-8 lg:p-16 mb-12 shadow-2xl border max-w-6xl">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12 lg:mb-20 pb-8 lg:pb-12 border-b border-gray-50 dark:border-white/5">
            <div>
                <h3 class="text-2xl lg:text-3xl font-black text-gray-800 dark:text-white tracking-tighter uppercase leading-none">Pengaturan Ekspor</h3>
                <p class="text-[10px] lg:text-[11px] font-black text-gray-300 dark:text-gray-600 uppercase tracking-widest mt-2">Pilih periode dan kategori untuk rekapitulasi data</p>
            </div>
            <div class="flex flex-row gap-4">
                <div class="flex-1 flex items-center justify-center gap-3 bg-red-50 dark:bg-red-500/10 px-4 lg:px-8 py-3 lg:py-4 rounded-2xl lg:rounded-3xl border border-red-100 dark:border-red-500/20">
                    <i class="fa-solid fa-file-pdf text-red-500 text-base lg:text-xl"></i>
                    <span class="text-[9px] lg:text-[11px] font-black text-red-500 uppercase tracking-widest leading-none">PDF</span>
                </div>
                <div class="flex-1 flex items-center justify-center gap-3 bg-green-50 dark:bg-green-500/10 px-4 lg:px-8 py-3 lg:py-4 rounded-2xl lg:rounded-3xl border border-green-100 dark:border-green-500/20">
                    <i class="fa-solid fa-file-excel text-green-500 text-base lg:text-xl"></i>
                    <span class="text-[9px] lg:text-[11px] font-black text-green-500 uppercase tracking-widest leading-none">EXCEL</span>
                </div>
            </div>
        </div>

        <form id="reportForm" action="{{ route('admin.export.laporan') }}" method="GET" target="_blank" class="space-y-8 lg:space-y-14">
            <input type="hidden" name="format" id="exportFormat" value="pdf">
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-12">
                <!-- Filter Kategori -->
                <div class="space-y-3">
                    <label class="text-[10px] lg:text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-4 lg:ml-6">Kategori Laporan</label>
                    <div class="relative group">
                        <i class="fa-solid fa-layer-group absolute left-6 lg:left-8 top-1/2 -translate-y-1/2 text-orange-400 text-base lg:text-lg"></i>
                        <select name="category" required
                            class="w-full bg-gray-50 dark:bg-white/5 border border-transparent dark:border-white/10 rounded-2xl lg:rounded-3xl py-4 lg:py-6 pl-14 lg:pl-16 pr-8 lg:pr-10 text-sm lg:text-base font-bold text-gray-700 dark:text-white outline-none focus:ring-8 focus:ring-orange-500/5 transition-all appearance-none cursor-pointer">
                            <option value="transaksi">Monitoring Transaksi</option>
                            <option value="mitra">Verifikasi Mitra</option>
                            <option value="komplain">Monitoring Komplain</option>
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-6 lg:right-8 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <!-- Filter Bulan -->
                <div class="space-y-3">
                    <label class="text-[10px] lg:text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-4 lg:ml-6">Periode Bulan</label>
                    <div class="relative group">
                        <i class="fa-solid fa-calendar-alt absolute left-6 lg:left-8 top-1/2 -translate-y-1/2 text-orange-400 text-base lg:text-lg"></i>
                        <select name="month"
                            class="w-full bg-gray-50 dark:bg-white/5 border border-transparent dark:border-white/10 rounded-2xl lg:rounded-3xl py-4 lg:py-6 pl-14 lg:pl-16 pr-8 lg:pr-10 text-sm lg:text-base font-bold text-gray-700 dark:text-white outline-none focus:ring-8 focus:ring-orange-500/5 transition-all appearance-none cursor-pointer">
                            <option value="">Semua Bulan</option>
                            @foreach(['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'] as $index => $name)
                                <option value="{{ $index + 1 }}">{{ $name }}</option>
                            @endforeach
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-6 lg:right-8 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-xs"></i>
                    </div>
                </div>

                <!-- Filter Tahun -->
                <div class="space-y-3">
                    <label class="text-[10px] lg:text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-4 lg:ml-6">Tahun Anggaran</label>
                    <div class="relative group">
                        <i class="fa-solid fa-clock-rotate-left absolute left-6 lg:left-8 top-1/2 -translate-y-1/2 text-orange-400 text-base lg:text-lg"></i>
                        <select name="year"
                            class="w-full bg-gray-50 dark:bg-white/5 border border-transparent dark:border-white/10 rounded-2xl lg:rounded-3xl py-4 lg:py-6 pl-14 lg:pl-16 pr-8 lg:pr-10 text-sm lg:text-base font-bold text-gray-700 dark:text-white outline-none focus:ring-8 focus:ring-orange-500/5 transition-all appearance-none cursor-pointer">
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}">{{ $y }}</option>
                            @endfor
                        </select>
                        <i class="fa-solid fa-chevron-down absolute right-6 lg:right-8 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Date Range (Responsive Stack) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <div class="space-y-3">
                    <label class="text-[10px] lg:text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-4 lg:ml-6">Dari Tanggal (Opsional)</label>
                    <div class="relative group">
                        <i class="fa-solid fa-calendar-day absolute left-6 lg:left-8 top-1/2 -translate-y-1/2 text-[#3D2305] dark:text-orange-400 text-base lg:text-lg"></i>
                        <input type="date" name="start_date"
                            class="w-full bg-gray-50 dark:bg-white/5 border border-transparent dark:border-white/10 rounded-2xl lg:rounded-3xl py-4 lg:py-6 pl-14 lg:pl-16 pr-6 text-sm lg:text-base font-bold text-gray-700 dark:text-white outline-none focus:ring-8 focus:ring-orange-500/5 transition-all cursor-pointer">
                    </div>
                </div>
                <div class="space-y-3">
                    <label class="text-[10px] lg:text-[11px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] ml-4 lg:ml-6">Sampai Tanggal (Opsional)</label>
                    <div class="relative group">
                        <i class="fa-solid fa-calendar-day absolute left-6 lg:left-8 top-1/2 -translate-y-1/2 text-[#3D2305] dark:text-orange-400 text-base lg:text-lg"></i>
                        <input type="date" name="end_date"
                            class="w-full bg-gray-50 dark:bg-white/5 border border-transparent dark:border-white/10 rounded-2xl lg:rounded-3xl py-4 lg:py-6 pl-14 lg:pl-16 pr-6 text-sm lg:text-base font-bold text-gray-700 dark:text-white outline-none focus:ring-8 focus:ring-orange-500/5 transition-all cursor-pointer">
                    </div>
                </div>
            </div>

            <!-- Action Buttons (Responsive Size) -->
            <div class="flex flex-col lg:flex-row gap-6 pt-8 lg:pt-12">
                <button type="submit" onclick="submitReport('pdf')"
                    class="flex-[2] bg-[#FF7304] text-white py-6 lg:py-8 rounded-[24px] lg:rounded-[32px] font-black text-xs lg:text-sm uppercase tracking-[0.3em] lg:tracking-[0.4em] shadow-2xl shadow-orange-500/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-4 lg:gap-6">
                    <i class="fa-solid fa-file-pdf text-xl lg:text-2xl"></i>
                    EKSPOR (PDF)
                </button>
                <button type="submit" onclick="submitReport('excel')"
                    class="flex-1 bg-gray-900 dark:bg-white text-white dark:text-black py-6 lg:py-8 px-8 lg:px-12 rounded-[24px] lg:rounded-[32px] font-black text-xs lg:text-sm uppercase tracking-[0.3em] lg:tracking-[0.4em] shadow-2xl hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-4 lg:gap-6">
                    <i class="fa-solid fa-file-excel text-xl lg:text-2xl text-green-500"></i>
                    CSV
                </button>
            </div>
        </form>
    </div>

    <!-- Info Section (Responsive) -->
    <div class="bg-indigo-50 dark:bg-indigo-950/20 border border-indigo-100 dark:border-indigo-800/50 rounded-[32px] lg:rounded-[40px] p-6 lg:p-10 max-w-6xl flex items-center gap-6 lg:gap-10 group">
        <div class="w-14 h-14 lg:w-20 lg:h-20 bg-white dark:bg-white/5 rounded-2xl lg:rounded-3xl flex items-center justify-center text-indigo-500 shadow-sm shrink-0">
            <i class="fa-solid fa-shield-halved text-xl lg:text-3xl"></i>
        </div>
        <div>
            <h4 class="text-sm lg:text-base font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-tighter mb-1 lg:mb-2 leading-none italic">Sistem Audit Aman</h4>
            <p class="text-[10px] lg:text-[11px] font-bold text-indigo-400 dark:text-indigo-500 uppercase tracking-[0.1em] leading-relaxed">Generated logs recorded for audit.</p>
        </div>
    </div>

    <script>
        function submitReport(format) {
            document.getElementById('exportFormat').value = format;
        }
    </script>
@endsection