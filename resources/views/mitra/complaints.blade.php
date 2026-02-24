@extends('mitra.layout')

@section('content')
    <div class="mb-8">
        <h2 class="text-xl font-bold text-gray-900 tracking-tight">Pusat Resolusi Keluhan</h2>
        <p class="text-sm text-gray-500 mt-1">Daftar laporan pelanggan terkait layanan Anda yang memerlukan tindak lanjut</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($complaints as $c)
            <div class="premium-card flex flex-col h-full bg-white">
                <div class="p-6 flex-grow">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-2 py-0.5 border border-gray-200 rounded text-[9px] font-bold text-gray-400 uppercase tracking-wider">#CMP-{{ $c->id }}</span>
                        @php
                            $statusColors = [
                                'pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                'in_progress' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'resolved' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                            ];
                        @endphp
                        <span class="px-2 py-0.5 border {{ $statusColors[$c->status] ?? 'bg-gray-50' }} rounded text-[9px] font-bold uppercase">{{ str_replace('_', ' ', $c->status) }}</span>
                    </div>

                    <h3 class="text-sm font-bold text-gray-900 leading-tight">{{ $c->subject }}</h3>
                    <div class="mt-1.5 inline-block px-2 py-0.5 bg-gray-50 rounded text-[9px] font-semibold text-gray-400 uppercase tracking-widest">{{ $c->category ?? 'Umum' }}</div>

                    <div class="mt-6 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-[10px]">
                            {{ substr($c->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-gray-900">{{ $c->user->name }}</p>
                            <p class="text-[9px] text-gray-400">{{ $c->created_at->format('d M Y') }}</p>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-gray-50/50 border border-gray-100 rounded text-xs text-gray-600 leading-relaxed italic">
                        "{{ $c->description }}"
                    </div>

                    @if($c->mitra_response)
                        <div class="mt-4 p-4 bg-emerald-50 border border-emerald-100 rounded text-[10px] text-emerald-700">
                            <p class="font-bold uppercase mb-1">Respons Anda:</p>
                            <p class="leading-relaxed">"{{ $c->mitra_response }}"</p>
                        </div>
                    @endif
                </div>

                @if(!$c->mitra_response)
                    <div class="p-4 bg-gray-50 border-t border-gray-100">
                        <button onclick="openMitraRespondModal({{ $c->id }}, '{{ $c->subject }}')"
                            class="w-full bg-gray-900 hover:bg-black text-white py-2 rounded text-[10px] font-bold uppercase tracking-widest transition-colors">
                            Beri Tanggapan
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full py-20 text-center border border-dashed border-gray-200 rounded-md bg-gray-50/30">
                <i class="fa-solid fa-face-smile text-4xl text-gray-200 mb-4"></i>
                <p class="text-sm font-semibold text-gray-900">Pusat Layanan Bersih!</p>
                <p class="text-xs text-gray-400 mt-1">Belum ada keluhan pelanggan yang masuk saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Respond Modal -->
    <div id="mitraRespondModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-[2px]" onclick="closeMitraRespondModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-md shadow-2xl w-full max-w-sm overflow-hidden relative border border-gray-200"
                onclick="event.stopPropagation()">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-semibold text-gray-400 uppercase tracking-widest">Resolusi Masalah</p>
                        <h3 class="text-sm font-bold text-gray-900 mt-1 uppercase truncate w-64" id="modal-subject-display">Subject</h3>
                    </div>
                    <button onclick="closeMitraRespondModal()" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-xmark"></i></button>
                </div>

                <form id="respondForm" method="POST" class="p-6">
                    @csrf
                    <div class="mb-6">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Tanggapan Resmi Partner</label>
                        <textarea name="response" rows="5" placeholder="Tuliskan penjelasan atau solusi nyata untuk keluhan pelanggan ini..."
                            required
                            class="w-full bg-gray-50 border border-gray-200 rounded p-4 focus:ring-1 focus:ring-orange-500 focus:border-orange-500 outline-none text-xs font-medium resize-none transition-all"></textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="closeMitraRespondModal()"
                            class="flex-1 px-4 py-2 border border-gray-200 text-gray-400 font-bold rounded text-[10px] uppercase tracking-wider hover:bg-gray-50 transition-colors">Batal</button>
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-gray-900 text-white font-bold rounded text-[10px] uppercase tracking-wider shadow-sm hover:bg-black transition-colors">Kirim Respons</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openMitraRespondModal(id, subject) {
            const form = document.getElementById('respondForm');
            form.action = `/partner/complaints/${id}/respond`;
            document.getElementById('modal-subject-display').innerText = subject;
            document.getElementById('mitraRespondModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeMitraRespondModal() {
            document.getElementById('mitraRespondModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
@endsection
