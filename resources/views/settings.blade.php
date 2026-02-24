@extends('layouts.app')

@section('content')
    <div class="flex flex-col md:flex-row gap-8 min-h-[600px] max-w-[1280px] mx-auto">

        <!-- Left Sidebar -->
        <x-pengaturan.sidebar />

        <!-- Main Content Area -->
        <div class="flex-grow">
            @if(session('success'))
                <div
                    class="bg-green-50 text-green-600 p-4 rounded-2xl mb-6 text-sm flex items-center gap-3 border border-green-100 animate-fade-in">
                    <i class="fa-solid fa-circle-check text-lg"></i>
                    <span class="font-bold">{{ session('success') }}</span>
                </div>
            @endif

            <!-- Section 1: Akun & Keamanan -->
            <x-pengaturan.keamanan />

            <!-- Section 2: Notifikasi -->
            <x-pengaturan.notifikasi />

            <!-- Section 3: Pembayaran -->
            <x-pengaturan.pembayaran :methods="$paymentMethods" />

            <!-- Section 4: Privasi -->
            <x-pengaturan.privasi />

            <!-- Section 5: Preferensi -->
            <x-pengaturan.preferensi />

            <!-- Section 6: Hapus Akun -->
            <x-pengaturan.hapus-akun />

        </div>
    </div>

    <style>
        .active-nav {
            background-color: #FF7304 !important;
        }

        .active-nav span {
            color: white !important;
        }

        .active-nav i {
            color: white !important;
        }

        .hidden {
            display: none !important;
        }
    </style>

    <script>
        function switchSetting(sectionId) {
            // Update Sidebar
            document.querySelectorAll('aside button').forEach(btn => {
                btn.classList.remove('active-nav');
            });
            document.getElementById('btn-' + sectionId).classList.add('active-nav');

            // Update Sections
            document.querySelectorAll('.settings-section').forEach(section => {
                section.classList.add('hidden');
            });
            document.getElementById('section-' + sectionId).classList.remove('hidden');
        }
    </script>
@endsection