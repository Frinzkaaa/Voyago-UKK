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
    // let discountAmount = 50000; // Deprecated static mock

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
      
      // Reset & Set Initial Max Limit
      const passengerInput = document.getElementById('passengers');
      if (category === 'pesawat') passengerInput.max = 7;
      else if (category === 'airport_transfer') passengerInput.max = 4;
      else passengerInput.max = 100; 
      
      const paxHelper = passengerInput.nextElementSibling;
      if (paxHelper) paxHelper.innerText = `*Maksimal ${passengerInput.max} tiket`;

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
                          <div class="flex flex-wrap md:flex-nowrap items-center gap-4 md:gap-12 flex-grow">
                            <div class="flex flex-col">
                              <span class="text-gray-800 dark:text-white font-black text-2xl md:text-[2rem] leading-none">${dTime}</span>
                              <span class="text-gray-400 font-bold text-[10px] md:text-xs mt-1 uppercase tracking-tighter truncate max-w-[80px] md:max-w-none">${ticket.origin || ''}</span>
                            </div>
                            <div class="flex flex-col items-center flex-grow max-w-[80px] md:max-w-[120px]">
                              <span class="text-[9px] md:text-[10px] font-bold text-gray-400">${ticket.duration || ''}</span>
                              <div class="w-full flex items-center gap-1 py-1">
                                <div class="h-[1.5px] bg-gray-200 dark:bg-dark-border flex-grow rounded-full"></div>
                                <i class="fas fa-chevron-right text-[8px] text-gray-300"></i>
                              </div>
                              <span class="text-[9px] md:text-[10px] font-bold text-gray-400">Langsung</span>
                            </div>
                            <div class="flex flex-col items-end">
                              <span class="text-gray-800 dark:text-white font-black text-2xl md:text-[2rem] leading-none">${aTime}</span>
                              <span class="text-gray-400 font-bold text-[10px] md:text-xs mt-1 uppercase tracking-tighter truncate max-w-[80px] md:max-w-none text-right">${ticket.destination || ''}</span>
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
                        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                          <div class="flex flex-col">
                            <h3 class="text-orange-500 font-black text-xl md:text-2xl leading-tight">${name} ${code ? `(${code})` : ''}</h3>
                            <span class="text-[10px] md:text-xs font-bold text-orange-400 italic">${className}</span>
                          </div>
                          <div class="flex flex-col sm:items-end">
                            <div class="flex items-baseline gap-1">
                              <span class="text-orange-500 font-black text-xl md:text-2xl tracking-tighter">${formatRupiah(price).replace(',00', '')}</span>
                              <span class="text-gray-400 font-bold text-xs whitespace-nowrap">/ ${ticket.price_per_night ? 'malam' : 'pax'}</span>
                            </div>
                          </div>
                        </div>
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 py-2 border-t md:border-t-0 border-gray-50 dark:border-dark-border">
                          ${timeInfo}
                          <div class="flex w-full md:w-auto gap-2 mt-4 md:mt-0 items-end justify-end">
                             <button onclick="addToPlan('${encodeURIComponent(JSON.stringify(ticket))}')"
                                class="w-12 h-12 shrink-0 bg-gray-50 dark:bg-[#121212] text-gray-400 hover:text-orange-500 hover:bg-orange-50 dark:hover:bg-[#2A2A2A] rounded-2xl flex items-center justify-center transition-all" title="Simpan ke Rencana">
                               <input type="checkbox" class="hidden">
                               <i class="fas fa-folder-plus text-xl"></i>
                             </button>
                             <button onclick="selectTicket(${ticket.id}, ${price}, '${encodeURIComponent(JSON.stringify(ticket))}')"
                              class="bg-orange-100 dark:bg-orange-500/10 text-orange-500 group-hover:bg-orange-500 group-hover:text-white font-black px-8 md:px-12 py-3 rounded-2xl transition-all shadow-sm whitespace-nowrap flex-grow md:flex-grow-0">
                              Pilih
                             </button>
                          </div>
                        </div>
                        <div class="flex gap-4 border-t border-gray-50 dark:border-dark-border pt-3">
                          <button onclick="showDetail('${encodeURIComponent(JSON.stringify(ticket))}')" class="text-xs font-black text-gray-800 dark:text-white hover:text-orange-500 transition-colors uppercase tracking-widest">Detail ${ticket.price_per_night ? 'Hotel' : 'Perjalanan'}</button>
                          <button onclick="showDetail('${encodeURIComponent(JSON.stringify(ticket))}')" class="text-xs font-black text-gray-800 dark:text-white hover:text-orange-500 transition-colors uppercase tracking-widest">Info</button>
                        </div>
                      `;
        container.appendChild(card);
      });
    }

    const AIRPORT_MAP = {
      'CGK': 'Soekarno-Hatta Intl, Jakarta',
      'DPS': 'Ngurah Rai Intl, Bali',
      'SUB': 'Juanda Intl, Surabaya',
      'KNO': 'Kualanamu Intl, Medan',
      'UPG': 'Sultan Hasanuddin, Makassar',
      'YIA': 'Yogyakarta Intl, Yogyakarta',
      'HLP': 'Halim Perdanakusuma, Jakarta',
      'BPN': 'Sultan Aji Muhammad Sulaiman, Balikpapan',
      'JOG': 'Adisutjipto Intl, Yogyakarta',
      'SIN': 'Changi Airport, Singapore',
      'BDO': 'Husein Sastranegara, Bandung',
      'SRG': 'Achmad Yani, Semarang'
    };

    function showDetail(ticketJson) {
      const ticket = JSON.parse(decodeURIComponent(ticketJson));
      const modal = document.getElementById('detailModal');
      const content = document.getElementById('modalContent');

      const originName = AIRPORT_MAP[ticket.origin] || ticket.origin || '-';
      const destName = AIRPORT_MAP[ticket.destination] || ticket.destination || '-';
      const name = ticket.name || ticket.airline_name || ticket.operator || 'Detail Produk';

      let extraInfo = '';
      if (ticket.airline_name) {
         extraInfo = `
           <div class="flex flex-col gap-6">
             <div class="flex items-center gap-6 p-4 bg-orange-50 dark:bg-orange-500/10 rounded-3xl border border-orange-100 dark:border-orange-500/20">
               <div class="w-14 h-14 bg-white dark:bg-[#1A1A1A] rounded-2xl flex items-center justify-center shadow-sm">
                 <i class="fas fa-plane text-orange-500 text-2xl"></i>
               </div>
               <div>
                  <p class="text-xs font-bold text-orange-400 uppercase tracking-widest">Maskapai & Rute</p>
                  <p class="text-lg font-black text-gray-800 dark:text-white">${ticket.airline_name} (${ticket.flight_code})</p>
               </div>
             </div>

             <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col gap-2">
                   <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-2">DARI</p>
                   <div class="p-4 bg-gray-50 dark:bg-dark-bg rounded-3xl border border-gray-100 dark:border-dark-border">
                      <p class="text-2xl font-black text-gray-800 dark:text-white">${new Date(ticket.departure_time).toLocaleTimeString('id-id', {hour:'2-digit', minute:'2-digit'})}</p>
                      <p class="text-xs font-bold text-gray-500 mt-1 uppercase tracking-tighter">${ticket.origin}</p>
                      <p class="text-[10px] font-medium text-gray-400 truncate mt-0.5">${originName}</p>
                   </div>
                </div>
                <div class="flex flex-col gap-2">
                   <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-2 text-right">MENUJU</p>
                   <div class="p-4 bg-gray-50 dark:bg-dark-bg rounded-3xl border border-gray-100 dark:border-dark-border text-right">
                      <p class="text-2xl font-black text-gray-800 dark:text-white">${new Date(ticket.arrival_time).toLocaleTimeString('id-id', {hour:'2-digit', minute:'2-digit'})}</p>
                      <p class="text-xs font-bold text-gray-500 mt-1 uppercase tracking-tighter">${ticket.destination}</p>
                      <p class="text-[10px] font-medium text-gray-400 truncate mt-0.5">${destName}</p>
                   </div>
                </div>
             </div>

             <div class="p-4 bg-gray-50/50 dark:bg-dark-bg/50 rounded-3xl border-2 border-dashed border-gray-100 dark:border-dark-border">
                <div class="flex justify-between items-center">
                   <span class="text-sm font-bold text-gray-500 uppercase">Durasi Perjalanan</span>
                   <span class="text-sm font-black text-orange-500">${ticket.duration}</span>
                </div>
                <div class="flex justify-between items-center mt-2">
                   <span class="text-sm font-bold text-gray-500 uppercase">Fasilitas Bagasi</span>
                   <span class="text-sm font-black text-gray-700 dark:text-white">${ticket.baggage_info || '20kg'}</span>
                </div>
             </div>
           </div>
         `;
      } else {
         extraInfo = `
           <div class="flex flex-col gap-4">
              <div class="p-6 bg-gray-50 dark:bg-dark-bg rounded-3xl border border-gray-100 dark:border-dark-border">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Lokasi</p>
                <p class="text-lg font-black text-gray-800 dark:text-white">${ticket.location || ticket.name}</p>
              </div>
              <div class="grid grid-cols-2 gap-4">
                 <div class="p-4 bg-orange-50 dark:bg-orange-500/10 rounded-2xl border border-orange-100">
                    <p class="text-[10px] font-black text-orange-400 uppercase">Tipe</p>
                    <p class="text-sm font-black text-orange-600">${ticket.class || ticket.room_type || 'Standard'}</p>
                 </div>
                 <div class="p-4 bg-gray-50 dark:bg-dark-bg rounded-2xl border border-gray-100">
                    <p class="text-[10px] font-black text-gray-400 uppercase">Rating</p>
                    <p class="text-sm font-black text-gray-700 dark:text-white"><i class="fas fa-star text-orange-400 mr-1"></i> ${ticket.rating || '5.0'}</p>
                 </div>
              </div>
           </div>
         `;
      }

      content.innerHTML = extraInfo;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }

    function closeModal() {
      const modal = document.getElementById('detailModal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
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

      // Handle Seat Selection Display
      const seatContainer = document.getElementById('seat-selection-container');
      if (seatContainer) {
        if (currentCategory === 'hotel' || currentCategory === 'wisata') {
          seatContainer.style.display = 'none';
        } else {
          seatContainer.style.display = 'block';
        }
      }

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

      // Set Capacity Limit based on Ticket
      const passengerInput = document.getElementById('passengers');
      let capacity = 10;
      if (currentCategory === 'pesawat') capacity = 7;
      else if (currentCategory === 'airport_transfer') capacity = 4;
      else if (currentCategory === 'hotel') capacity = ticket.room_capacity || ticket.availability || 2;
      else if (currentCategory === 'car_rental' || currentCategory === 'rent_car') capacity = ticket.capacity || 4;
      else if (['bus', 'kereta', 'train'].includes(currentCategory)) capacity = ticket.seats_available || 0;

      passengerInput.max = capacity;
      const paxHelper = passengerInput.nextElementSibling;
      if (paxHelper) paxHelper.innerText = `*Kapasitas maksimal: ${capacity}`;

      if (parseInt(passengerInput.value) > capacity) {
        passengerInput.value = capacity;
        alert(`Jumlah penumpang/tamu disesuaikan dengan kapasitas maksimal (${capacity}).`);
      }

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
      const passengerInput = document.getElementById('passengers');
      const pCount = parseInt(passengerInput.value) || 1;
      const maxLimit = parseInt(passengerInput.max) || 100;

      if (pCount > maxLimit) {
        passengerInput.value = maxLimit;
        alert(`Batas maksimal adalah ${maxLimit} sesuai kapasitas.`);
      }

      // Reset seats on count change
      selectedSeats = [];
      document.querySelectorAll('.seat-item').forEach(el => {
        el.classList.remove('!bg-orange-500', '!text-white');
        el.classList.add('bg-gray-50', 'dark:bg-[#121212]', 'text-gray-400');
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
      let discountAmount = baseTotal > 50000 ? 50000 : 0;
      const total = baseTotal + serviceFee - discountAmount;

      if (document.getElementById('summary-base')) {
        document.getElementById('summary-base').innerText = formatRupiah(baseTotal).replace(',00', '');
        document.getElementById('label-summary-price').innerText = `Harga tiket ( ${passengerCount} pax ) :`;
      }
      
      const discountContainer = document.getElementById('summary-discount-row');
      if (discountContainer) {
          if (discountAmount > 0) {
              discountContainer.style.display = 'flex';
              document.getElementById('summary-discount-value').innerText = `- ${formatRupiah(discountAmount).replace(',00', '')}`;
          } else {
              discountContainer.style.display = 'none';
          }
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

      // Skip seat validation for hotel/wisata
      const isTransport = ['kereta', 'pesawat', 'bus'].includes(currentCategory);
      if (isTransport && selectedSeats.length !== passengerCount) {
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
          // Midtrans Snap Pay
          window.snap.pay(data.snap_token, {
            onSuccess: function(result) {
              window.location.href = "{{ route('my.bookings') }}";
            },
            onPending: function(result) {
              window.location.href = "{{ route('my.bookings') }}";
            },
            onError: function(result) {
              alert("Pembayaran Gagal!");
              console.log(result);
            },
            onClose: function() {
              alert('Anda menutup popup pembayaran sebelum menyelesaikan pembayaran.');
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

    function showSimulator(code, amount) {
       const paymentMethod = document.querySelector('input[name="payment"]:checked').value;
       const simContent = document.getElementById('sim-method-content');
       
       document.getElementById('sim-booking-code').innerText = code;
       document.getElementById('sim-amount').innerText = formatRupiah(amount).replace(',00', '');

       let contentHtml = '';
       if (paymentMethod === 'qris') {
          contentHtml = `
            <div class="flex flex-col items-center gap-6">
                <div class="w-48 h-48 bg-white p-4 rounded-[2rem] shadow-xl border-4 border-orange-50 relative group">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=VoyagoPay-${code}" class="w-full h-full grayscale group-hover:grayscale-0 transition-all duration-500">
                    <div class="absolute inset-0 flex items-center justify-center bg-black/5 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                        <i class="fas fa-expand text-orange-500 text-3xl"></i>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Pindai dengan Aplikasi Apapun</p>
                    <div class="flex items-center gap-3 justify-center opacity-60">
                        <i class="fab fa-google-pay text-2xl"></i>
                        <i class="fab fa-apple-pay text-2xl"></i>
                        <i class="fas fa-credit-card text-lg"></i>
                    </div>
                </div>
            </div>
          `;
       } else if (paymentMethod === 'bank') {
          contentHtml = `
            <div class="space-y-4 w-full">
                <div class="bg-blue-600 p-6 rounded-[2rem] text-white relative overflow-hidden shadow-lg shadow-blue-500/20">
                    <div class="flex justify-between items-start relative z-10">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest opacity-70 mb-1">Virtual Account - BNI</p>
                            <h4 class="text-2xl font-black tracking-tight" id="va-number">8807 0{{ auth()->id() }} {{ rand(1000, 9999) }} {{ rand(10, 99) }}</h4>
                        </div>
                        <i class="fas fa-university text-3xl opacity-30"></i>
                    </div>
                    <button onclick="alert('Nomor VA Disalin!')" class="mt-4 flex items-center gap-2 bg-white/20 hover:bg-white/30 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                        <i class="fas fa-copy"></i> Salin Nomor
                    </button>
                    <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                </div>
                <div class="p-6 bg-blue-50 dark:bg-blue-900/10 rounded-[2rem] border border-blue-100 dark:border-blue-800/30">
                    <p class="text-[10px] font-black text-blue-600 dark:text-blue-400 uppercase mb-2">Instruksi Pembayaran</p>
                    <ul class="text-[11px] font-bold text-blue-800 dark:text-blue-300 space-y-2 opacity-80 leading-relaxed">
                        <li>1. Masuk ke m-Banking atau ATM terdekat</li>
                        <li>2. Pilih Menu Transaksi > Virtual Account Billing</li>
                        <li>3. Masukkan nomor VA di atas dan konfirmasi biaya</li>
                    </ul>
                </div>
            </div>
          `;
       } else {
          contentHtml = `
            <div class="space-y-6 w-full">
                <div class="flex items-center gap-6 p-6 bg-emerald-50 dark:bg-emerald-900/10 rounded-[2rem] border border-emerald-100 dark:border-emerald-800/30">
                    <div class="w-16 h-16 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-mobile-screen-button text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-xs font-black text-emerald-600 dark:text-emerald-400 uppercase mb-1">E-Wallet (Gopay/Dana)</p>
                        <p class="text-sm font-bold text-emerald-800 dark:text-emerald-300">Menunggu pembayaran di aplikasi ponsel Anda...</p>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-dark-bg p-6 rounded-[2rem] text-center border-2 border-dashed border-gray-200 dark:border-zinc-800">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Notifikasi Terkirim Ke:</p>
                    <p class="text-xl font-black text-gray-800 dark:text-white">0812-****-{{ rand(1000, 9999) }}</p>
                </div>
            </div>
          `;
       }

       simContent.innerHTML = contentHtml;
       document.getElementById('simulatorModal').classList.remove('hidden');
       document.getElementById('simulatorModal').classList.add('flex');
    }

    async function confirmSimulator() {
       const code = document.getElementById('sim-booking-code').innerText;
       const btn = document.getElementById('btn-confirm-sim');
       btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...';
       btn.disabled = true;

       try {
          const response = await fetch('/simulate-payment', {
             method: 'POST',
             headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
             },
             body: JSON.stringify({ booking_code: code })
          });
          const data = await response.json();
          if (data.success) {
             document.getElementById('sim-content').innerHTML = `
                <div class="text-center py-10 animate-bounce">
                   <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                      <i class="fas fa-check text-5xl text-green-500"></i>
                   </div>
                   <h3 class="text-3xl font-black text-gray-800 dark:text-white tracking-tighter">PEMBAYARAN BERHASIL!</h3>
                   <p class="text-gray-500 font-bold mt-2 pb-10">Tiket Anda telah terbit dan siap digunakan.</p>
                </div>
             `;
             setTimeout(() => {
                window.location.href = '{{ route('my.bookings') }}';
             }, 2000);
          }
       } catch (e) {
         console.error(e);
         btn.innerText = 'Konfirmasi Pembayaran';
         btn.disabled = false;
       }
    }

    function closeSimulator() {
       document.getElementById('simulatorModal').classList.add('hidden');
       document.getElementById('simulatorModal').classList.remove('flex');
    }

    // Initialize
    window.onload = () => {
      const defaultTab = document.querySelector('.category-tab[onclick*="kereta"]');
      if (defaultTab) selectCategory('kereta', defaultTab);
    };
  </script>

  <!-- Ticket Detail Modal -->
  <div id="detailModal" class="hidden fixed inset-0 z-[9999] items-center justify-center p-6">
    <!-- Backdrop with premium blur -->
    <div class="absolute inset-0 bg-black/40 backdrop-blur-md transition-opacity duration-300" onclick="closeModal()"></div>
    
    <!-- Modal Container -->
    <div class="relative bg-white dark:bg-dark-card w-full max-w-md rounded-[3rem] shadow-2xl border-4 border-white dark:border-[#2A2A2A] overflow-hidden transform transition-all duration-300 scale-100">
      
      <!-- Premium Header Gradient -->
      <div class="absolute top-0 left-0 right-0 h-32 bg-gradient-to-br from-orange-500/10 to-transparent -z-10"></div>

      <!-- Close Button -->
      <div class="p-8 pb-4 flex justify-between items-start relative z-10">
        <div>
          <h2 class="text-2xl font-black text-gray-800 dark:text-white uppercase tracking-tighter">Detail Info</h2>
          <div class="h-1.5 w-12 bg-orange-500 rounded-full mt-2"></div>
        </div>
        <button onclick="closeModal()" class="w-12 h-12 bg-gray-100 dark:bg-dark-bg rounded-2xl flex items-center justify-center text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all">
          <i class="fas fa-times text-xl"></i>
        </button>
      </div>

      <!-- Scrollable Body -->
      <div class="p-8 pt-2 max-h-[60vh] overflow-y-auto custom-scrollbar" id="modalContent">
         <!-- Dynamic Content Injected via JS -->
      </div>

      <!-- Action Footer -->
      <div class="p-8 pt-0">
        <button onclick="closeModal()" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-[2rem] transition-all shadow-xl shadow-orange-500/20 uppercase tracking-widest text-xs flex items-center justify-center gap-2">
          <span>Mengerti</span>
          <i class="fas fa-check-circle"></i>
        </button>
      </div>
    </div>
  </div>

  <style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #2d2d2d; }
  </style>  <!-- Voyago Pay Simulator Modal -->
  <div id="simulatorModal" class="hidden fixed inset-0 z-[10000] items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-950/60 backdrop-blur-sm transition-opacity duration-300" onclick="closeSimulator()"></div>
    
    <div id="sim-container" class="relative bg-white dark:bg-dark-card w-full max-w-md rounded-[3rem] shadow-2xl border-4 border-white dark:border-[#2A2A2A] overflow-hidden transform transition-all duration-300 scale-100">
      
       <div class="bg-gradient-to-r from-gray-900 to-black p-8 text-white flex justify-between items-center relative overflow-hidden">
          <div class="relative z-10">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] opacity-50 mb-1">Official Gateway</p>
            <h2 class="text-2xl font-black tracking-tighter">VOYAGO<span class="text-orange-500">PAY</span></h2>
          </div>
          <div class="w-12 h-12 bg-white/10 rounded-2xl backdrop-blur-md flex items-center justify-center border border-white/10 relative z-10">
             <i class="fas fa-shield-halved text-xl text-orange-500"></i>
          </div>
          <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/20 rounded-full blur-2xl"></div>
       </div>

       <div class="p-8" id="sim-content">
          <div class="flex flex-col items-center mb-8">
             <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4">Total Tagihan</p>
             <h3 class="text-4xl font-black text-gray-900 dark:text-white leading-none tracking-tighter" id="sim-amount">Rp 0</h3>
             <div class="bg-gray-100 dark:bg-zinc-800 px-4 py-2 rounded-xl mt-6 flex items-center gap-3 border border-gray-200 dark:border-zinc-700">
                <span class="text-[11px] font-black text-gray-600 dark:text-zinc-400 uppercase tracking-widest" id="sim-booking-code">VYG-XXXXX</span>
                <div class="w-px h-3 bg-gray-300 dark:bg-zinc-600"></div>
                <span class="text-[10px] font-black text-orange-500 uppercase tracking-widest">Simulator</span>
             </div>
          </div>

          <div id="sim-method-content" class="mb-10 flex flex-col items-center w-full">
             <!-- Injected content based on payment method -->
          </div>

          <div class="space-y-3">
              <button id="btn-confirm-sim" onclick="confirmSimulator()" class="w-full bg-orange-500 text-white font-black py-5 rounded-2xl hover:bg-orange-600 transition-all shadow-xl shadow-orange-500/20 uppercase tracking-widest text-xs flex items-center justify-center gap-2">
                 <span>Konfirmasi Pembayaran</span>
                 <i class="fas fa-check-circle"></i>
              </button>
              
              <button onclick="closeSimulator()" class="w-full py-3 text-[10px] font-black text-gray-400 hover:text-red-500 transition-colors uppercase tracking-[0.2em]">
                 Batalkan Transaksi
              </button>
          </div>
       </div>
    </div>
  </div>
@endsection