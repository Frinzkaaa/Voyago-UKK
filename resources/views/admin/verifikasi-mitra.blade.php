@extends('admin.layout')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-black text-gray-800 tracking-tight">Hi, Admin Voyago!</h1>
        <p class="text-gray-400 font-medium tracking-tight">Approve atau reject mitra disini</p>
    </div>

    <!-- Filters Section -->
    <div class="flex flex-wrap items-center gap-5 mb-10">
        <div class="relative w-full max-w-[240px] group">
            <select
                class="w-full bg-white border border-gray-100 rounded-2xl py-3.5 px-5 shadow-sm focus:ring-4 focus:ring-orange-50 focus:border-orange-200 outline-none text-[13px] font-bold text-gray-500 appearance-none cursor-pointer transition-all">
                <option>All Status</option>
                <option>Active</option>
                <option>Pending</option>
                <option>Inactive</option>
                <option>Error</option>
            </select>
            <i
                class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-[10px] group-hover:text-orange-400 transition-colors"></i>
        </div>

        <div class="relative w-full max-w-[240px] group">
            <i
                class="fa-solid fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-300 group-focus-within:text-orange-400 transition-colors text-xs"></i>
            <input type="text" placeholder="Cari Tugas..."
                class="w-full bg-white border border-gray-100 rounded-2xl py-3.5 pl-12 pr-6 shadow-sm focus:ring-4 focus:ring-orange-50 focus:border-orange-200 outline-none text-[13px] font-bold placeholder:text-gray-300 transition-all">
        </div>

        <div class="relative w-full max-w-[240px] group">
            <select
                class="w-full bg-white border border-gray-100 rounded-2xl py-3.5 px-5 shadow-sm focus:ring-4 focus:ring-orange-50 focus:border-orange-200 outline-none text-[13px] font-bold text-gray-500 appearance-none cursor-pointer transition-all">
                <option>All Categories</option>
                <option>Enterprise</option>
                <option>Professional</option>
                <option>Basic</option>
            </select>
            <i
                class="fa-solid fa-chevron-down absolute right-5 top-1/2 -translate-y-1/2 text-gray-300 pointer-events-none text-[10px] group-hover:text-orange-400 transition-colors"></i>
        </div>

        <button
            class="bg-white border border-gray-100 rounded-2xl px-8 py-3.5 shadow-sm text-xs font-black text-gray-400 hover:text-orange-500 hover:border-orange-100 hover:bg-orange-50 transition-all flex items-center gap-3">
            <i class="fa-solid fa-rotate text-[10px]"></i>
            RESET FILTERS
        </button>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-gray-50">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50">
                        <th class="px-8 py-6 text-center">ID</th>
                        <th class="px-6 py-6 font-black">Mitra</th>
                        <th class="px-6 py-6 font-black text-center">Jenis Layanan</th>
                        <th class="px-6 py-6 font-black">Penanggung Jawab</th>
                        <th class="px-6 py-6 font-black">Tanggal Daftar</th>
                        <th class="px-6 py-6 font-black text-center">Status</th>
                        <th class="px-6 py-6 font-black text-center">Kelengkapan Berkas</th>
                        <th class="px-8 py-6 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                <tbody class="divide-y divide-gray-50">
                    @forelse($partners as $partner)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-8 py-5 text-center text-xs font-bold text-gray-500">M{{ $partner->id }}</td>
                            <td class="px-6 py-5 text-sm font-black text-gray-800">{{ $partner->user->name }}</td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="text-xs font-bold text-orange-500">{{ $partner->service_type ?? 'Belum Ditentukan' }}</span>
                            </td>
                            <td class="px-6 py-5 text-sm font-bold text-gray-600">{{ $partner->user->email }}</td>
                            <td class="px-6 py-5 text-sm font-bold text-gray-500 tracking-tight">
                                {{ $partner->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $statusColor = match ($partner->status->value ?? $partner->status) {
                                        'verified' => 'bg-green-100 text-green-500',
                                        'pending' => 'bg-orange-100 text-orange-500',
                                        'rejected' => 'bg-red-100 text-red-500',
                                        'suspended' => 'bg-gray-100 text-gray-500',
                                        default => 'bg-gray-100 text-gray-500'
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-lg text-[10px] font-black uppercase {{ $statusColor }}">
                                    {{ $partner->status->value ?? $partner->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span
                                        class="px-2 py-1 rounded-md border border-green-200 text-green-500 text-[10px] font-black leading-none bg-green-50">KTP</span>
                                    <span
                                        class="px-2 py-1 rounded-md border border-orange-200 text-orange-400 text-[10px] font-black leading-none bg-orange-50">NIB</span>
                                </div>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    @if($partner->status->value == 'pending')
                                        <form action="{{ route('admin.partners.verify', $partner->user_id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button type="submit" title="Approve"
                                                class="w-8 h-8 rounded-lg bg-green-100 text-green-500 flex items-center justify-center hover:bg-green-200 transition-all border border-green-200">
                                                <i class="fa-solid fa-check text-xs"></i>
                                            </button>
                                        </form>
                                        <button onclick="rejectPartner({{ $partner->user_id }})" title="Reject"
                                            class="w-8 h-8 rounded-lg bg-red-100 text-red-500 flex items-center justify-center hover:bg-red-200 transition-all border border-red-200">
                                            <i class="fa-solid fa-ban text-xs"></i>
                                        </button>
                                    @else
                                        <span class="text-xs text-gray-400 font-bold italic">Processed</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-8 py-10 text-center text-gray-400 font-bold">Belum ada mitra yang
                                terdaftar.</td>
                        </tr>
                    @endforelse
                </tbody>

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
            </table>
        </div>
    </div>
@endsection