@extends('layouts.app')

@section('content')
    <div class="max-w-[1280px] mx-auto">
        <!-- Top Section -->
        <div
            class="bg-white dark:bg-dark-card rounded-[24px] p-6 mb-8 shadow-sm border border-gray-100 dark:border-dark-border flex flex-col md:flex-row md:items-center justify-between gap-6 transition-colors duration-300">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <div class="flex items-center gap-2 group cursor-pointer" onclick="editTitle()">
                        <h1 class="text-2xl font-bold text-gray-800 dark:text-white" id="room-title">{{ $room['title'] }}</h1>
                        <i
                            class="fa-solid fa-pen-to-square text-xs text-gray-300 group-hover:text-[#FF7304] transition-all"></i>
                    </div>
                    <span
                        class="px-3 py-1 bg-orange-50 text-[#FF7304] text-[10px] font-bold rounded-full uppercase tracking-wider">{{ $room['destination'] }}</span>
                    <span id="room-status-badge"
                        class="px-3 py-1 {{ $room['status'] === 'finalized' ? 'bg-green-50 text-green-600' : 'bg-blue-50 text-blue-600' }} text-[10px] font-bold rounded-full uppercase tracking-wider">
                        {{ $room['status'] === 'finalized' ? 'Finalized' : 'Planning' }}
                    </span>
                </div>
                <p class="text-sm text-gray-500 dark:text-[#A1A1AA] flex items-center gap-2">
                    <i class="fa-regular fa-calendar"></i> {{ $room['date'] }}
                </p>
            </div>

            <div class="flex items-center gap-4">
                <div class="flex -space-x-3 overflow-hidden">
                    @foreach($room['members'] as $member)
                        <img class="inline-block h-10 w-10 rounded-full ring-2 ring-white object-cover"
                            src="/images/{{ $member['image'] }}" alt="{{ $member['name'] }}"
                            title="{{ $member['name'] }} ({{ $member['role'] }})">
                    @endforeach
                </div>

                <div class="h-10 w-px bg-gray-200 dark:bg-dark-border mx-2"></div>

                <div class="flex items-center gap-2">
                    <button onclick="inviteUser()"
                        class="bg-[#FF7304] text-white px-5 py-2.5 rounded-full font-bold text-sm shadow-lg shadow-orange-100 hover:scale-105 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-user-plus text-xs"></i> Invite
                    </button>
                    <button
                        class="w-10 h-10 border-2 border-gray-100 dark:border-dark-border rounded-full flex items-center justify-center text-gray-400 hover:text-[#FF7304] hover:border-orange-100 transition-all">
                        <i class="fa-solid fa-share-nodes"></i>
                    </button>
                </div>
            </div>
        </div>

        @php
            $totalTransport = $savedItems['transport']->sum('price');
            $totalHotel = $savedItems['hotel']->sum('price');
            $totalWisata = $savedItems['wisata']->sum('price');
            $totalEstimasi = $totalTransport + $totalHotel + $totalWisata;
            $memberCount = count($room['members']);
        @endphp

        <!-- Main Content Layout -->
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Left: Saved Trip Items -->
            <div class="lg:w-[65%] shrink-0">
                <!-- Tabs -->
                <div class="flex items-center gap-8 border-b border-gray-200 dark:border-dark-border mb-6 overflow-x-auto">
                    <button onclick="switchCategory('transport')"
                        class="cat-tab active-tab pb-3 font-semibold text-gray-400 hover:text-[#FF7304] transition-all relative whitespace-nowrap">Transport</button>
                    <button onclick="switchCategory('hotel')"
                        class="cat-tab pb-3 font-semibold text-gray-400 hover:text-[#FF7304] transition-all relative whitespace-nowrap">Hotel</button>
                    <button onclick="switchCategory('wisata')"
                        class="cat-tab pb-3 font-semibold text-gray-400 hover:text-[#FF7304] transition-all relative whitespace-nowrap">Wisata</button>
                </div>

                <!-- Items Lists -->
                <div id="items-container" class="space-y-4">
                    @foreach(['transport', 'hotel', 'wisata'] as $cat)
                        <div id="cat-{{ $cat }}" class="category-section {{ $loop->first ? '' : 'hidden' }} space-y-4">
                            @forelse($savedItems[$cat] as $item)
                                <div
                                    class="bg-white dark:bg-dark-card rounded-[24px] p-5 shadow-sm border border-gray-50 dark:border-dark-border flex flex-col md:flex-row items-center gap-5 hover:-translate-y-1 hover:shadow-md transition-all duration-300 transition-colors duration-300">
                                    <!-- Thumbnail -->
                                    <div class="w-full md:w-32 h-24 rounded-[18px] overflow-hidden shrink-0">
                                        <img src="/images/{{ $item->image ?? 'pd-1.jpeg' }}" class="w-full h-full object-cover">
                                    </div>

                                    <!-- Content -->
                                    <div class="flex-grow">
                                        <h3 class="font-bold text-gray-800 dark:text-white text-lg mb-1">{{ $item->title }}</h3>
                                        @if($item->subtitle)
                                            <p class="text-xs text-gray-400 mb-2 flex items-center gap-1">
                                                <i class="fa-solid fa-location-dot"></i> {{ $item->subtitle }}
                                            </p>
                                        @endif
                                        <p
                                            class="text-[11px] font-bold text-gray-500 dark:text-[#A1A1AA] uppercase tracking-tight flex items-center gap-2">
                                            <i class="fa-regular fa-calendar"></i> {{ $item->date_info }}
                                        </p>

                                        <!-- Voting Below Title -->
                                        @php
                                            $myVote = $item->votes->where('user_id', auth()->id())->first();
                                        @endphp
                                        <div class="flex items-center gap-4 mt-3">
                                            <button onclick="voteItem({{ $item->id }}, 'up')"
                                                class="flex items-center gap-1.5 group">
                                                <i
                                                    class="fa-solid fa-thumbs-up text-sm {{ ($myVote && $myVote->type == 'up') ? 'text-[#FF7304]' : 'text-gray-300' }} group-hover:text-[#FF7304] transition-all"></i>
                                                <span class="text-xs font-bold text-gray-500 dark:text-[#A1A1AA]">{{ $item->votes_up }} votes</span>
                                            </button>
                                            <button onclick="voteItem({{ $item->id }}, 'down')"
                                                class="flex items-center gap-1.5 group">
                                                <i
                                                    class="fa-solid fa-thumbs-down text-sm {{ ($myVote && $myVote->type == 'down') ? 'text-[#FF7304]' : 'text-gray-300' }} group-hover:text-[#FF7304] transition-all"></i>
                                                <span class="text-xs font-bold text-gray-500 dark:text-[#A1A1AA]">{{ $item->votes_down }} votes</span>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Stats -->
                                    <div
                                        class="text-center md:text-right px-4 border-x border-gray-50 dark:border-dark-border flex flex-row md:flex-col justify-around md:justify-center gap-4 w-full md:w-auto">
                                        <div>
                                            <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Price</p>
                                            <p class="font-bold text-[#FF7304]">Rp {{ number_format($item->price, 0, ',', '.') }}
                                            </p>
                                        </div>
                                        @if($item->optional_stats)
                                            <div>
                                                <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Info</p>
                                                <p class="font-bold text-gray-700 dark:text-gray-300">{{ $item->optional_stats }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex md:flex-col gap-3 shrink-0">
                                        <button
                                            class="w-10 h-10 bg-gray-50 dark:bg-[#121212] rounded-full flex items-center justify-center text-gray-400 hover:text-[#FF7304] hover:bg-orange-50 dark:hover:bg-[#2A2A2A] transition-all">
                                            <i class="fa-regular fa-comment-dots"></i>
                                        </button>
                                        <button onclick="deleteItem({{ $item->id }})"
                                            class="w-10 h-10 bg-gray-50 dark:bg-[#121212] rounded-full flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-20 bg-white dark:bg-dark-card rounded-[24px] shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                                    <div class="w-24 h-24 mx-auto mb-6 bg-orange-50 rounded-full flex items-center justify-center">
                                        <i class="fa-solid fa-folder-open text-4xl text-orange-200"></i>
                                    </div>
                                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Belum ada rencana yang ditambahkan</h3>
                                    <p class="text-gray-400 text-sm mb-6 px-10">Yuk tambahkan tiket atau destinasi ke room ini!</p>
                                    <a href="/pemesanan"
                                        class="inline-block bg-[#FF7304] text-white px-6 py-2.5 rounded-full font-bold text-sm shadow-lg shadow-orange-100">Cari
                                        Tiket Sekarang</a>
                                </div>
                            @endforelse
                        </div>
                    @endforeach
                </div>

                <!-- Comment Section (Light Preview) -->
                <div class="mt-8 bg-gray-50 dark:bg-[#121212] rounded-[24px] p-6 border border-gray-100 dark:border-dark-border">
                    <h3 class="font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fa-regular fa-comment-dots text-[#FF7304]"></i> Diskusi Room
                    </h3>
                    <div class="space-y-4 mb-6" id="comments-list">
                        @foreach($comments as $comment)
                            <div class="flex gap-3">
                                <img src="/images/avatar2.jpeg" class="w-8 h-8 rounded-full object-cover">
                                <div class="bg-white dark:bg-dark-card p-3 rounded-2xl rounded-tl-none shadow-sm flex-grow transition-colors duration-300">
                                    <p class="text-xs font-bold text-gray-800 dark:text-white mb-1">{{ $comment->user->name }} <span
                                            class="text-[10px] text-gray-400 font-normal ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-[#A1A1AA]">{{ $comment->comment }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Simple Input -->
                    <div class="relative">
                        <input type="text" id="comment-input" placeholder="Tulis komentar..."
                            class="w-full bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-2xl px-5 py-3 pr-12 text-sm focus:border-orange-100 outline-none transition-al transition-colors duration-300l">
                        <button onclick="postComment()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-[#FF7304] font-bold text-sm p-2 hover:scale-110 transition-all">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Right: Trip Summary Panel -->
            <div class="lg:w-[35%] shrink-0">
                <div class="sticky top-28 space-y-6">
                    <!-- Budget Card -->
                    <div class="bg-white dark:bg-dark-card rounded-[24px] p-6 shadow-sm border border-gray-100 dark:border-dark-border overflow-hidden relative transition-colors duration-300">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-full -mr-16 -mt-16 opacity-50">
                        </div>

                        <h3 class="font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2 relative">
                            <i class="fa-solid fa-chart-pie text-[#FF7304]"></i> Estimasi Biaya
                        </h3>

                        <div class="space-y-4 mb-8 relative">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 dark:text-[#A1A1AA]">Transportasi</span>
                                <span class="font-bold text-gray-800 dark:text-white">Rp
                                    {{ number_format($totalTransport, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 dark:text-[#A1A1AA]">Akomodasi (Hotel)</span>
                                <span class="font-bold text-gray-800 dark:text-white">Rp
                                    {{ number_format($totalHotel, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500 dark:text-[#A1A1AA]">Aktivitas & Wisata</span>
                                <span class="font-bold text-gray-800 dark:text-white">Rp
                                    {{ number_format($totalWisata, 0, ',', '.') }}</span>
                            </div>
                            <div class="h-px bg-dashed border-t border-dashed border-gray-200 dark:border-dark-border"></div>
                            <div class="flex justify-between items-center">
                                <span class="font-bold text-gray-800 dark:text-white">Total Estimasi</span>
                                <span class="text-xl font-bold text-[#FF7304]">Rp
                                    {{ number_format($totalEstimasi, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-[#121212] rounded-2xl p-4 flex justify-between items-center">
                            <div>
                                <p class="text-[10px] font-bold text-gray-400 uppercase">Per Orang ({{ $memberCount }}
                                    Member)</p>
                                <p class="font-bold text-gray-800 dark:text-white">Rp
                                    {{ number_format($memberCount > 0 ? $totalEstimasi / $memberCount : 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <i class="fa-solid fa-users text-gray-200 text-2xl"></i>
                        </div>
                    </div>

                    <!-- Trip Info Card -->
                    <div class="bg-white dark:bg-dark-card rounded-[24px] p-6 shadow-sm border border-gray-100 dark:border-dark-border transition-colors duration-300">
                        <h3 class="font-bold text-gray-800 dark:text-white mb-4">Informasi Rencana</h3>
                        <div class="space-y-4">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-50 dark:bg-[#121212] flex items-center justify-center shrink-0">
                                    <i class="fa-solid fa-location-dot text-[#FF7304] text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Tujuan</p>
                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $room['destination'] }}</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-gray-50 dark:bg-[#121212] flex items-center justify-center shrink-0">
                                    <i class="fa-regular fa-calendar text-[#FF7304] text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-gray-400 uppercase">Waktu</p>
                                    <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $room['date'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 space-y-3">
                            @if($room['status'] === 'planning' && $room['my_role'] === 'Creator')
                                <button onclick="finalizePlan()"
                                    class="w-full bg-[#FF7304] text-white py-4 rounded-[20px] font-bold shadow-lg shadow-orange-100 hover:scale-105 transition-all">Finalize
                                    Plan</button>
                            @elseif($room['status'] === 'finalized')
                                <button disabled
                                    class="w-full bg-green-500 text-white py-4 rounded-[20px] font-bold cursor-not-allowed flex items-center justify-center gap-2">
                                    <i class="fa-solid fa-circle-check"></i> Plan Finalized
                                </button>
                            @endif
                            <button
                                class="w-full border-2 border-orange-100 text-[#FF7304] py-3.5 rounded-[20px] font-bold hover:bg-orange-50 dark:hover:bg-[#2A2A2A] transition-all flex items-center justify-center gap-2">
                                <i class="fa-solid fa-share-nodes"></i> Share Room
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Hidden styles for neatness omitted as in existing */
        .active-tab {
            color: #FF7304 !important;
        }

        .active-tab::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: #FF7304;
            border-radius: 10px;
        }

        .hidden {
            display: none !important;
        }
    </style>

    <script>
        const roomId = @json($room['id']);

        function switchCategory(catId) {
            document.querySelectorAll('.cat-tab').forEach(tab => tab.classList.remove('active-tab'));
            event.target.classList.add('active-tab');
            document.querySelectorAll('.category-section').forEach(section => section.classList.add('hidden'));
            document.getElementById('cat-' + catId).classList.remove('hidden');
        }

        async function voteItem(itemId, type) {
            try {
                await fetch(`/planning/vote/${itemId}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ type })
                });
                location.reload();
            } catch (e) { console.error(e); }
        }

        async function postComment() {
            const input = document.getElementById('comment-input');
            const comment = input.value;
            if (!comment) return;

            try {
                await fetch(`/planning/comment/${roomId}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ comment })
                });
                location.reload();
            } catch (e) { console.error(e); }
        }

        async function inviteUser() {
            const email = prompt("Masukkan email teman yang ingin diundang:");
            if (!email) return;

            try {
                const response = await fetch(`/planning/invite/${roomId}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ email })
                });
                const data = await response.json();
                if (data.success) {
                    alert(`${data.name} berhasil ditambahkan ke room!`);
                    location.reload();
                } else {
                    alert(data.error);
                }
            } catch (e) { console.error(e); }
        }

        async function deleteItem(itemId) {
            if (!confirm("Hapus item ini dari rencana?")) return;

            try {
                const response = await fetch(`/planning/item/delete/${itemId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    location.reload();
                } else {
                    alert('Gagal menghapus: ' + (data.error || 'Terjadi kesalahan'));
                }
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan koneksi saat menghapus item.');
            }
        }

        async function editTitle() {
            const newTitle = prompt("Masukkan nama rencana baru:", "{{ $room['title'] }}");
            if (!newTitle || newTitle === "{{ $room['title'] }}") return;

            try {
                const response = await fetch(`/planning/update-title/${roomId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ title: newTitle })
                });
                const data = await response.json();
                if (data.success) {
                    location.reload();
                }
            } catch (e) { console.error(e); }
        }

        async function finalizePlan() {
            if (!confirm("Apakah Anda yakin ingin melakukan Finalize Plan? Setelah di-finalize, rencana ini akan ditandai sebagai selesai.")) return;

            try {
                const response = await fetch(`/planning/finalize/${roomId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (data.success) {
                    alert("Rencana berhasil di-finalize!");
                    location.reload();
                }
            } catch (e) { console.error(e); }
        }
    </script>
@endsection