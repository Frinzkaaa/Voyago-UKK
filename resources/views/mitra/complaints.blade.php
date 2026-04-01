@extends('mitra.layout')

@section('content')
    <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-12">
        <div class="space-y-1">
            <h2 class="text-2xl font-black text-gray-900 dark:text-white tracking-tight uppercase italic">Pusat Resolusi Keluhan</h2>
            <p class="text-sm text-gray-500 dark:text-zinc-400 font-medium">Daftar laporan pelanggan terkait layanan Anda yang memerlukan tindak lanjut segera</p>
        </div>
        <div class="flex items-center gap-3">
             <div class="flex items-center gap-2 px-6 py-3 bg-red-50 dark:bg-red-500/10 rounded-2xl border border-red-100 dark:border-red-500/20">
                <div class="w-2 h-2 bg-red-500 rounded-full animate-pulse shadow-glow shadow-red-500/50"></div>
                <span class="text-[9px] font-black text-red-600 dark:text-red-400 uppercase tracking-widest">Priority Issues Detected</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($complaints as $c)
            <div class="bg-white dark:bg-zinc-900 rounded-[40px] border border-gray-100 dark:border-zinc-800 shadow-sm hover:shadow-xl hover:shadow-gray-200/20 dark:hover:shadow-black/50 transition-all group flex flex-col h-full overflow-hidden">
                <div class="p-10 flex-grow">
                    <div class="flex justify-between items-start mb-8">
                        <span class="px-4 py-1.5 bg-gray-50 dark:bg-zinc-800 rounded-xl text-[9px] font-black text-gray-400 dark:text-zinc-400 uppercase tracking-widest italic border border-gray-100 dark:border-zinc-700">#CMP-{{ $c->id }}</span>
                        @php
                            $statusColors = [
                                'pending' => 'bg-orange-50 dark:bg-orange-500/10 text-orange-500 border-orange-100 dark:border-orange-500/20',
                                'in_progress' => 'bg-blue-50 dark:bg-blue-500/10 text-blue-500 border-blue-100 dark:border-blue-500/20',
                                'resolved' => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-500 border-emerald-100 dark:border-emerald-500/20',
                            ];
                        @endphp
                        <span class="px-4 py-1.5 border {{ $statusColors[$c->status] ?? 'bg-gray-50' }} rounded-xl text-[9px] font-black uppercase tracking-widest italic">
                            {{ str_replace('_', ' ', $c->status) }}
                        </span>
                    </div>

                    <h3 class="text-lg font-black text-gray-900 dark:text-white leading-tight tracking-tight mb-2 italic">"{{ $c->subject }}"</h3>
                    <div class="inline-block px-3 py-1 bg-gray-900 dark:bg-zinc-800 rounded-lg text-[9px] font-black text-white uppercase tracking-widest mb-8">
                        {{ $c->category ?? 'General Support' }}
                    </div>

                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-10 h-10 rounded-2xl bg-orange-500 text-white flex items-center justify-center font-black text-xs shadow-lg shadow-orange-500/20">
                            {{ substr($c->user->name, 0, 1) }}
                        </div>
                        <div class="flex flex-col">
                            <p class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tighter">{{ $c->user->name }}</p>
                            <p class="text-[9px] text-gray-400 font-bold uppercase">{{ $c->created_at->format('d M, Y') }}</p>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 dark:bg-zinc-800/50 border border-gray-100 dark:border-zinc-800 rounded-3xl text-sm text-gray-600 dark:text-zinc-400 leading-relaxed font-medium">
                         {{ $c->description }}
                    </div>

                    @if($c->mitra_response)
                        <div class="mt-8 p-6 bg-emerald-50 dark:bg-emerald-500/5 border border-emerald-100 dark:border-emerald-500/10 rounded-3xl text-[11px] text-emerald-700 dark:text-emerald-400 relative">
                            <div class="absolute -top-3 left-6 px-3 py-1 bg-emerald-500 text-white rounded-lg font-black text-[8px] uppercase tracking-widest">Mitra Response</div>
                            <p class="font-bold leading-relaxed">"{{ $c->mitra_response }}"</p>
                        </div>
                    @endif
                </div>

                @if(!$c->mitra_response)
                    <div class="p-8 bg-zinc-50 dark:bg-zinc-900/50 border-t border-gray-50 dark:border-zinc-800">
                        <button onclick="openMitraRespondModal({{ $c->id }}, '{{ $c->subject }}')"
                            class="w-full bg-gray-900 dark:bg-zinc-800 hover:bg-orange-600 dark:hover:bg-orange-600 text-white py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all transform hover:scale-[1.02] active:scale-95 shadow-xl shadow-gray-900/10 group">
                            <i class="fa-solid fa-reply-all mr-2 group-hover:animate-bounce"></i> Beri Tanggapan Cepat
                        </button>
                    </div>
                @endif
            </div>
        @empty
            <div class="col-span-full py-40 text-center bg-white dark:bg-zinc-900 border border-dashed border-gray-200 dark:border-zinc-800 rounded-[60px]">
                <div class="w-24 h-24 bg-emerald-50 dark:bg-emerald-500/10 rounded-[40px] flex items-center justify-center mx-auto mb-8">
                    <i class="fa-solid fa-face-smile-wink text-4xl text-emerald-500"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 dark:text-white uppercase tracking-tight italic">Resolution Center Clear!</h3>
                <p class="text-xs text-gray-400 font-bold uppercase mt-2 tracking-widest">Semua pelanggan bahagia untuk saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Redesigned Respond Modal -->
    <div id="mitraRespondModal" class="fixed inset-0 z-[9999] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-md" onclick="closeMitraRespondModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-xl p-6">
            <div class="bg-white dark:bg-zinc-950 rounded-[40px] overflow-hidden shadow-2xl border border-gray-100 dark:border-zinc-800 animate-scale-in">
                <div class="p-10 border-b border-gray-50 dark:border-zinc-900 flex items-center justify-between bg-zinc-50/50 dark:bg-zinc-900/50">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em] italic mb-1 text-orange-500">Official Partner Resolution</p>
                        <h3 class="text-xl font-black text-gray-900 dark:text-white tracking-tighter uppercase truncate w-72" id="modal-subject-display">Subject</h3>
                    </div>
                    <button onclick="closeMitraRespondModal()" class="w-12 h-12 bg-white dark:bg-zinc-900 rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 transition-colors shadow-sm">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <form id="respondForm" method="POST" class="p-10">
                    @csrf
                    <div class="mb-10">
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 italic">Tanggapan & Solusi Nyata</label>
                        <textarea name="response" rows="6" placeholder="Tuliskan rincian solusi atau kompensasi yang diberikan kepada pelanggan..."
                            required
                            class="w-full bg-gray-50 dark:bg-zinc-900 border border-gray-100 dark:border-zinc-800 rounded-[30px] p-8 text-sm font-medium text-gray-700 dark:text-zinc-300 focus:outline-none focus:ring-4 focus:ring-orange-500/10 focus:border-orange-500 transition-all resize-none placeholder:text-gray-300"></textarea>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" onclick="closeMitraRespondModal()"
                            class="flex-1 px-8 py-5 border border-gray-100 dark:border-zinc-800 text-gray-400 font-black rounded-2xl text-[10px] uppercase tracking-[0.2em] hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all">Batalkan</button>
                        <button type="submit"
                            class="flex-2 px-12 py-5 bg-gray-900 text-white font-black rounded-2xl text-[10px] uppercase tracking-[0.2em] shadow-2xl shadow-gray-900/20 hover:bg-orange-600 transition-all transform active:scale-95">
                            Kirim Resolusi
                        </button>
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

    <style>
        .animate-scale-in { animation: scaleIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1) forwards; }
        @keyframes scaleIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        .shadow-glow { box-shadow: 0 0 15px -3px rgba(239, 68, 68, 0.5); }
    </style>
@endsection
