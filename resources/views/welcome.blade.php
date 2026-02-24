<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Voyago - Premium Travel Booking</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>
        <div class="container header-inner">
            <a href="/" class="logo">
                <i class="fas fa-paper-plane"></i> Voyago
            </a>
            <nav class="nav">
                <a href="#" class="nav-link active">Beranda</a>
                <a href="/pemesanan" class="nav-link">Pemesanan</a>
                <a href="#" class="nav-link">Voucher</a>
                <a href="#" class="nav-link">Chat</a>
                <a href="#" class="nav-link">Pengaturan</a>
            </nav>
            <div class="header-right">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Mau rencana liburan kemana nih?">
                </div>

                @auth
                    <i class="far fa-bell" style="font-size: 20px; color: #888; cursor: pointer;"></i>
                    <a href="{{ route('profile') }}">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=FF7304&color=fff"
                            style="width: 40px; border-radius: 50%; border: 2px solid white; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn-login"
                        style="background: #FF7304; color: white; padding: 10px 25px; border-radius: 12px; font-weight: 700; font-size: 14px; transition: all 0.3s hover:scale-105">Masuk</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="container">
        <!-- Rewards Card -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: 20px;">
            <div
                style="background: white; padding: 15px 25px; border-radius: 20px; box-shadow: var(--shadow); display: flex; align-items: center; gap: 20px; width: 400px;">
                <div style="flex: 1;">
                    <p style="font-size: 12px; font-weight: 600; color: #555;">Voyago Point kamu:</p>
                    <p style="font-size: 20px; font-weight: 700;">765 <span
                            style="font-size: 12px; color: #aaa;">/1000</span></p>
                    <div style="height: 6px; background: #eee; border-radius: 3px; margin-top: 5px;">
                        <div style="width: 76.5%; height: 100%; background: var(--primary); border-radius: 3px;"></div>
                    </div>
                </div>
                <div
                    style="background: #FFF1E6; padding: 10px; border-radius: 50%; color: var(--primary); font-size: 24px;">
                    <i class="fas fa-trophy"></i>
                </div>
            </div>
        </div>

        <!-- Category Selector -->
        <div class="category-selector">
            @foreach($categories as $category)
                <div class="category-card {{ $category->slug == 'kereta' ? 'active' : '' }}"
                    onclick="selectCategory('{{ $category->slug }}', this)">
                    <i class="fas fa-{{ $category->icon }}"></i>
                    <span>{{ $category->name }}</span>
                </div>
            @endforeach
        </div>

        <div class="main-content">
            <!-- Sidebar / Form -->
            <div class="booking-form-container">
                <div class="booking-form" id="bookingForm">
                    <div class="form-group">
                        <label>Asal</label>
                        <div class="input-container">
                            <i class="fas fa-train" id="formIcon"></i>
                            <input type="text" id="origin" placeholder="Cari stasiun asal..." value="Pasar Senen (PSE)">
                        </div>
                    </div>

                    <div style="text-align: center; margin: -10px 0 10px 0;">
                        <i class="fas fa-exchange-alt"
                            style="transform: rotate(90deg); color: var(--primary); background: #FFF1E6; padding: 8px; border-radius: 50%; cursor: pointer;"></i>
                    </div>

                    <div class="form-group">
                        <label>Tujuan</label>
                        <div class="input-container">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" id="destination" placeholder="Cari stasiun tujuan..."
                                value="Lempuyangan (LPN)">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Penumpang</label>
                        <div class="input-container">
                            <i class="fas fa-users"></i>
                            <input type="text" id="passengers" value="1 Dewasa, 0 Anak, 0 Bayi">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Kelas</label>
                        <div class="input-container">
                            <i class="fas fa-chair"></i>
                            <select id="class">
                                <option>Economy</option>
                                <option>Business</option>
                                <option>Executive</option>
                            </select>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div class="form-group">
                            <label>Tanggal Pergi</label>
                            <div class="input-container">
                                <i class="far fa-calendar"></i>
                                <input type="text" value="1 Januari 2026">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tanggal Pulang</label>
                            <div class="input-container">
                                <i class="far fa-calendar"></i>
                                <input type="text" value="5 Januari 2026">
                            </div>
                        </div>
                    </div>

                    <button class="btn-primary" onclick="performSearch()">Cari Tiket</button>

                    <div style="margin-top: 30px;">
                        <div class="seat-selection" id="seatSelection">
                            <!-- Populated for Train/Flight -->
                            @for($i = 1; $i <= 24; $i++)
                                <div class="seat" onclick="this.classList.toggle('selected')">
                                    A{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</div>
                            @endfor
                        </div>
                        <div style="margin-top: 15px; display: flex; align-items: center; gap: 10px; font-size: 13px;">
                            <input type="checkbox" id="pp"> <label for="pp">Pulang Pergi</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Results Section -->
            <div class="results-container">
                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div style="background: var(--primary-soft); padding: 15px; border-radius: 15px; flex: 1;">
                        <p style="font-size: 12px; color: var(--primary); font-weight: 600;">Harga Terendah</p>
                        <p style="font-weight: 700;">Rp 350.000 <span
                                style="font-weight: 400; font-size: 12px; color: #888;">/ 5j 40m</span></p>
                    </div>
                    <div style="background: white; padding: 15px; border-radius: 15px; flex: 1;">
                        <p style="font-size: 12px; color: #888; font-weight: 600;">Durasi Tersingkat</p>
                        <p style="font-weight: 700;">1j 34m</p>
                    </div>
                    <div
                        style="background: white; padding: 15px; border-radius: 15px; display: flex; align-items: center; gap: 10px;">
                        <i class="fas fa-sliders-h" style="color: var(--primary);"></i>
                        <span style="font-weight: 600;">Filter</span>
                    </div>
                </div>

                <div class="ticket-list" id="ticketList">
                    @forelse($tickets as $ticket)
                        <div class="ticket-card">
                            <div class="ticket-info">
                                <div class="ticket-header">
                                    <span class="ticket-name">{{ $ticket->name }} ({{ $ticket->code }})</span>
                                    <span
                                        style="background: #f0f0f0; padding: 2px 8px; border-radius: 5px; font-size: 11px;">{{ $ticket->class }}</span>
                                </div>
                                <div class="ticket-details">
                                    <div class="time-slot">
                                        <div class="time">
                                            {{ \Carbon\Carbon::parse($ticket->departure_time)->format('H:i') }}
                                        </div>
                                        <div class="station">{{ $ticket->origin }}</div>
                                    </div>
                                    <div class="duration-arrow">
                                        <span>{{ $ticket->duration }}</span>
                                        <div class="arrow-line"></div>
                                        <span>Langsung</span>
                                    </div>
                                    <div class="time-slot">
                                        <div class="time">{{ \Carbon\Carbon::parse($ticket->arrival_time)->format('H:i') }}
                                        </div>
                                        <div class="station">{{ $ticket->destination }}</div>
                                    </div>
                                </div>
                                <div
                                    style="margin-top: 15px; font-size: 12px; color: var(--primary); font-weight: 600; display: flex; gap: 20px;">
                                    <span>Detail Perjalanan</span>
                                    <span>Info</span>
                                </div>
                            </div>
                            <div class="ticket-price-section">
                                <div class="price">Rp {{ number_format($ticket->price, 0, ',', '.') }} <span
                                        style="font-size: 12px; color: #888; font-weight: 400;">/ pax</span></div>
                                <button class="btn-select"
                                    onclick="selectTicket({{ $ticket->id }}, {{ $ticket->price }})">Pilih</button>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 50px; color: #888;">Tidak ada tiket tersedia.</div>
                    @endforelse
                </div>
            </div>

            <!-- Payment Logic -->
            <div class="payment-container">
                <div class="payment-card">
                    <h3 style="margin-bottom: 20px; font-size: 18px;">Rincian Pembayaran</h3>

                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-size: 12px; font-weight: 600; margin-bottom: 8px;">Voucher
                            Promo</label>
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="voucher-code" placeholder="Kode Promo"
                                style="flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 8px; font-family: inherit;">
                            <button onclick="applyVoucher()"
                                style="background: black; color: white; border: none; padding: 0 15px; border-radius: 8px; font-weight: 600; cursor: pointer;">Apply</button>
                        </div>
                        <p id="voucher-msg" style="font-size: 11px; margin-top: 5px; display: none;"></p>
                    </div>

                    <div class="payment-summary" id="paymentSummary">
                        <div class="summary-item">
                            <span>Harga tiket (1 pax):</span>
                            <span id="summary-base">Rp 350.000</span>
                        </div>
                        <div class="summary-item">
                            <span>Biaya layanan:</span>
                            <span>Rp 10.000</span>
                        </div>
                        <div class="summary-item">
                            <span>Diskon voucher:</span>
                            <span style="color: #22c55e;">- Rp 0</span>
                        </div>
                        <div class="summary-item summary-total">
                            <span>Total Payment:</span>
                            <span id="summary-total" style="color: var(--primary);">Rp 360.000</span>
                        </div>
                    </div>

                    <h4 style="margin-bottom: 15px; font-size: 14px;">Pilih Metode Pembayaran</h4>
                    <div style="display: flex; flex-direction: column; gap: 10px; margin-bottom: 20px;">
                        <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                            <input type="radio" name="payment" value="qris" checked> QRIS
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                            <input type="radio" name="payment" value="bank"> Bank
                        </label>
                        <label style="display: flex; align-items: center; gap: 10px; font-size: 14px; cursor: pointer;">
                            <input type="radio" name="payment" value="ewallet"> E-Wallet
                        </label>
                    </div>

                    <button class="btn-primary" style="background: #e66700;" onclick="handleCheckout()">Bayar</button>
                </div>
            </div>
        </div>
        <!-- Join Mitra Section -->
        <div
            style="margin: 80px 0; background: linear-gradient(135deg, #FF7304 0%, #FFAC63 100%); border-radius: 40px; padding: 60px; color: white; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: space-between;">
            <div style="max-width: 50%; position: relative; z-index: 2;">
                <h2 style="font-size: 36px; font-weight: 800; margin-bottom: 20px; line-height: 1.2;">Punya Bisnis
                    Properti atau Transportasi?</h2>
                <p style="font-size: 18px; margin-bottom: 30px; opacity: 0.9;">Dapatkan keuntungan lebih dengan
                    bergabung sebagai Mitra Voyago. Kelola bisnismu lebih cerdas dan jangkau jutaan penjelajah.</p>
                <div style="display: flex; gap: 20px;">
                    <a href="{{ route('partner.auth.page') }}"
                        style="background: white; color: #FF7304; padding: 15px 35px; border-radius: 15px; font-weight: 800; text-decoration: none; transition: all 0.3s; box-shadow: 0 10px 20px rgba(0,0,0,0.1);"
                        onmouseover="this.style.transform='translateY(-5px)'"
                        onmouseout="this.style.transform='translateY(0)'">Gabung Jadi Mitra</a>
                    <a href="#"
                        style="background: rgba(255,255,255,0.2); color: white; padding: 15px 35px; border-radius: 15px; font-weight: 800; text-decoration: none; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.3);">Pelajari
                        Lebih Lanjut</a>
                </div>
            </div>
            <div
                style="position: absolute; right: -50px; bottom: -50px; opacity: 0.1; font-size: 300px; transform: rotate(-15deg);">
                <i class="fas fa-handshake"></i>
            </div>
            <div
                style="background: rgba(255,255,255,0.1); width: 200px; height: 200px; border-radius: 50%; position: absolute; top: -100px; right: 10%; z-index: 1;">
            </div>
        </div>
    </main>

    <footer>
        <div class="container footer-grid">
            <div class="footer-info">
                <div class="footer-logo"><i class="fas fa-paper-plane"></i> Voyago</div>
                <p style="margin-bottom: 20px; color: rgba(255,255,255,0.8);">Platform pemesanan tiket & travel
                    terpercaya untuk pesawat, kereta, hotel, dan destinasi wisata. Pesan cepat, aman, dan praktis dalam
                    satu aplikasi.</p>
                <div style="display: flex; gap: 15px; font-size: 20px;">
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-tiktok"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#">Cari Tiket</a></li>
                    <li><a href="#">Pesanan</a></li>
                    <li><a href="#">Voucher</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Bantuan & Layanan</h4>
                <ul>
                    <li><a href="#">Pusat Bantuan (FAQ)</a></li>
                    <li><a href="#">Cara Pemesanan</a></li>
                    <li><a href="#">Pembayaran</a></li>
                    <li><a href="#">Hubungi CS</a></li>
                </ul>
            </div>
            <div class="footer-info">
                <h4>Stay Connected</h4>
                <p style="margin-bottom: 15px; font-size: 14px;">Dapatkan info promo & update terbaru dari Voyago.</p>
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <input type="text" placeholder="Masukkan Email"
                        style="flex: 1; padding: 10px; border-radius: 8px; border: none;">
                    <button
                        style="background: black; color: white; border: none; padding: 10px 15px; border-radius: 8px;"><i
                            class="fas fa-paper-plane"></i></button>
                </div>
                <p style="font-size: 13px;"><i class="far fa-envelope"></i> support@voyago.com</p>
                <p style="font-size: 13px;"><i class="fas fa-phone-alt"></i> +62 812-0000-0000</p>
            </div>
        </div>
    </footer>

    <script>
        let currentCategory = 'kereta';
        let selectedTicketId = null;
        let selectedTicketPrice = 350000;

        async function selectCategory(category, element) {
            currentCategory = category;

            // UI Update
            document.querySelectorAll('.category-card').forEach(card => card.classList.remove('active'));
            element.classList.add('active');

            // Adapt Form
            const formIcon = document.getElementById('formIcon');
            const originInput = document.getElementById('origin');
            const destInput = document.getElementById('destination');
            const seatSection = document.getElementById('seatSelection');

            if (category === 'kereta') {
                formIcon.className = 'fas fa-train';
                originInput.placeholder = 'Cari stasiun asal...';
                destInput.placeholder = 'Cari stasiun tujuan...';
                seatSection.style.display = 'grid';
            } else if (category === 'pesawat') {
                formIcon.className = 'fas fa-plane';
                originInput.placeholder = 'Cari bandara asal...';
                destInput.placeholder = 'Cari bandara tujuan...';
                seatSection.style.display = 'grid';
            } else if (category === 'bus') {
                formIcon.className = 'fas fa-bus';
                originInput.placeholder = 'Cari terminal asal...';
                destInput.placeholder = 'Cari terminal tujuan...';
                seatSection.style.display = 'none';
            } else if (category === 'hotel') {
                formIcon.className = 'fas fa-hotel';
                originInput.placeholder = 'Lokasi atau nama hotel...';
                destInput.parentElement.parentElement.style.display = 'none';
                seatSection.style.display = 'none';
            } else if (category === 'wisata') {
                formIcon.className = 'fas fa-camera';
                originInput.placeholder = 'Cari destinasi wisata...';
                destInput.parentElement.parentElement.style.display = 'none';
                seatSection.style.display = 'none';
            }

            if (category !== 'hotel' && category !== 'wisata') {
                destInput.parentElement.parentElement.style.display = 'block';
            }

            performSearch();
        }

        async function performSearch() {
            const origin = document.getElementById('origin').value;
            const dest = document.getElementById('destination').value;

            try {
                const response = await fetch(`/search?category=${currentCategory}&origin=${origin}&destination=${dest}`);
                const data = await response.json();
                renderTickets(data.tickets, currentCategory);
            } catch (error) {
                console.error('Search failed', error);
            }
        }

        function renderTickets(tickets, category) {
            const container = document.getElementById('ticketList');
            container.innerHTML = '';

            if (tickets.length === 0) {
                container.innerHTML = '<div style="text-align: center; padding: 50px; color: #888;">Tidak ada tiket tersedia.</div>';
                return;
            }

            tickets.forEach(ticket => {
                const card = document.createElement('div');
                card.className = 'ticket-card';

                let html = `
                    <div class="ticket-info">
                        <div class="ticket-header">
                            <span class="ticket-name">${ticket.name || ticket.airline_name || ticket.operator || ticket.hotel_name} (${ticket.code || ticket.flight_code || ''})</span>
                            <span style="background: #f0f0f0; padding: 2px 8px; border-radius: 5px; font-size: 11px;">${ticket.class || ticket.seat_type || ticket.room_type || ''}</span>
                        </div>
                `;

                if (category === 'hotel' || category === 'wisata') {
                    html += `
                        <div class="ticket-details">
                            <div style="font-size: 14px; color: #555;">
                                <i class="fas fa-map-marker-alt"></i> ${ticket.location || ticket.category}
                                ${ticket.rating ? `<span style="margin-left: 20px; color: #f59e0b;"><i class="fas fa-star"></i> ${ticket.rating}</span>` : ''}
                                ${ticket.open_hours ? `<div style="margin-top: 5px;"><i class="far fa-clock"></i> ${ticket.open_hours}</div>` : ''}
                            </div>
                        </div>
                    `;
                } else {
                    html += `
                        <div class="ticket-details">
                            <div class="time-slot">
                                <div class="time">${formatTime(ticket.departure_time)}</div>
                                <div class="station">${ticket.origin || ticket.origin_terminal}</div>
                            </div>
                            <div class="duration-arrow">
                                <span>${ticket.duration || ''}</span>
                                <div class="arrow-line"></div>
                                <span>Langsung</span>
                            </div>
                            <div class="time-slot">
                                <div class="time">${ticket.arrival_time ? formatTime(ticket.arrival_time) : '-'}</div>
                                <div class="station">${ticket.destination || ticket.destination_terminal}</div>
                            </div>
                        </div>
                    `;
                }

                html += `
                        <div style="margin-top: 15px; font-size: 12px; color: var(--primary); font-weight: 600; display: flex; gap: 20px;">
                            <span>Detail ${category === 'hotel' ? 'Hotel' : 'Perjalanan'}</span>
                            <span>Info</span>
                        </div>
                    </div>
                    <div class="ticket-price-section">
                        <div class="price">Rp ${new Intl.NumberFormat('id-ID').format(ticket.price || ticket.price_per_night)} <span style="font-size: 12px; color: #888; font-weight: 400;">/ ${category === 'hotel' ? 'malam' : 'pax'}</span></div>
                        <button class="btn-select" onclick="selectTicket(${ticket.id}, ${ticket.price || ticket.price_per_night})">Pilih</button>
                    </div>
                `;

                card.innerHTML = html;
                container.appendChild(card);
            });
        }

        function formatTime(dateTimeStr) {
            const date = new Date(dateTimeStr);
            return date.getHours().toString().padStart(2, '0') + ':' + date.getMinutes().toString().padStart(2, '0');
        }

        async function selectTicket(id, price) {
            selectedTicketId = id;
            selectedTicketPrice = price;
            updatePaymentSummary();
            // Scroll to payment or highlight
            document.querySelector('.payment-card').scrollIntoView({ behavior: 'smooth' });
        }

        async function handleCheckout() {
            @guest
                window.location.href = "{{ route('login') }}";
                return;
            @endguest

            if (!selectedTicketId) {
                alert('Silakan pilih tiket terlebih dahulu');
                return;
            }

            const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
            const passengerCountInput = document.getElementById('passengers').value;
            const passengerCount = parseInt(passengerCountInput) || 1;

            try {
                const response = await fetch('/checkout', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        category: currentCategory,
                        item_id: selectedTicketId,
                        passenger_count: passengerCount,
                        payment_method: paymentMethod
                    })
                });

                const data = await response.json();
                if (data.success) {
                    alert('Pembayaran Berhasil! Kode Booking: ' + data.booking_code);
                    window.location.reload();
                } else {
                    alert('Gagal melakukan checkout: ' + (data.error || 'Unknown error'));
                }
            } catch (error) {
                console.error('Checkout failed', error);
                alert('Terjadi kesalahan saat checkout');
            }
        }

        let discountAmount = 0;

        function applyVoucher() {
            const code = document.getElementById('voucher-code').value.toUpperCase();
            const msg = document.getElementById('voucher-msg');

            if (code === 'VOYAGO50') {
                discountAmount = 50000;
                msg.innerText = 'Voucher applied! Discount Rp 50.000';
                msg.style.color = '#22c55e';
            } else {
                discountAmount = 0;
                msg.innerText = 'Invalid voucher code';
                msg.style.color = '#ef4444';
            }
            msg.style.display = 'block';
            updatePaymentSummary();
        }

        function updatePaymentSummary() {
            const serviceFee = 10000;
            const passengerCountInput = document.getElementById('passengers').value;
            const passengerCount = parseInt(passengerCountInput) || 1;

            const baseTotal = selectedTicketPrice * passengerCount;
            const total = baseTotal + serviceFee - discountAmount;

            document.getElementById('summary-base').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(baseTotal)}`;
            document.getElementById('summary-total').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;

            // Note: In a real app we'd update the discount display element specifically
            // For now we assume the structure from the view exists.
        }
    </script>
</body>

</html>