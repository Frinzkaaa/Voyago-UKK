@extends('admin.layout')

@section('content')
    <div style="margin-bottom: 30px;">
        <a href="{{ route('admin.tickets.list', $category) }}"
            style="color: var(--primary); text-decoration: none; font-weight: 600;"><i class="fas fa-arrow-left"></i>
            Kembali ke Daftar</a>
        <h1 style="margin-top: 10px;">Tambah Data {{ ucfirst($category) }}</h1>
    </div>

    <div class="card" style="max-width: 800px;">
        <form action="{{ route('admin.tickets.store', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf

            @if($category == 'kereta')
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Kereta</label>
                        <input type="text" name="name"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kode Kereta</label>
                        <input type="text" name="code"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Stasiun Asal</label>
                        <input type="text" name="origin"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Stasiun Tujuan</label>
                        <input type="text" name="destination"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Berangkat</label>
                        <input type="datetime-local" name="departure_time"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Tiba</label>
                        <input type="datetime-local" name="arrival_time"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Durasi</label>
                        <input type="text" name="duration"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;"
                            placeholder="e.g. 7j 55m" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kelas</label>
                        <input type="text" name="class"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga</label>
                        <input type="number" name="price"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ketersediaan Kursi</label>
                    <input type="number" name="seats_available"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
            @endif

            @if($category == 'pesawat')
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Maskapai</label>
                        <input type="text" name="airline_name"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kode Penerbangan</label>
                        <input type="text" name="flight_code"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Bandara Asal</label>
                        <input type="text" name="origin"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Bandara Tujuan</label>
                        <input type="text" name="destination"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Berangkat</label>
                        <input type="datetime-local" name="departure_time"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Tiba</label>
                        <input type="datetime-local" name="arrival_time"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Durasi</label>
                        <input type="text" name="duration"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Info Bagasi</label>
                        <input type="text" name="baggage_info"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga</label>
                        <input type="number" name="price"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ketersediaan Kursi</label>
                    <input type="number" name="seats_available"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
            @endif

            @if($category == 'hotel')
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Hotel</label>
                    <input type="text" name="name"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Lokasi</label>
                    <input type="text" name="location"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Rating</label>
                        <input type="number" step="0.1" name="rating"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga per Malam</label>
                        <input type="number" name="price_per_night"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kamar Tersedia</label>
                        <input type="number" name="availability"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipe Kamar</label>
                    <input type="text" name="room_type"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Upload Gambar</label>
                    <input type="file" name="image"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                </div>
            @endif

            @if($category == 'bus')
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Operator Bus</label>
                    <input type="text" name="operator"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Terminal Asal</label>
                        <input type="text" name="origin_terminal"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Terminal Tujuan</label>
                        <input type="text" name="destination_terminal"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Waktu Berangkat</label>
                        <input type="datetime-local" name="departure_time"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Tipe Kursi</label>
                        <input type="text" name="seat_type"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;"
                            placeholder="e.g. Executive, Sleeper" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga</label>
                        <input type="number" name="price"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ketersediaan Kursi</label>
                    <input type="number" name="seats_available"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
            @endif

            @if($category == 'wisata')
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Nama Destinasi</label>
                    <input type="text" name="name"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Kategori Wisata</label>
                    <input type="text" name="category"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;"
                        placeholder="e.g. Alam, Budaya" required>
                </div>
                <div class="grid" style="grid-template-columns: 1fr 1fr 1fr;">
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Jam Operasional</label>
                        <input type="text" name="open_hours"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;"
                            placeholder="e.g. 08:00 - 17:00" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Harga Tiket</label>
                        <input type="number" name="price"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: 600;">Ketersediaan</label>
                        <input type="number" name="availability"
                            style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;" required>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Deskripsi</label>
                    <textarea name="description"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px; height: 100px;"
                        required></textarea>
                </div>
                <div style="margin-bottom: 15px;">
                    <label style="display: block; margin-bottom: 5px; font-weight: 600;">Upload Gambar</label>
                    <input type="file" name="image"
                        style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 8px;">
                </div>
            @endif

            <button type="submit" class="btn btn-add" style="width: 100%; margin-top: 20px;">Simpan Data</button>
        </form>
    </div>
@endsection