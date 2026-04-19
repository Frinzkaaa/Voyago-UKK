@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 dark:text-white tracking-tight leading-none mb-1 uppercase">Mitra Verification</h1>
        <p class="text-gray-400 dark:text-gray-500 font-medium tracking-tight italic uppercase text-[11px]">Approve atau reject mitra bisnis Voyago disini</p>
    </div>

    <!-- Filters Section -->
    <div class="flex flex-wrap items-center gap-4 mb-10 overflow-x-auto pb-2">
        <div class="relative w-full max-w-[200px] group">
            <select class="w-full bg-white dark:bg-dark-card border border-gray-100 dark:border-dark-border rounded-2xl py-3 px-5 shadow-sm text-[12px] font-bold text-gray-500 dark:text-gray-400 appearance-none cursor-pointer outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
                <option>All Status</option>
                <option>Active</option>
                <option>Pending</option>
            </select>
            <i class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 text-[10px] pointer-events-none"></i>
        </div>

        <div class="relative w-full max-w-[280px] group">
            <i class="fa-solid fa-search absolute left-5 top-1/2 -translate-y-1/2 text-orange-400 text-xs transition-colors"></i>
            <input type="text" placeholder="Cari nama mitra..."
                class="w-full bg-white dark:bg-dark-card border border-gray-100 dark:border-dark-border rounded-2xl py-3 pl-12 pr-6 shadow-sm text-[12px] font-bold dark:text-white outline-none focus:ring-4 focus:ring-orange-500/10 transition-all">
        </div>

        <button class="bg-white dark:bg-dark-card border border-gray-100 dark:border-dark-border rounded-2xl px-6 py-3 shadow-sm text-[10px] font-black text-gray-400 hover:text-orange-500 transition-all flex items-center gap-3">
            <i class="fa-solid fa-rotate"></i> RESET
        </button>
    </div>

    <!-- Modern Dark Table Section -->
    <div class="card-modern rounded-[40px] overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest border-b border-gray-50 dark:border-dark-border/50">
                        <th class="px-8 py-6 text-center">ID</th>
                        <th class="px-6 py-6">Mitra</th>
                        <th class="px-6 py-6 text-center">Jenis Layanan</th>
                        <th class="px-6 py-6">Email / Penanggung Jawab</th>
                        <th class="px-6 py-6">Tanggal Daftar</th>
                        <th class="px-6 py-6 text-center">Status</th>
                        <th class="px-6 py-6 text-center">Kelengkapan Berkas</th>
                        <th class="px-8 py-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-dark-border/30">
                    @forelse($partners as $partner)
                        <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors group">
                            <td class="px-8 py-6 text-center text-[11px] font-black text-gray-400 dark:text-gray-600">#M{{ $partner->id }}</td>
                            <td class="px-6 py-6">
                                <span class="text-sm font-black text-gray-800 dark:text-white uppercase tracking-tighter">{{ $partner->company_name ?? $partner->user->name }}</span>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <span class="text-[10px] font-black text-orange-500 uppercase tracking-widest border border-orange-200 dark:border-orange-500/30 px-3 py-1 rounded-full">{{ $partner->service_type ?? 'N/A' }}</span>
                            </td>
                            <td class="px-6 py-6 text-[11px] font-bold text-gray-500 dark:text-gray-400 italic">{{ $partner->user->email }}</td>
                            <td class="px-6 py-6 text-[11px] font-bold text-gray-500 dark:text-gray-500 tracking-tight">
                                {{ $partner->created_at->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-6 text-center">
                                @php
                                    $statusColor = match ($partner->status->value ?? $partner->status) {
                                        'verified' => 'bg-emerald-100 text-emerald-600 dark:bg-emerald-500/20 dark:text-emerald-400',
                                        'pending' => 'bg-orange-100 text-orange-500 dark:bg-orange-500/20 dark:text-orange-400',
                                        'rejected' => 'bg-red-100 text-red-500 dark:bg-red-500/20 dark:text-red-400',
                                        default => 'bg-gray-100 text-gray-500 dark:bg-gray-500/20 dark:text-gray-400'
                                    };
                                @endphp
                                <span class="px-4 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest {{ $statusColor }}">
                                    {{ $partner->status->value ?? $partner->status }}
                                </span>
                            </td>
                            <td class="px-6 py-6 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span class="px-2 py-0.5 rounded-md border border-emerald-200 dark:border-emerald-500/30 text-emerald-500 text-[9px] font-black bg-emerald-50 dark:bg-emerald-500/10">KTP</span>
                                    <span class="px-2 py-0.5 rounded-md border border-orange-200 dark:border-orange-500/30 text-orange-400 text-[9px] font-black bg-orange-50 dark:bg-orange-500/10">NIB</span>
                                </div>
                            </td>
                            <td class="px-8 py-6 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    @if($partner->status->value == 'pending')
                                        <form action="{{ route('admin.partners.verify', $partner->user_id) }}" method="POST">
                                            @csrf
                                            <button type="submit" title="Approve Mitra"
                                                class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 flex items-center justify-center hover:scale-110 hover:bg-emerald-200 transition-all">
                                                <i class="fa-solid fa-check text-xs"></i>
                                            </button>
                                        </form>
                                        <button onclick="rejectPartner({{ $partner->user_id }})" title="Reject Mitra"
                                            class="w-10 h-10 rounded-xl bg-red-100 dark:bg-red-500/20 text-red-500 dark:text-red-400 flex items-center justify-center hover:scale-110 hover:bg-red-200 transition-all">
                                            <i class="fa-solid fa-ban text-xs"></i>
                                        </button>
                                    @else
                                        <span class="text-[9px] font-black text-gray-400 dark:text-gray-600 uppercase tracking-widest italic">Processed</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-8 py-20 text-center text-xs font-black text-gray-300 dark:text-gray-700 uppercase tracking-widest italic">
                                Belum ada antrean mitra saat ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function rejectPartner(userId) {
            const reason = prompt("Masukkan alasan penolakan:");
            if (reason) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/partners/${userId}/reject`;
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                const reasonInput = document.createElement('input');
                reasonInput.type = 'hidden';
                reasonInput.name = 'reason';
                reasonInput.value = reason;
                form.appendChild(csrfInput);
                form.appendChild(reasonInput);
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection