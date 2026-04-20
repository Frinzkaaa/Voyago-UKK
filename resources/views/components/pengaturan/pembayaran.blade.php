@props(['methods' => []])

<div id="section-payment" class="settings-section hidden">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Metode Pembayaran</h1>
        <button onclick="togglePaymentModal()"
            class="bg-orange-50 text-[#FF7304] px-5 py-2.5 rounded-full font-bold text-sm hover:bg-[#FF7304] hover:text-white transition-all flex items-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Metode
        </button>
    </div>

    @if(session('success'))
        <div class="bg-green-50 text-green-600 p-4 rounded-2xl mb-6 text-sm flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-lg"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse($methods as $method)
            <div
                class="bg-white dark:bg-dark-card rounded-[24px] p-6 shadow-sm border-2 {{ $method->is_default ? 'border-orange-100' : 'border-gray-50 dark:border-dark-border' }} relative group transition-all hover:shadow-md transition-colors duration-300">
                @if($method->is_default)
                    <div class="absolute top-4 right-4">
                        <span
                            class="bg-orange-100 text-[#FF7304] text-[10px] font-bold px-2 py-1 rounded-full uppercase">Default</span>
                    </div>
                @endif
                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-12 h-12 {{ $method->type == 'bank' ? 'bg-blue-50 text-blue-600' : ($method->type == 'card' ? 'bg-purple-50 text-purple-600' : 'bg-pink-50 text-pink-600') }} rounded-xl flex items-center justify-center">
                        <i
                            class="fa-solid {{ $method->type == 'bank' ? 'fa-building-columns' : ($method->type == 'card' ? 'fa-credit-card' : 'fa-wallet') }} text-xl"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 dark:text-white">{{ $method->provider_name }}</p>
                        <p class="text-xs text-gray-500 dark:text-[#A1A1AA]">
                            {{ $method->type == 'card' ? '•••• •••• •••• ' . substr($method->number, -4) : ($method->type == 'bank' ? 'Account: •••• ' . substr($method->number, -4) : 'Wallet: ' . $method->number) }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center justify-between">
                    <form action="{{ route('payment-methods.delete', $method->id) }}" method="POST"
                        onsubmit="return confirm('Hapus metode pembayaran ini?')">
                        @csrf
                        <button type="submit" class="text-xs text-red-500 font-bold hover:underline">Hapus</button>
                    </form>

                    @if(!$method->is_default)
                        <form action="{{ route('payment-methods.set-default', $method->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="text-[10px] font-bold text-gray-400 hover:text-[#FF7304] transition-all">Set as
                                Default</button>
                        </form>
                    @else
                        <i class="fa-solid fa-circle-check text-green-500"></i>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center bg-gray-50 dark:bg-[#121212] rounded-[32px] border-2 border-dashed border-gray-200 dark:border-dark-border">
                <i class="fa-solid fa-credit-card text-4xl text-gray-300 mb-4"></i>
                <p class="text-gray-500 dark:text-[#A1A1AA] font-medium text-sm">Belum ada metode pembayaran yang disimpan.</p>
            </div>
        @endforelse
    </div>

    <!-- Add Payment Modal -->
    <div id="paymentModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="togglePaymentModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white dark:bg-dark-card rounded-[32px] shadow-2xl w-full max-w-md overflow-hidden relative transition-colors duration-300"
                onclick="event.stopPropagation()">
                <div class="bg-gradient-to-r from-[#FF7304] to-[#FFAC63] p-6 text-white">
                    <h3 class="text-lg font-bold">Tambah Metode Pembayaran</h3>
                    <p class="text-xs opacity-80">Simpan informasi pembayaran untuk checkout lebih cepat.</p>
                </div>

                <form action="{{ route('payment-methods.store') }}" method="POST" class="p-8 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Tipe
                            Pembayaran</label>
                        <select name="type" required onchange="updateFormFields(this.value)"
                            class="w-full bg-gray-50 dark:bg-[#121212] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none text-sm font-medium">
                            <option value="bank">Transfer Bank</option>
                            <option value="card">Kartu Kredit/Debit</option>
                            <option value="wallet">E-Wallet (GoPay/OVO/DANA)</option>
                        </select>
                    </div>

                    <div>
                        <label id="provider-label"
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama Bank /
                            Provider</label>
                        <input type="text" name="provider_name" placeholder="BCA, Mandiri, Visa, dll" required
                            class="w-full bg-gray-50 dark:bg-[#121212] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none text-sm font-medium">
                    </div>

                    <div>
                        <label id="number-label"
                            class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nomor
                            Rekening / Kartu</label>
                        <input type="text" name="number" placeholder="•••• •••• •••• ••••" required
                            class="w-full bg-gray-50 dark:bg-[#121212] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none text-sm font-medium tracking-widest">
                    </div>

                    <div>
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Nama
                            Pemilik</label>
                        <input type="text" name="holder_name" placeholder="Sesuai kartu/rekening" required
                            class="w-full bg-gray-50 dark:bg-[#121212] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none text-sm font-medium">
                    </div>

                    <div id="expiry-field" class="hidden">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Masa
                            Berlaku (MM/YY)</label>
                        <input type="text" name="expiry_date" placeholder="12/28"
                            class="w-full bg-gray-50 dark:bg-[#121212] border-none rounded-2xl px-5 py-3 focus:ring-2 focus:ring-[#FF7304] outline-none text-sm font-medium">
                    </div>

                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="togglePaymentModal()"
                            class="flex-1 px-6 py-3 border-2 border-gray-100 dark:border-dark-border text-gray-400 font-bold rounded-2xl hover:bg-gray-50 dark:bg-[#121212] transition-all text-sm">Batal</button>
                        <button type="submit"
                            class="flex-1 px-6 py-3 bg-[#FF7304] text-white font-bold rounded-2xl shadow-lg shadow-orange-100 hover:scale-105 transition-all text-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function togglePaymentModal() {
        const modal = document.getElementById('paymentModal');
        modal.classList.toggle('hidden');
        if (!modal.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    function updateFormFields(type) {
        const expiryField = document.getElementById('expiry-field');
        const providerLabel = document.getElementById('provider-label');
        const numberLabel = document.getElementById('number-label');

        if (type === 'card') {
            expiryField.classList.remove('hidden');
            providerLabel.innerText = 'Provider Kartu (Visa/Mastercard)';
            numberLabel.innerText = 'Nomor Kartu';
        } else if (type === 'bank') {
            expiryField.classList.add('hidden');
            providerLabel.innerText = 'Nama Bank (BCA/Mandiri)';
            numberLabel.innerText = 'Nomor Rekening';
        } else {
            expiryField.classList.add('hidden');
            providerLabel.innerText = 'Provider Wallet (GoPay/DANA)';
            numberLabel.innerText = 'Nomor HP / ID';
        }
    }
</script>