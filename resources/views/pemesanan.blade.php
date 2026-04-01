@extends('layouts.app')

@section('content')
  <div class="flex flex-col gap-10">
    <!-- Top Section: Categories & Points -->
    <div class="flex flex-col md:flex-row gap-6 items-stretch">
      <x-Pemesanan.tab-menu active="kereta" />
      <div class="md:w-1/3 flex">
        <x-Pemesanan.point-card />
      </div>
    </div>

    <!-- Main Section: Form & Content -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
      <!-- Sidebar Form -->
      <div class="md:col-span-4">
        <x-Pemesanan.form-pemesanan />
      </div>

      <!-- Main Content -->
      <div class="md:col-span-8 flex flex-col gap-6">
        <!-- Filter Cards -->
        <x-Pemesanan.filter />

        <!-- Ticket Search Results -->
        <x-Pemesanan.hasil-tiket :tickets="$tickets" />

        <!-- Payment Details & Method -->
        <x-Pemesanan.pembayaran />
      </div>
    </div>
  </div>

  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script>
    let currentCategory = 'kereta';
    let selectedTicketId = null;
    let selectedTicketPrice = 0;
    let discountAmount = 50000; // Mock discount from image

    async function selectCategory(category, element) {
      currentCategory = category;

      // UI Update Tabs
      document.querySelectorAll('.category-tab').forEach(tab => {
        tab.classList.remove('active-tab');
      });
      element.classList.add('active-tab');

      // Adaptation logic for labels and icons
      const labelOrigin = document.getElementById('label-origin');
      const labelDest = document.getElementById('label-destination');
      const destContainer = document.getElementById('dest-container');
      const classContainer = document.getElementById('class-container');
      const swapContainer = document.getElementById('swap-container');
      const roundTripContainer = document.getElementById('round-trip-container');
      const labelPassengers = document.getElementById('label-passengers');
      const labelDeparture = document.getElementById('label-departure');
      const labelReturn = document.getElementById('label-return');
      const btnSearch = document.getElementById('btn-search');
      const returnDateContainer = document.getElementById('return_date_container');

      const configs = {
        'kereta': { 
            labelO: 'Asal', labelD: 'Tujuan', labelP: 'Jumlah Penumpang', labelDep: 'Tanggal Pergi', labelRet: 'Tanggal Pulang', 
            showClass: true, showSwap: true, showRound: true, showRet: false, btnText: 'Cari Tiket Sekarang' 
        },
        'pesawat': { 
            labelO: 'Bandara Asal', labelD: 'Bandara Tujuan', labelP: 'Jumlah Penumpang', labelDep: 'Tanggal Pergi', labelRet: 'Tanggal Pulang', 
            showClass: true, showSwap: true, showRound: true, showRet: false, btnText: 'Cari Tiket Sekarang' 
        },
        'bus': { 
            labelO: 'Terminal Asal', labelD: 'Terminal Tujuan', labelP: 'Jumlah Penumpang', labelDep: 'Tanggal Pergi', labelRet: 'Tanggal Pulang', 
            showClass: false, showSwap: true, showRound: true, showRet: false, btnText: 'Cari Tiket Sekarang' 
        },
        'hotel': { 
            labelO: 'Lokasi Hotel', labelD: '', labelP: 'Jumlah Tamu', labelDep: 'Check-in', labelRet: 'Check-out', 
            showClass: false, showSwap: false, showRound: false, showRet: true, btnText: 'Cari Hotel Sekarang' 
        },
        'wisata': { 
            labelO: 'Lokasi Wisata', labelD: '', labelP: 'Jumlah Pengunjung', labelDep: 'Tanggal Kunjungan', labelRet: '', 
            showClass: false, showSwap: false, showRound: false, showRet: false, btnText: 'Cari Wisata Sekarang' 
        }
      };

      const config = configs[category];
      
      // Update Labels
      labelOrigin.innerText = config.labelO;
      labelPassengers.innerText = config.labelP;
      labelDeparture.innerText = config.labelDep;
      if (labelReturn && config.labelRet) labelReturn.innerText = config.labelRet;
      if (btnSearch) btnSearch.innerText = config.btnText;

      // Toggle Containers
      classContainer.style.display = config.showClass ? 'flex' : 'none';
      swapContainer.style.display = config.showSwap ? 'flex' : 'none';
      roundTripContainer.style.display = config.showRound ? 'flex' : 'none';
      returnDateContainer.style.display = config.showRet ? 'flex' : (document.getElementById('round_trip').checked ? 'flex' : 'none');

      if (config.labelD) {
        destContainer.style.display = 'flex';
        labelDest.innerText = config.labelD;
      } else {
        destContainer.style.display = 'none';
      }

      await updateLocations(category);
      performSearch();
    }

    async function updateLocations(category) {
      try {
        const response = await fetch(`/get-locations?category=${category}`);
        const data = await response.json();

        const originSelect = document.getElementById('origin');
        const destSelect = document.getElementById('destination');

        originSelect.innerHTML = '<option value="">Pilih Asal</option>';
        destSelect.innerHTML = '<option value="">Pilih Tujuan</option>';

        data.origins.forEach(loc => {
          originSelect.innerHTML += `<option value="${loc}">${loc}</option>`;
        });

        data.destinations.forEach(loc => {
          destSelect.innerHTML += `<option value="${loc}">${loc}</option>`;
        });
      } catch (error) {
        console.error('Failed to fetch locations', error);
      }
    }

    function swapLocations() {
      const origin = document.getElementById('origin');
      const dest = document.getElementById('destination');
      const temp = origin.value;
      origin.value = dest.value;
      dest.value = temp;
      performSearch();
    }

    function toggleRoundTrip() {
      const isChecked = document.getElementById('round_trip').checked;
      const container = document.getElementById('return_date_container');
      container.style.display = isChecked ? 'flex' : 'none';
      performSearch();
    }

    function formatRupiah(number) {
      return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    async function performSearch() {
      const list = document.getElementById('ticketList');
      list.innerHTML = '<div class="text-center py-20"><i class="fas fa-spinner fa-spin text-orange-500 text-5xl"></i><p class="mt-4 font-bold text-gray-500 dark:text-[#A1A1AA] text-xl tracking-widest uppercase">Mencari Tiket...</p></div>';

      const origin = document.getElementById('origin').value;
      const dest = document.getElementById('destination') ? document.getElementById('destination').value : '';
      const date = document.getElementById('departure_date').value;
      const returnDate = document.getElementById('return_date').value;
      const isRoundTrip = document.getElementById('round_trip').checked;
      const className = document.getElementById('class').value;

      try {
        const response = await fetch(`/search?category=${currentCategory}&origin=${origin}&destination=${dest}&date=${date}&return_date=${returnDate}&is_round_trip=${isRoundTrip}&class=${className}`);
        const data = await response.json();
        renderTickets(data.tickets, currentCategory);
      } catch (error) {
        console.error('Search failed', error);
        list.innerHTML = '<div class="text-center py-20 bg-white dark:bg-dark-card rounded-[2rem] border-2 border-dashed border-red-100 text-red-500 font-bold transition-colors duration-300">Terjadi kesalahan saat memuat data.</div>';
      }
    }

    function renderTickets(tickets, category) {
      const container = document.getElementById('ticketList');
      container.innerHTML = '';

      if (tickets.length === 0) {
        container.innerHTML = '<div class="text-center py-20 bg-white dark:bg-dark-card rounded-[2rem] border-2 border-dashed border-gray-100 dark:border-dark-border transition-colors duration-300"><i class="fas fa-ticket text-5xl text-gray-200 mb-4"></i><p class="font-bold text-gray-400">Belum ada tiket tersedia untuk kategori ini.</p></div>';
        return;
      }

      tickets.forEach(ticket => {
        const name = ticket.name || ticket.airline_name || ticket.operator || 'Product';
        const code = ticket.code || ticket.flight_code || '';
        const price = ticket.price || ticket.price_per_night || 0;
        const className = ticket.class || ticket.seat_type || ticket.room_type || 'Standard';

        let timeInfo = '';
        if (ticket.departure_time) {
          const dTime = new Date(ticket.departure_time).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
          const aTime = ticket.arrival_time ? new Date(ticket.arrival_time).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }) : '-';

          timeInfo = `
                          <div class="flex items-center gap-12 flex-grow">
                            <div class="flex flex-col">
                              <span class="text-gray-800 dark:text-white font-black text-[2rem] leading-none">${dTime}</span>
                            </div>
                            <div class="flex flex-col items-center flex-grow max-w-[120px]">
                              <span class="text-[10px] font-bold text-gray-400">${ticket.duration || ''}</span>
                              <div class="w-full flex items-center gap-1 py-1">
                                <div class="h-[1.5px] bg-gray-200 dark:bg-dark-border flex-grow rounded-full"></div>
                                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                              </div>
                              <span class="text-[10px] font-bold text-gray-400">Langsung</span>
                            </div>
                            <div class="flex flex-col">
                              <span class="text-gray-800 dark:text-white font-black text-[2rem] leading-none">${aTime}</span>
                            </div>
                          </div>
                        `;
        } else {
          timeInfo = `
                          <div class="flex items-center gap-12 flex-grow">
                             <div class="flex flex-col">
                                <span class="text-gray-600 dark:text-[#A1A1AA] font-bold text-sm"><i class="fas fa-map-marker-alt text-orange-500 mr-2"></i> ${ticket.location || ticket.category || 'Indonesia'}</span>
                                ${ticket.rating ? `<span class="text-orange-400 font-bold text-sm mt-1"><i class="fas fa-star mr-2"></i> ${ticket.rating}</span>` : ''}
                             </div>
                          </div>
                        `;
        }

        const card = document.createElement('div');
        card.className = 'bg-white dark:bg-dark-card border-2 border-gray-100 dark:border-dark-border rounded-[2rem] p-6 hover:border-orange-300 transition-all flex flex-col gap-4 group';
        card.innerHTML = `
                        <div class="flex items-start justify-between">
                          <div class="flex flex-col">
                            <h3 class="text-orange-500 font-black text-2xl leading-tight">${name} ${code ? `(${code})` : ''}</h3>
                            <span class="text-xs font-bold text-orange-400 italic">${className}</span>
                          </div>
                          <div class="flex flex-col items-end">
                            <div class="flex items-baseline gap-1">
                              <span class="text-orange-500 font-black text-2xl tracking-tighter">${formatRupiah(price).replace(',00', '')}</span>
                              <span class="text-gray-400 font-bold text-sm">/ ${ticket.price_per_night ? 'malam' : 'pax'}</span>
                            </div>
                          </div>
                        </div>
                        <div class="flex items-center justify-between">
                          ${timeInfo}
                          <div class="flex gap-2">
                             <button onclick="addToPlan('${encodeURIComponent(JSON.stringify(ticket))}')"
                               class="w-12 h-12 bg-gray-50 dark:bg-[#121212] text-gray-400 hover:text-orange-500 hover:bg-orange-50 dark:hover:bg-[#2A2A2A] rounded-2xl flex items-center justify-center transition-all" title="Simpan ke Rencana">
                               <input type="checkbox" class="hidden">
                               <i class="fas fa-folder-plus text-xl"></i>
                             </button>
                             <button onclick="selectTicket(${ticket.id}, ${price}, '${encodeURIComponent(JSON.stringify(ticket))}')"
                              class="bg-orange-100 group-hover:bg-orange-50 dark:hover:bg-[#2A2A2A]0 group-hover:text-white text-orange-400 font-black px-12 py-3 rounded-2xl transition-all shadow-sm">
                              Pilih
                             </button>
                          </div>
                        </div>
                        <div class="flex gap-4 border-t border-gray-50 dark:border-dark-border pt-3">
                          <button class="text-xs font-black text-gray-800 dark:text-white hover:text-orange-500 transition-colors uppercase tracking-widest">Detail ${ticket.price_per_night ? 'Hotel' : 'Perjalanan'}</button>
                          <button class="text-xs font-black text-gray-800 dark:text-white hover:text-orange-500 transition-colors uppercase tracking-widest">Info</button>
                        </div>
                      `;
        container.appendChild(card);
      });
    }

    async function addToPlan(ticketJson) {
      const ticket = JSON.parse(decodeURIComponent(ticketJson));
      const category = currentCategory === 'kereta' || currentCategory === 'pesawat' || currentCategory === 'bus' ? 'transport' : currentCategory;

      try {
        const response = await fetch('/planning/add-item', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
          body: JSON.stringify({
            category: category,
            product_id: ticket.id,
            title: ticket.name || ticket.airline_name || ticket.operator || 'Product',
            subtitle: ticket.origin && ticket.destination ? `${ticket.origin} → ${ticket.destination}` : (ticket.location || ''),
            price: ticket.price || ticket.price_per_night,
            image: category === 'wisata' ? 'pd-2.jpeg' : (category === 'hotel' ? 'pd-1.jpeg' : 'hero1.jpeg'),
            date_info: ticket.departure_time ? new Date(ticket.departure_time).toLocaleDateString() : 'Set Date',
            optional_stats: ticket.duration || ticket.rating || ''
          })
        });
        const data = await response.json();
        if (data.success) {
          alert('Tersimpan di Room Planning!');
        }
      } catch (e) { console.error(e); }
    }

    let selectedSeats = [];

    async function selectTicket(id, price, ticketJson) {
      selectedTicketId = id;
      selectedTicketPrice = price;

      // Show Payment & Seat Selection Section
      const paySection = document.getElementById('pembayaran-section');
      if (paySection) paySection.style.display = 'flex';

      // Fill Ticket Summary in the section
      const ticket = JSON.parse(decodeURIComponent(ticketJson));
      const name = ticket.name || ticket.airline_name || ticket.operator || 'Product';
      const route = ticket.origin && ticket.destination ? `${ticket.origin} → ${ticket.destination}` : (ticket.location || 'Indonesia');
      const className = ticket.class || ticket.room_type || 'Economy';

      if (document.getElementById('display-selected-name')) document.getElementById('display-selected-name').innerText = name;
      if (document.getElementById('display-selected-route')) document.getElementById('display-selected-route').innerText = route;
      if (document.getElementById('display-selected-class')) document.getElementById('display-selected-class').innerText = className;

      // Reset Seats Selection UI
      selectedSeats = [];
      document.querySelectorAll('.seat-item').forEach(el => {
        el.classList.remove('!bg-orange-500', '!text-white', 'opacity-20', 'cursor-not-allowed', 'pointer-events-none');
        el.classList.add('bg-gray-50', 'dark:bg-[#121212]', 'text-gray-400');
      });

      // Fetch booked seats for integrity
      try {
        const response = await fetch(`/booked-seats?category=${currentCategory}&item_id=${id}`);
        const booked = await response.json();
        document.querySelectorAll('.seat-item').forEach(el => {
          const sNo = el.innerText.trim();
          if (booked.includes(sNo)) {
             el.classList.add('opacity-20', 'cursor-not-allowed', 'pointer-events-none');
             el.classList.remove('bg-gray-50', 'dark:bg-[#121212]', 'text-gray-400');
          }
        });
      } catch (e) {
        console.error('Failed to fetch booked seats', e);
      }

      updateSeatCountDisplay();
      updatePaymentSummary();

      // Smooth scroll to the checkout section
      window.scrollTo({
        top: paySection.offsetTop - 50,
        behavior: 'smooth'
      });
    }

    function toggleSeat(element, seatNo) {
      const passengerCount = parseInt(document.getElementById('passengers').value) || 1;

      if (selectedSeats.includes(seatNo)) {
        selectedSeats = selectedSeats.filter(s => s !== seatNo);
        element.classList.remove('!bg-orange-500', '!text-white');
        element.classList.add('bg-gray-50', 'dark:bg-[#121212]', 'text-gray-400');
      } else {
        if (selectedSeats.length < passengerCount) {
          selectedSeats.push(seatNo);
          element.classList.add('!bg-orange-500', '!text-white');
          element.classList.remove('text-gray-400');
        } else {
          alert(`Anda hanya dapat memilih ${passengerCount} kursi sesuai jumlah penumpang.`);
        }
      }
      updateSeatCountDisplay();
    }

    function updateSeatCountDisplay() {
      const pCount = parseInt(document.getElementById('passengers').value) || 1;
      const display = document.getElementById('seat-count-display');
      if (display) display.innerText = `${selectedSeats.length}/${pCount} Kursi Terpilih`;
    }

    function updateSeatLimit() {
      const pCount = parseInt(document.getElementById('passengers').value) || 1;
      if (pCount > 4) {
        document.getElementById('passengers').value = 4;
        alert('Maksimal pemesanan adalah 4 tiket.');
      }

      // Reset seats on count change
      selectedSeats = [];
      document.querySelectorAll('.seat-item').forEach(el => {
        el.classList.remove('bg-orange-500', 'text-white');
        el.classList.add('bg-gray-50 dark:bg-[#121212]', 'text-gray-400');
      });
      updateSeatCountDisplay();
    }

    // Wrap handle search to hide payment section until re-selected
    const baseAction = performSearch;
    performSearch = async function () {
      const paySection = document.getElementById('pembayaran-section');
      if (paySection) paySection.style.display = 'none';
      await baseAction();
    };

    function updatePaymentSummary() {
      const passengerCount = parseInt(document.getElementById('passengers').value) || 1;
      const baseTotal = selectedTicketPrice * passengerCount;
      const serviceFee = 10000;
      const total = baseTotal + serviceFee - discountAmount;

      if (document.getElementById('summary-base')) {
        document.getElementById('summary-base').innerText = formatRupiah(baseTotal).replace(',00', '');
        document.getElementById('label-summary-price').innerText = `Harga tiket ( ${passengerCount} pax ) :`;
      }
      if (document.getElementById('summary-total')) {
        document.getElementById('summary-total').innerText = (total > 0 ? formatRupiah(total) : formatRupiah(0)).replace(',00', '');
      }
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

      const passengerCount = parseInt(document.getElementById('passengers').value) || 1;

      // Seat validation logic
      if (selectedSeats.length !== passengerCount) {
        alert(`Silakan pilih ${passengerCount} kursi terlebih dahulu sesuai jumlah penumpang.`);
        return;
      }

      const paymentMethod = document.querySelector('input[name="payment"]:checked').value;

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
            payment_method: paymentMethod,
            seats: selectedSeats
          })
        });

        const data = await response.json();
        if (data.success) {
          // Trigger Midtrans Snap
          window.snap.pay(data.snap_token, {
            onSuccess: function (result) {
              alert('Pembayaran Berhasil!');
              window.location.href = '{{ route('my.bookings') }}';
            },
            onPending: function (result) {
              alert('Pembayaran Menunggu Konfirmasi.');
              window.location.href = '{{ route('my.bookings') }}';
            },
            onError: function (result) {
              alert('Pembayaran Gagal!');
            },
            onClose: function () {
              alert('Anda menutup popup pembayaran sebelum selesai.');
            }
          });
        } else {
          alert('Gagal: ' + (data.error || 'Unknown error'));
        }
      } catch (error) {
        console.error('Checkout failed', error);
        alert('Terjadi kesalahan saat checkout');
      }
    }

    // Initialize
    window.onload = () => {
      const defaultTab = document.querySelector('.category-tab[onclick*="kereta"]');
      if (defaultTab) selectCategory('kereta', defaultTab);
    };
  </script>
@endsection