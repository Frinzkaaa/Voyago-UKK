<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan {{ ucfirst($category) }} - Voyago</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 40px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            border-bottom: 2px solid #FF7304;
            padding-bottom: 20px;
        }

        .logo {
            color: #FF7304;
            font-size: 24px;
            font-weight: bold;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-top: 10px;
        }

        .period {
            font-size: 14px;
            color: #666;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #eee;
            padding: 12px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f9f9f9;
            font-weight: bold;
            text-transform: uppercase;
            color: #888;
        }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 12px;
            color: #999;
        }

        @media print {
            .no-print {
                display: none;
            }

            body {
                padding: 0;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px; text-align: right;">
        <button onclick="window.print()"
            style="background: #FF7304; color: white; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: bold;">Cetak
            Sekarang</button>
        <button onclick="window.close()"
            style="background: #eee; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; margin-left:10px;">Tutup</button>
    </div>

    <div class="header">
        <div class="logo">VOYAGO ADMIN</div>
        <div class="title">LAPORAN REKAPITULASI {{ strtoupper($category) }}</div>
        <div class="period">Periode: {{ $period }}</div>
    </div>

    <table>
        <thead>
            @if($category === 'transaksi')
                <tr>
                    <th>ID</th>
                    <th>Kode Booking</th>
                    <th>Pelanggan</th>
                    <th>Mitra</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            @elseif($category === 'mitra')
                <tr>
                    <th>ID</th>
                    <th>Nama Mitra</th>
                    <th>Tipe Layanan</th>
                    <th>Status</th>
                    <th>Bergabung</th>
                </tr>
            @elseif($category === 'komplain')
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Kategori</th>
                    <th>Subyek</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @foreach($data as $row)
                @if($category === 'transaksi')
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>#{{ $row->booking_code }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->partner->name ?? '-' }}</td>
                        <td>Rp {{ number_format($row->total_price, 0, ',', '.') }}</td>
                        <td>{{ strtoupper($row->status->value ?? $row->status) }}</td>
                        <td>{{ $row->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @elseif($category === 'mitra')
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ $row->service_type }}</td>
                        <td>{{ strtoupper($row->status->value ?? $row->status) }}</td>
                        <td>{{ $row->created_at->format('d/m/Y') }}</td>
                    </tr>
                @elseif($category === 'komplain')
                    <tr>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->user->name }}</td>
                        <td>{{ ucfirst($row->category) }}</td>
                        <td>{{ $row->subject }}</td>
                        <td>{{ strtoupper($row->status->value ?? $row->status) }}</td>
                        <td>{{ $row->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d M Y H:i:s') }} oleh Admin Voyago
    </div>
</body>

</html>