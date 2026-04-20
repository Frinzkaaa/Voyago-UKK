<div id="section-delete" class="settings-section hidden">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-8">Hapus Akun</h1>
    <div class="bg-red-50/50 rounded-[24px] p-8 shadow-sm border-2 border-red-100 border-dashed">
        <div class="flex items-center gap-4 mb-6">
            <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                <i class="fa-solid fa-triangle-exclamation text-2xl"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-red-600">Zona Bahaya</h3>
                <p class="text-sm text-red-500">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
        </div>
        <p class="text-sm text-gray-600 dark:text-[#A1A1AA] mb-8 leading-relaxed">
            Menghapus akun Anda akan menghapus secara permanen semua riwayat pemesanan, tiket yang tersimpan,
            saldo voucher, dan data perencanaan kolaboratif Anda. Pastikan Anda telah mengunduh semua data
            penting sebelum melanjutkan.
        </p>
        <form action="{{ route('account.delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun secara permanen? Seluruh data Anda tidak akan bisa dikembalikan.')">
            @csrf
            <button type="submit"
                class="w-full md:w-auto px-8 py-4 bg-red-600 text-white rounded-2xl font-bold shadow-lg shadow-red-100 hover:bg-red-700 hover:scale-105 transition-all uppercase tracking-widest text-sm">
                Hapus Akun Permanen
            </button>
        </form>
    </div>
</div>