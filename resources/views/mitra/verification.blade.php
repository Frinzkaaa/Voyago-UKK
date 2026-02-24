<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun - Voyago Business</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }

        .pulse-animation {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }
    </style>
</head>

@php
    $user = auth()->user();
    $status = $user->status instanceof \BackedEnum ? $user->status->value : $user->status;
    $isActive = $status === 'active';
    $isRejected = $status === 'rejected';
    $partner = $user->partner;
@endphp

<body class="min-h-screen flex items-center justify-center p-6 bg-gray-50/50">
    <div
        class="max-w-md w-full bg-white rounded border border-gray-100 p-10 text-center shadow-xl relative overflow-hidden">

        @if($isActive)
            <!-- ACTIVE STATUS -->
            <div
                class="w-16 h-16 bg-emerald-50 rounded-full flex items-center justify-center mx-auto mb-8 border border-emerald-100">
                <i class="fa-solid fa-circle-check text-2xl text-emerald-500"></i>
            </div>
            <h1 class="text-xl font-bold text-gray-900 mb-3 tracking-tight">Akun Terverifikasi</h1>
            <p class="text-sm text-gray-500 mb-8 leading-relaxed">
                Selamat! Peninjauan dokumen Anda telah selesai. Anda kini resmi menjadi <span
                    class="text-gray-900 font-bold">Mitra Strategis Voyago</span>.
            </p>
            <div class="space-y-4">
                <a href="{{ route('partner.dashboard') }}"
                    class="w-full bg-gray-900 text-white py-3.5 rounded text-[11px] font-bold uppercase tracking-widest shadow-sm hover:bg-black transition-all flex items-center justify-center gap-2">
                    Lanjut ke Dashboard
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>

        @elseif($isRejected)
            <!-- REJECTED STATUS -->
            <div
                class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-8 border border-red-100 text-red-500">
                <i class="fa-solid fa-circle-xmark text-2xl"></i>
            </div>
            <h1 class="text-xl font-bold text-gray-900 mb-2 tracking-tight">Verifikasi Ditolak</h1>
            <p class="text-sm text-gray-500 mb-6 leading-relaxed">
                Mohon maaf, aplikasi kemitraan Anda belum dapat kami setujui karena beberapa kendala pada data.
            </p>

            <div class="bg-gray-50 border border-gray-100 rounded p-4 mb-8 text-left">
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mb-2">Catatan Penolakan:</p>
                <p class="text-[11px] font-medium text-red-600 italic leading-relaxed">
                    "{{ $partner->rejection_reason ?? 'Data yang dilampirkan tidak sesuai dengan standar verifikasi kami.' }}"
                </p>
            </div>

            <div class="flex flex-col gap-3">
                <a href="{{ route('partner.logout') }}"
                    class="w-full bg-gray-900 text-white py-3.5 rounded text-[11px] font-bold uppercase tracking-widest shadow-sm hover:bg-black transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-rotate-left text-[10px]"></i>
                    Ulangi Pendaftaran
                </a>
                <p class="text-[9px] text-gray-400 font-medium">Anda dapat mendaftar kembali dengan memperbaiki data di
                    atas.</p>
            </div>

        @else
            <!-- PENDING STATUS -->
            <div
                class="w-16 h-16 bg-orange-50 rounded-full flex items-center justify-center mx-auto mb-8 border border-orange-100 text-orange-500 pulse-animation">
                <i class="fa-solid fa-hourglass-half text-xl"></i>
            </div>

            <h1 class="text-xl font-bold text-gray-900 mb-3 tracking-tight">Sedang Ditinjau</h1>
            <p class="text-sm text-gray-500 mb-10 leading-relaxed">
                Tim kurasi Voyago sedang memverifikasi identitas bisnis Anda. Proses ini biasanya memakan waktu <span
                    class="text-gray-900 font-bold">1-2 hari kerja</span>.
            </p>

            <div class="space-y-5 mb-10 relative">
                <div class="absolute left-4 top-2 bottom-2 w-px bg-gray-100"></div>

                <div class="flex items-center gap-4 relative">
                    <div
                        class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white ring-4 ring-white shadow-sm">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-[11px] font-bold text-gray-900">Pendaftaran Akun</p>
                        <p class="text-[9px] text-gray-400 font-medium">Selesai pada
                            {{ $user->created_at->format('d M Y') }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 relative">
                    <div
                        class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-white ring-4 ring-white shadow-sm pulse-animation">
                        <i class="fa-solid fa-spinner fa-spin text-[10px]"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-[11px] font-bold text-gray-900">Kurasi Dokumen</p>
                        <p class="text-[9px] text-orange-500 font-bold uppercase tracking-widest">In Progress</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 relative opacity-30">
                    <div
                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 ring-4 ring-white shadow-sm">
                        <i class="fa-solid fa-rocket text-[10px]"></i>
                    </div>
                    <div class="text-left">
                        <p class="text-[11px] font-bold text-gray-900">Dashboard Aktif</p>
                        <p class="text-[9px] text-gray-400 font-medium">Tahap Terakhir</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <a href="https://wa.me/628123456789"
                    class="w-full bg-white border border-gray-200 text-gray-700 py-3 rounded text-[10px] font-bold uppercase tracking-widest hover:bg-gray-50 transition-all flex items-center justify-center gap-2">
                    <i class="fa-brands fa-whatsapp text-sm"></i>
                    Bantuan CS
                </a>
                <a href="{{ route('partner.logout') }}"
                    class="text-[9px] text-gray-400 font-bold hover:text-gray-600 transition-all uppercase tracking-widest">Keluar</a>
            </div>
        @endif
    </div>
</body>

</html>