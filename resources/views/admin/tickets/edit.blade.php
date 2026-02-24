@extends('admin.layout')

@section('content')
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.tickets.list', $category) }}"
            style="color: var(--primary); text-decoration: none; font-weight: 600;"><i class="fas fa-arrow-left"></i>
            Kembali ke Daftar</a>
        <h1 style="margin-top: 10px;">Edit Data {{ ucfirst($category) }}</h1>
    </div>

    <div class="card" style="max-width: 800px;">
        <form action="{{ route('admin.tickets.update', [$category, $ticket->id]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            @if($category == 'kereta')
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Kereta</label>
                        <input type="text" name="name" value="{{ $ticket->name }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kode Kereta</label>
                        <input type="text" name="code" value="{{ $ticket->code }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Stasiun Asal</label>
                        <input type="text" name="origin" value="{{ $ticket->origin }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Stasiun Tujuan</label>
                        <input type="text" name="destination" value="{{ $ticket->destination }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Berangkat</label>
                        <input type="datetime-local" name="departure_time"
                            value="{{ \Carbon\Carbon::parse($ticket->departure_time)->format('Y-m-d\TH:i') }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Tiba</label>
                        <input type="datetime-local" name="arrival_time"
                            value="{{ \Carbon\Carbon::parse($ticket->arrival_time)->format('Y-m-d\TH:i') }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Durasi</label>
                        <input type="text" name="duration" value="{{ $ticket->duration }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;"
                            placeholder="e.g. 7j 55m" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kelas</label>
                        <input type="text" name="class" value="{{ $ticket->class }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga</label>
                        <input type="number" name="price" value="{{ (int) $ticket->price }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ketersediaan Kursi</label>
                    <input type="number" name="seats_available" value="{{ $ticket->seats_available }}"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
            @endif

            @if($category == 'pesawat')
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Maskapai</label>
                        <input type="text" name="airline_name" value="{{ $ticket->airline_name }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kode Penerbangan</label>
                        <input type="text" name="flight_code" value="{{ $ticket->flight_code }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Bandara Asal</label>
                        <input type="text" name="origin" value="{{ $ticket->origin }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Bandara Tujuan</label>
                        <input type="text" name="destination" value="{{ $ticket->destination }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Berangkat</label>
                        <input type="datetime-local" name="departure_time"
                            value="{{ \Carbon\Carbon::parse($ticket->departure_time)->format('Y-m-d\TH:i') }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Tiba</label>
                        <input type="datetime-local" name="arrival_time"
                            value="{{ \Carbon\Carbon::parse($ticket->arrival_time)->format('Y-m-d\TH:i') }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Durasi</label>
                        <input type="text" name="duration" value="{{ $ticket->duration }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Info Bagasi</label>
                        <input type="text" name="baggage_info" value="{{ $ticket->baggage_info }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga</label>
                        <input type="number" name="price" value="{{ (int) $ticket->price }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ketersediaan Kursi</label>
                    <input type="number" name="seats_available" value="{{ $ticket->seats_available }}"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
            @endif

            @if($category == 'hotel')
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Hotel</label>
                    <input type="text" name="name" value="{{ $ticket->name }}"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Lokasi</label>
                    <input type="text" name="location" value="{{ $ticket->location }}"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Rating</label>
                        <input type="number" step="0.1" name="rating" value="{{ $ticket->rating }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga per Malam</label>
                        <input type="number" name="price_per_night" value="{{ (int) $ticket->price_per_night }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kamar Tersedia</label>
                        <input type="number" name="availability" value="{{ $ticket->availability }}"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipe Kamar</label>
                    <input type="text" name="room_type" value="{{ $ticket->room_type }}"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
            @endif

            <label style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px; font-weight: 600;">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" {{ $ticket->is_active ? 'checked' : '' }}> Satus Aktif
            </label>

            <button type="submit" class="btn btn-add" style="width: 100%;">Perbarui Data</button>
        </form>
    </div>
@endsection