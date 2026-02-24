@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Hi, Admin Voyago!</h1>
        <p class="text-gray-400 font-medium tracking-tight">Cek reputasi mitra dan voyago disini</p>
    </div>

    <!-- Tabs Filter -->
    <div class="flex flex-wrap gap-4 mb-10">
        <button
            class="px-8 py-3 rounded-full bg-[#FF7304] text-white text-[11px] font-black uppercase tracking-widest shadow-lg shadow-orange-100/50 transition-all">Semua</button>
        <button
            class="px-8 py-3 rounded-full bg-white border border-gray-100 text-gray-400 text-[11px] font-black uppercase tracking-widest hover:text-orange-500 hover:bg-orange-50 hover:border-orange-100 transition-all">Pembayaran</button>
        <button
            class="px-8 py-3 rounded-full bg-white border border-gray-100 text-gray-400 text-[11px] font-black uppercase tracking-widest hover:text-orange-500 hover:bg-orange-50 hover:border-orange-100 transition-all">Layanan</button>
        <button
            class="px-8 py-3 rounded-full bg-white border border-gray-100 text-gray-400 text-[11px] font-black uppercase tracking-widest hover:text-orange-500 hover:bg-orange-50 hover:border-orange-100 transition-all">Pembatalan</button>
        <button
            class="px-8 py-3 rounded-full bg-white border border-gray-100 text-gray-400 text-[11px] font-black uppercase tracking-widest hover:text-orange-500 hover:bg-orange-50 hover:border-orange-100 transition-all">Keterlambatan</button>
    </div>

    <!-- Complaint Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($complaints as $c)
            <div
                class="bg-white rounded-[32px] p-8 shadow-sm border border-gray-50 flex flex-col h-full transform hover:scale-[1.02] transition-all">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="text-xl font-black text-gray-800 tracking-tight leading-tight">{{ $c->subject }}</h3>
                        <p class="text-xs font-bold text-gray-300 mt-1 uppercase tracking-widest">#CMP-{{ $c->id }}</p>
                    </div>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-600',
                            'in_progress' => 'bg-blue-100 text-blue-600',
                            'resolved' => 'bg-green-100 text-green-600',
                        ];
                    @endphp
                    <span
                        class="px-4 py-1 rounded-full text-[10px] font-black {{ $statusColors[$c->status] ?? 'bg-gray-100' }} uppercase tracking-wider">{{ str_replace('_', ' ', $c->status) }}</span>
                </div>

                <div class="mt-4 flex flex-wrap gap-2">
                    <span
                        class="bg-orange-50 text-[#FF7304] px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">{{ $c->category ?? 'Lainnya' }}</span>
                    @if($c->is_forwarded)
                        <span
                            class="bg-purple-50 text-purple-600 px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">Diteruskan</span>
                    @endif
                </div>

                <div class="mt-8 space-y-4 flex-grow">
                    <div class="flex items-center gap-4 text-gray-500">
                        <i class="fa-solid fa-calendar-days text-sm opacity-60"></i>
                        <span class="text-xs font-bold">{{ $c->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex items-center gap-4 text-gray-700">
                        <i class="fa-solid fa-handshake text-sm opacity-60"></i>
                        <span class="text-xs font-black">{{ $c->partner->name ?? 'Admin Voyago' }}</span>
                    </div>
                    <div class="flex items-center gap-4 text-gray-600">
                        <i class="fa-solid fa-user text-sm opacity-60"></i>
                        <span class="text-xs font-bold">{{ $c->user->name }}</span>
                    </div>
                    <div class="mt-4 p-4 bg-gray-50 rounded-2xl text-xs text-gray-600 italic">
                        "{{ Str::limit($c->description, 100) }}"
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-2">
                    @if(!$c->is_forwarded && $c->status === 'pending')
                        <form action="{{ route('admin.complaints.forward', $c->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full bg-purple-500 text-white py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-purple-100 hover:scale-105 transition-all">
                                Teruskan ke Mitra
                            </button>
                        </form>
                    @endif

                    @if($c->status !== 'resolved')
                        <button onclick="openRespondModal({{ $c->id }}, '{{ $c->subject }}')"
                            class="w-full bg-[#FF7304] text-white py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-lg shadow-orange-100 hover:scale-105 transition-all">
                            Tanggapi Komplain
                        </button>
                    @else
                        <div
                            class="p-3 bg-green-50 rounded-2xl border border-green-100 text-[10px] font-bold text-green-600 flex items-center justify-center gap-2">
                            <i class="fa-solid fa-circle-check"></i> Sudah Ditanggapi
                        </div>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center">
                <i class="fa-solid fa-clipboard-check text-6xl text-gray-100 mb-6"></i>
                <p class="text-gray-400 font-bold">Belum ada komplain yang masuk.</p>
            </div>
        @endforelse
    </div>

    <!-- Respond Modal -->
    <div id="respondModal" class="fixed inset-0 z-[100] hidden overflow-y-auto">
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeRespondModal()"></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="bg-white rounded-[32px] shadow-2xl w-full max-w-lg overflow-hidden relative"
                onclick="event.stopPropagation()">
                <div class="bg-gradient-to-r from-[#FF7304] to-[#FFAC63] p-6 text-white text-center">
                    <h3 class="text-xl font-black uppercase tracking-widest">Tanggapi Komplain</h3>
                    <p class="text-[10px] font-bold opacity-80 mt-1 uppercase" id="modal-subject-display"></p>
                </div>

                <form id="respondForm" method="POST" class="p-8 space-y-6">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-3">Tanggapan
                            Resmi Admin</label>
                        <textarea name="response" rows="6" placeholder="Berikan penjelasan atau solusi..." required
                            class="w-full bg-gray-50 border-none rounded-2xl px-6 py-4 focus:ring-2 focus:ring-[#FF7304] outline-none text-sm font-medium resize-none"></textarea>
                    </div>

                    <div class="flex gap-4">
                        <button type="button" onclick="closeRespondModal()"
                            class="flex-1 px-8 py-4 border border-gray-100 text-gray-400 font-black rounded-[20px] text-[10px] uppercase tracking-widest hover:bg-gray-50 transition-all">Batal</button>
                        <button type="submit"
                            class="flex-1 px-8 py-4 bg-[#FF7304] text-white font-black rounded-[20px] text-[10px] uppercase tracking-widest shadow-lg shadow-orange-100 hover:scale-105 transition-all">Kirim
                            Tanggapan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRespondModal(id, subject) {
            const form = document.getElementById('respondForm');
            form.action = `/admin/complaints/${id}/respond`;
            document.getElementById('modal-subject-display').innerText = subject;
            document.getElementById('respondModal').classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeRespondModal() {
            document.getElementById('respondModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    </script>
    </div>
@endsection