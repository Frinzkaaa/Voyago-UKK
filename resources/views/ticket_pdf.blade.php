<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Ticket - {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .ticket-container {
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #EEE;
            padding: 40px;
            border-radius: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid #FF7304;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 32px;
            font-weight: 900;
            color: #FF7304;
        }
        .order-id {
            text-align: right;
        }
        .order-id h2 {
            margin: 0;
            font-size: 24px;
            color: #555;
        }
        .order-id p {
            margin: 0;
            font-size: 12px;
            color: #AAA;
            text-transform: uppercase;
            font-weight: bold;
        }
        .section-title {
            font-size: 10px;
            font-weight: 900;
            color: #AAA;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }
        .main-info {
            display: flex;
            margin-bottom: 40px;
        }
        .info-box {
            flex: 1;
        }
        .info-box h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 900;
        }
        .info-box p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #666;
        }
        .details-grid {
            width: 100%;
            margin-bottom: 40px;
            border-collapse: collapse;
        }
        .details-grid td {
            padding: 15px 0;
            border-bottom: 1px solid #EEE;
        }
        .label {
            font-size: 11px;
            font-weight: bold;
            color: #999;
            text-transform: uppercase;
        }
        .value {
            font-size: 15px;
            font-weight: bold;
            color: #333;
        }
        .qr-section {
            text-align: center;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 2px dashed #EEE;
        }
        .qr-code {
            width: 150px;
            height: 150px;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #AAA;
        }
    </style>
</head>
<body>
    <div class="ticket-container">
        <div class="header">
            <div class="logo">VOYAGO</div>
            <div class="order-id">
                <p>Booking Code</p>
                <h2>#{{ $booking->booking_code }}</h2>
            </div>
        </div>

        <div class="main-info">
            <div class="info-box">
                <div class="section-title">Passenger Details</div>
                <h3>{{ auth()->user()->name }}</h3>
                <p>{{ auth()->user()->email }}</p>
            </div>
            <div class="info-box" style="text-align: right;">
                <div class="section-title">Purchase Date</div>
                <h3>{{ $booking->created_at->format('d M Y') }}</h3>
                <p>{{ $booking->created_at->format('H:i') }} WIB</p>
            </div>
        </div>

        <table class="details-grid">
            <tr>
                <td>
                    <div class="label">Product / Category</div>
                    <div class="value">{{ ucfirst($booking->category) }} - {{ $booking->item->name ?? $booking->item->airline_name ?? $booking->item->operator ?? 'Tiket Perjalanan' }}</div>
                </td>
                <td style="text-align: right;">
                    <div class="label">Status</div>
                    <div class="value" style="color: #22C55E;">E-Ticket Issued</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="label">Quantity</div>
                    <div class="value">{{ $booking->passenger_count }} Pax</div>
                </td>
                <td style="text-align: right;">
                    <div class="label">Seat Number</div>
                    <div class="value">{{ $booking->seats ? implode(', ', $booking->seats) : '-' }}</div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="label">Route / Location</div>
                    <div class="value">
                        {{ $booking->item->origin ? $booking->item->origin . ' → ' . $booking->item->destination : ($booking->item->location ?? 'Indonesia') }}
                    </div>
                </td>
                <td style="text-align: right;">
                    <div class="label">Total Payment</div>
                    <div class="value" style="color: #FF7304;">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</div>
                </td>
            </tr>
        </table>

        <div class="qr-section">
            <img class="qr-code" src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ $booking->booking_code }}" alt="QR Code">
            <p class="section-title" style="margin-bottom: 0;">Scan this QR for check-in</p>
            <p style="font-size: 11px; color: #AAA; margin-top: 5px;">Valid at Stations, Terminals, and Counters</p>
        </div>

        <div class="footer">
            <p>&copy; 2026 Voyago - Premium Travel Booking platform. All rights reserved.</p>
            <p>This is an electronically generated ticket and does not require a physical signature.</p>
        </div>
    </div>
</body>
</html>
