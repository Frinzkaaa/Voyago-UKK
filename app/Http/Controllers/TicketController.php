<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\TrainTicket;
use App\Models\FlightTicket;
use App\Models\BusTicket;
use App\Models\Hotel;
use App\Models\WisataSpot;
use Midtrans\Snap;
use Midtrans\Config;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    private function getActiveProductQuery($model)
    {
        $tableName = $model->getTable();
        return $model::query()
            ->join('users', 'users.id', '=', $tableName . '.user_id')
            ->join('partners', 'partners.user_id', '=', 'users.id')
            ->where($tableName . '.status', 'active')
            ->where($tableName . '.is_active', true)
            ->where('partners.status', 'verified')
            // Ambil semua kolom dari tabel produk, pastikan image terbawa
            ->select($tableName . '.*');
    }

    public function index()
    {
        $categories = Category::all();
        // Default to Kereta
        $tickets = $this->getActiveProductQuery(new TrainTicket)->get();

        $recentBookings = [];
        if (auth()->check()) {
            $recentBookings = \App\Models\Booking::where('user_id', auth()->id())
                ->latest()
                ->take(3)
                ->get();

            foreach ($recentBookings as $booking) {
                $booking->item = $this->getItem($booking->category, $booking->item_id);
            }
        }

        $bestDestinations = WisataSpot::where('status', 'active')
            ->where('is_active', true)
            ->latest()
            ->take(3)
            ->get();

        return view('beranda', compact('categories', 'tickets', 'recentBookings', 'bestDestinations'));
    }

    public function getLocations(Request $request)
    {
        $category = $request->query('category', 'kereta');
        $origins = [];
        $destinations = [];

        switch ($category) {
            case 'kereta':
                $origins = TrainTicket::distinct()->pluck('origin');
                $destinations = TrainTicket::distinct()->pluck('destination');
                break;
            case 'pesawat':
                $origins = FlightTicket::distinct()->pluck('origin');
                $destinations = FlightTicket::distinct()->pluck('destination');
                break;
            case 'bus':
                $origins = BusTicket::distinct()->pluck('origin_terminal');
                $destinations = BusTicket::distinct()->pluck('destination_terminal');
                break;
            case 'hotel':
                $destinations = Hotel::distinct()->pluck('location');
                break;
            case 'wisata':
                $destinations = WisataSpot::distinct()->pluck('name');
                break;
        }

        return response()->json([
            'origins' => $origins,
            'destinations' => $destinations
        ]);
    }

    public function search(Request $request)
    {
        $category = $request->query('category', 'kereta');
        $origin = $request->query('origin');
        $destination = $request->query('destination');
        $date = $request->query('date');
        $class = $request->query('class');

        switch ($category) {
            case 'kereta':
                $query = $this->getActiveProductQuery(new TrainTicket);
                if ($origin)
                    $query->where('origin', $origin);
                if ($destination)
                    $query->where('destination', $destination);
                if ($date)
                    $query->whereDate('departure_time', $date);
                if ($class && $class !== 'All')
                    $query->where('class', 'LIKE', "%$class%");
                $tickets = $query->get()->map(function($t) {
                    $t->image = $t->image ?? (json_decode($t->train_images)[0] ?? null);
                    return $t;
                });
                break;
            case 'pesawat':
                $query = $this->getActiveProductQuery(new FlightTicket);
                if ($origin)
                    $query->where('origin', $origin);
                if ($destination)
                    $query->where('destination', $destination);
                if ($date)
                    $query->whereDate('departure_time', $date);
                $tickets = $query->get()->map(function($t) {
                    // Cek image utama, jika kosong ambil airline_logo
                    $t->image = $t->image ?? $t->airline_logo;
                    return $t;
                });
                break;
            case 'bus':
                $query = $this->getActiveProductQuery(new BusTicket);
                if ($origin)
                    $query->where('origin_terminal', $origin);
                if ($destination)
                    $query->where('destination_terminal', $destination);
                if ($date)
                    $query->whereDate('departure_time', $date);
                $tickets = $query->get();
                break;
            case 'hotel':
                $query = $this->getActiveProductQuery(new Hotel);
                if ($destination)
                    $query->where('location', $destination);
                $tickets = $query->get()->map(function($t) {
                    $t->image = $t->image ?? $t->front_image;
                    return $t;
                });
                break;
            case 'wisata':
                $query = $this->getActiveProductQuery(new WisataSpot);
                if ($destination)
                    $query->where('name', $destination);
                $tickets = $query->get()->map(function($t) {
                    $t->image = $t->image ?? $t->main_image;
                    return $t;
                });
                break;
            default:
                $tickets = [];
        }

        return response()->json([
            'tickets' => $tickets->map(function($t) {
                // Konversi model ke array agar kita bisa bebas menambah/mengubah data
                $item = $t->toArray();
                
                // Cari gambar dari berbagai kemungkinan kolom, pastikan yang diambil bukan string kosong
                $rawPath = '';
                $possibleColumns = ['image', 'main_image', 'front_image', 'airline_logo', 'logo'];
                
                foreach ($possibleColumns as $col) {
                    if (!empty($t->$col)) {
                        $rawPath = $t->$col;
                        break;
                    }
                }
                
                // Jika masih kosong, coba cek galeri atau train_images (untuk kereta)
                if (!$rawPath) {
                    if (!empty($t->train_images)) {
                        $imgs = is_string($t->train_images) ? json_decode($t->train_images, true) : $t->train_images;
                        $rawPath = $imgs[0] ?? '';
                    } elseif (!empty($t->gallery)) {
                        $imgs = is_string($t->gallery) ? json_decode($t->gallery, true) : $t->gallery;
                        $rawPath = $imgs[0] ?? '';
                    }
                }

                // Berikan link bersih ke property 'image' yang akan dibaca JavaScript
                $item['image'] = $rawPath;
                return $item;
            }),
            'category' => $category
        ]);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'item_id' => 'required',
            'passenger_count' => 'required|integer|min:1',
            'payment_method' => 'required',
        ]);

        $item = $this->getItem($request->category, $request->item_id);
        if (!$item)
            return response()->json(['error' => 'Item not found'], 404);

        // --- Validasi Batas Penumpang ---
        $category = $request->category;
        $passengerCount = $request->passenger_count;
        
        switch ($category) {
            case 'pesawat':
                if ($passengerCount > 7) {
                    return response()->json(['error' => 'Pemesanan tiket penerbangan maksimal 7 penumpang.'], 422);
                }
                break;
            case 'hotel':
                $roomCapacity = $item->room_capacity ?? $item->availability ?? 2;
                if ($passengerCount > $roomCapacity) {
                    return response()->json(['error' => "Jumlah tamu melebihi kapasitas kamar (maksimal $roomCapacity orang)."], 422);
                }
                break;
            case 'airport_transfer':
                if ($passengerCount > 4) {
                    return response()->json(['error' => 'Airport Transfer maksimal 4 penumpang.'], 422);
                }
                break;
            case 'rent_car':
            case 'car_rental':
                $carCapacity = $item->capacity ?? $item->seats_available ?? 4;
                if ($passengerCount > $carCapacity) {
                    return response()->json(['error' => "Jumlah penumpang melebihi kapasitas mobil (maksimal $carCapacity orang)."], 422);
                }
                break;
            case 'bus':
            case 'kereta':
            case 'train':
                $availableSeats = $item->seats_available ?? 0;
                if ($passengerCount > $availableSeats) {
                    return response()->json(['error' => "Jumlah penumpang melebihi kursi yang tersedia (sisa $availableSeats kursi)."], 422);
                }
                break;
        }
        $price = $item->price ?? $item->price_per_night;
        $discount = 0;
        $serviceFee = 10000;
        $baseTotal = $price * $request->passenger_count;
        if ($baseTotal > 50000) {
            $discount = 50000;
        }
        
        $total = $baseTotal + $serviceFee - $discount;

        $booking = \App\Models\Booking::create([
            'booking_code' => 'VYG-' . strtoupper(str()->random(8)),
            'category' => $request->category,
            'item_id' => $request->item_id,
            'user_id' => auth()->id(),
            'mitra_id' => $item->user_id,
            'passenger_count' => $request->passenger_count,
            'total_price' => $total,
            'payment_method' => $request->payment_method,
            'seats' => $request->seats,
            'status' => \App\Enums\BookingStatus::PENDING,
            'payment_status' => \App\Enums\PaymentStatus::PENDING,
        ]);

        $user = auth()->user();
        // Point removed from here, only added after actual payment (PAID status)

        // Midtrans Config
        Config::$serverKey = config('services.midtrans.server_key') ?: config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $itemDetails = [
            [
                'id' => (string) $booking->item_id,
                'price' => (int) $price,
                'quantity' => (int) $request->passenger_count,
                'name' => 'Tiket ' . ucfirst($request->category),
            ],
            [
                'id' => 'SERVICE-FEE',
                'price' => (int) $serviceFee,
                'quantity' => 1,
                'name' => 'Service Fee',
            ]
        ];

        if ($discount > 0) {
            $itemDetails[] = [
                'id' => 'DISCOUNT',
                'price' => -(int)$discount,
                'quantity' => 1,
                'name' => 'Voucher Discount',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $booking->booking_code,
                'gross_amount' => (int) $total,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone ?? '08111222333',
            ],
            'item_details' => $itemDetails,
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            $booking->update(['snap_token' => $snapToken]);

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'booking_code' => $booking->booking_code,
                'total_price' => $total,
                'awarded_points' => 10,
                'current_points' => $user->points,
                'current_badge' => $user->badge
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function simulatePayment(Request $request)
    {
        $request->validate(['booking_code' => 'required']);
        $booking = \App\Models\Booking::where('booking_code', $request->booking_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Calculate commission for the partner
        $partner = \App\Models\Partner::where('user_id', $booking->mitra_id)->first();
        $rate = $partner->commission_rate ?? 10; // Default 10% commission
        $basePrice = max(0, $booking->total_price - 10000); // 10k is Voyago service fee
        $commissionAmount = $basePrice * ($rate / 100);
        $netIncome = $basePrice - $commissionAmount;

        $booking->update([
            'status' => \App\Enums\BookingStatus::CONFIRMED,
            'payment_status' => \App\Enums\PaymentStatus::PAID,
            'commission_amount' => $commissionAmount,
            'net_income' => $netIncome,
        ]);

        // Award points on successful simulation
        $user = auth()->user();
        $user->points += 10;
        $user->updateBadge();
        $user->save();

        return response()->json(['success' => true]);
    }

    public function cancelBooking($id)
    {
        $booking = \App\Models\Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($booking->status === \App\Enums\BookingStatus::CANCELLED || $booking->status === \App\Enums\BookingStatus::COMPLETED) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        // Deduct points if it was paid
        if ($booking->payment_status === \App\Enums\PaymentStatus::PAID) {
            $user = auth()->user();
            $user->points = max(0, $user->points - 10);
            $user->updateBadge();
            $user->save();
            
            $booking->update([
                'status' => \App\Enums\BookingStatus::REFUNDED,
                'payment_status' => \App\Enums\PaymentStatus::REFUNDED,
            ]);
            
            return back()->with('success', 'Pesanan berhasil dibatalkan dan sedang diproses untuk refund.');
        }

        $booking->update([
            'status' => \App\Enums\BookingStatus::CANCELLED,
            'payment_status' => \App\Enums\PaymentStatus::FAILED,
        ]);

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    public function bookingPage()
    {
        $categories = Category::all();
        $tickets = $this->getActiveProductQuery(new TrainTicket)->get();
        return view('pemesanan', compact('categories', 'tickets'));
    }

    public function myBookings()
    {
        $bookings = \App\Models\Booking::where('user_id', auth()->id())->latest()->get();
        foreach ($bookings as $booking) {
            $booking->item = $this->getItem($booking->category, $booking->item_id);
        }
        return view('riwayat', compact('bookings'));
    }

    public function planningRoom()
    {
        $userId = auth()->id();
        $room = \App\Models\PlanningRoom::whereHas('members', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->first();

        // If no room exists, create a demo one for the user
        if (!$room) {
            $room = \App\Models\PlanningRoom::create([
                'user_id' => $userId,
                'title' => 'Rencana Liburan Impian',
                'destination' => 'Yogyakarta, Indonesia',
                'start_date' => '2026-06-12',
                'end_date' => '2026-06-15',
                'status' => 'planning'
            ]);

            \App\Models\PlanningRoomMember::create([
                'planning_room_id' => $room->id,
                'user_id' => $userId,
                'role' => 'creator'
            ]);

            // Add some demo items if it's the first time
            \App\Models\PlanningRoomItem::create([
                'planning_room_id' => $room->id,
                'category' => 'transport',
                'title' => 'Kereta Gajahwong',
                'subtitle' => 'Pasar Senen -> Lempuyangan',
                'price' => 250000,
                'image' => 'hero1.jpeg',
                'date_info' => '12 Jun 2026',
                'optional_stats' => '8h 20m'
            ]);
        }

        $room->load(['members.user', 'items.votes', 'comments.user']);

        $savedItems = [
            'transport' => $room->items->where('category', 'transport'),
            'hotel' => $room->items->where('category', 'hotel'),
            'wisata' => $room->items->where('category', 'wisata'),
        ];

        return view('planning-room', [
            'room' => [
                'id' => $room->id,
                'title' => $room->title,
                'date' => date('d M', strtotime($room->start_date)) . ' - ' . date('d M Y', strtotime($room->end_date)),
                'destination' => $room->destination,
                'status' => $room->status,
                'my_role' => $room->members->where('user_id', auth()->id())->first()->role ?? 'member',
                'members' => $room->members->map(function ($m) {
                    return [
                        'name' => $m->user->name,
                        'role' => ucfirst($m->role),
                        'image' => 'avatar1.jpeg' // placeholder
                    ];
                })
            ],
            'savedItems' => $savedItems,
            'comments' => $room->comments
        ]);
    }

    public function addItemToRoom(Request $request)
    {
        $room = \App\Models\PlanningRoom::where('user_id', auth()->id())->first();
        if (!$room)
            return response()->json(['error' => 'No room found'], 404);

        $item = \App\Models\PlanningRoomItem::create([
            'planning_room_id' => $room->id,
            'category' => $request->category,
            'product_id' => $request->product_id,
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'price' => $request->price,
            'image' => $request->image ?? 'pd-1.jpeg',
            'date_info' => $request->date_info,
            'optional_stats' => $request->optional_stats
        ]);

        return response()->json(['success' => true, 'item' => $item]);
    }

    public function voteRoomItem(Request $request, $itemId)
    {
        $vote = \App\Models\PlanningRoomVote::updateOrCreate(
            ['planning_room_item_id' => $itemId, 'user_id' => auth()->id()],
            ['type' => $request->type]
        );

        return response()->json(['success' => true]);
    }

    public function addCommentToRoom(Request $request, $roomId)
    {
        $comment = \App\Models\PlanningRoomComment::create([
            'planning_room_id' => $roomId,
            'user_id' => auth()->id(),
            'comment' => $request->comment
        ]);

        return response()->json(['success' => true, 'user' => auth()->user()->name]);
    }

    public function inviteMember(Request $request, $roomId)
    {
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User dengan email tersebut tidak ditemukan.'], 404);
        }

        $exists = \App\Models\PlanningRoomMember::where('planning_room_id', $roomId)
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            return response()->json(['error' => 'User sudah menjadi anggota room ini.'], 422);
        }

        \App\Models\PlanningRoomMember::create([
            'planning_room_id' => $roomId,
            'user_id' => $user->id,
            'role' => 'member'
        ]);

        return response()->json(['success' => true, 'name' => $user->name]);
    }

    public function storeComplaint(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'subject' => 'required|string|max:255',
            'category' => 'required|string',
            'description' => 'required|string'
        ]);

        $booking = \App\Models\Booking::findOrFail($request->booking_id);

        \App\Models\Complaint::create([
            'booking_id' => $request->booking_id,
            'user_id' => auth()->id(),
            'mitra_id' => $booking->mitra_id,
            'subject' => $request->subject,
            'category' => $request->category,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Komplain Anda berhasil dikirim dan akan segera diproses.');
    }

    public function myComplaints()
    {
        $complaints = \App\Models\Complaint::where('user_id', auth()->id())->with('booking')->latest()->get();
        return response()->json($complaints);
    }

    public function updateRoomTitle(Request $request, $roomId)
    {
        $room = \App\Models\PlanningRoom::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id());
        })->findOrFail($roomId);

        $request->validate(['title' => 'required|string|max:255']);
        $room->update(['title' => $request->title]);

        return response()->json(['success' => true]);
    }

    public function finalizePlan($roomId)
    {
        $room = \App\Models\PlanningRoom::whereHas('members', function ($q) {
            $q->where('user_id', auth()->id())->where('role', 'creator');
        })->findOrFail($roomId);

        $room->update(['status' => 'finalized']);

        return response()->json(['success' => true]);
    }

    public function deleteRoomItem($itemId)
    {
        $item = \App\Models\PlanningRoomItem::findOrFail($itemId);
        // Only creator or room owner can delete
        $room = $item->room;
        if ($room->user_id !== auth()->id()) {
            // Check if member is creator role
            $member = \App\Models\PlanningRoomMember::where('planning_room_id', $room->id)
                ->where('user_id', auth()->id())
                ->first();
            if (!$member || $member->role !== 'creator') {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
        }

        $item->delete();
        return response()->json(['success' => true]);
    }

    public function settings()
    {
        $paymentMethods = \App\Models\PaymentMethod::where('user_id', auth()->id())->get();
        return view('settings', compact('paymentMethods'));
    }

    public function storePaymentMethod(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'provider_name' => 'required|string',
            'number' => 'required|string',
            'holder_name' => 'required|string',
            'expiry_date' => 'nullable|string',
        ]);

        $isFirst = \App\Models\PaymentMethod::where('user_id', auth()->id())->count() === 0;

        \App\Models\PaymentMethod::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'provider_name' => $request->provider_name,
            'number' => $request->number,
            'holder_name' => $request->holder_name,
            'expiry_date' => $request->expiry_date,
            'is_default' => $isFirst,
        ]);

        return back()->with('success', 'Metode pembayaran berhasil ditambahkan!');
    }

    public function deletePaymentMethod($id)
    {
        $method = \App\Models\PaymentMethod::where('user_id', auth()->id())->findOrFail($id);
        $method->delete();

        // If deleted was default, set another one as default if exists
        if ($method->is_default) {
            $next = \App\Models\PaymentMethod::where('user_id', auth()->id())->first();
            if ($next) {
                $next->update(['is_default' => true]);
            }
        }

        return back()->with('success', 'Metode pembayaran berhasil dihapus!');
    }

    public function setDefaultPaymentMethod($id)
    {
        \App\Models\PaymentMethod::where('user_id', auth()->id())->update(['is_default' => false]);
        \App\Models\PaymentMethod::where('user_id', auth()->id())->where('id', $id)->update(['is_default' => true]);

        return back()->with('success', 'Metode pembayaran utama berhasil diperbarui!');
    }

    public function profile()
    {
        $userId = auth()->id();

        // Calculate real stats
        $stats = [
            'total_trips' => \App\Models\Booking::where('user_id', $userId)->where('payment_status', 'paid')->count(),
            'destinations' => \App\Models\Booking::where('user_id', $userId)->distinct('item_id')->count(), // Simplified
            'planning_rooms' => \App\Models\PlanningRoomMember::where('user_id', $userId)->count(),
            'wishlist' => 0 // Future implementation
        ];

        // Fetch real activities (bookings)
        $realBookings = \App\Models\Booking::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($b) {
                $icons = [
                    'kereta' => 'fa-train',
                    'pesawat' => 'fa-plane',
                    'bus' => 'fa-bus',
                    'hotel' => 'fa-hotel',
                    'wisata' => 'fa-mountain-sun'
                ];
                return [
                    'type' => 'booking',
                    'title' => 'Pemesanan ' . ucfirst($b->category),
                    'date' => $b->created_at->diffForHumans(),
                    'status' => $b->status === \App\Enums\BookingStatus::CONFIRMED ? 'Terkonfirmasi' : ucfirst($b->status->value),
                    'icon' => $icons[$b->category] ?? 'fa-receipt',
                    'raw' => $b // Pass raw object for JS details
                ];
            })->toArray();

        return view('profile', [
            'stats' => $stats,
            'activities' => $realBookings
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'address']);

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/avatars'), $filename);
            $data['avatar'] = 'uploads/avatars/' . $filename;
        }

        $user->update($data);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function deleteAccount(Request $request)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $userId = $user->id;

        try {
            // Delete related potentially unconstrained data manually
            \App\Models\Booking::where('user_id', $userId)->delete();
            \App\Models\User::where('id', $userId)->delete();

            // Clear authentication and session
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/')->with('success', 'Selamat tinggal! Akun Anda telah dihapus secara permanen.');
        } catch (\Exception $e) {
            return redirect('/settings')->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    private function getItem($category, $id)
    {
        switch ($category) {
            case 'kereta':
                return TrainTicket::find($id);
            case 'pesawat':
                return FlightTicket::find($id);
            case 'bus':
                return BusTicket::find($id);
            case 'hotel':
                return Hotel::find($id);
            case 'wisata':
                return WisataSpot::find($id);
        }
    }
    public function getBookedSeats(Request $request)
    {
        $category = $request->query('category');
        $itemId = $request->query('item_id');

        $bookedSeats = \App\Models\Booking::where('category', $category)
            ->where('item_id', $itemId)
            ->whereNotIn('status', [\App\Enums\BookingStatus::CANCELLED])
            ->pluck('seats')
            ->flatten()
            ->unique()
            ->values();

        return response()->json($bookedSeats);
    }

    public function downloadTicket($id)
    {
        $booking = \App\Models\Booking::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('payment_status', \App\Enums\PaymentStatus::PAID)
            ->firstOrFail();

        $booking->item = $this->getItem($booking->category, $booking->item_id);

        $pdf = Pdf::loadView('ticket_pdf', compact('booking'));
        return $pdf->download('E-Ticket-' . $booking->booking_code . '.pdf');
    }
}
