@extends('admin.layout')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>Kelola Data {{ ucfirst($category) }}</h1>
        <a href="{{ route('admin.tickets.create', $category) }}" class="btn btn-add"><i class="fas fa-plus"></i> Tambah
            Data</a>
    </div>

    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nama / Operator</th>
                    <th>Rute / Lokasi</th>
                    <th>Waktu Keluar</th>
                    <th>Harga</th>
                    <th>Sisa Kursi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>
                            <strong>{{ $ticket->name ?? $ticket->airline_name ?? $ticket->operator ?? 'Unknown' }}</strong><br>
                            <small>{{ $ticket->code ?? $ticket->flight_code ?? '' }}</small>
                        </td>
                        <td>
                            {{ $ticket->origin ?? $ticket->origin_terminal ?? $ticket->location ?? '-' }}
                            →
                            {{ $ticket->destination ?? $ticket->destination_terminal ?? '-' }}
                        </td>
                        <td>{{ $ticket->departure_time ? \Carbon\Carbon::parse($ticket->departure_time)->format('d M, H:i') : '-' }}
                        </td>
                        <td>Rp {{ number_format($ticket->price ?? $ticket->price_per_night, 0, ',', '.') }}</td>
                        <td>{{ $ticket->seats_available ?? $ticket->availability ?? 0 }}</td>
                        <td>
                            <span
                                style="background: {{ $ticket->is_active ? '#dcfce7' : '#fee2e2' }}; color: {{ $ticket->is_active ? '#166534' : '#991b1b' }}; padding: 4px 8px; border-radius: 5px; font-size: 12px; font-weight: 600;">
                                {{ $ticket->is_active ? 'Aktif' : 'Non-aktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.tickets.edit', [$category, $ticket->id]) }}"
                                style="color: #3b82f6; margin-right: 15px;"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.tickets.delete', [$category, $ticket->id]) }}" method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 0;"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection