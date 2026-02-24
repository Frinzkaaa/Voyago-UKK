<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\TrainTicket;
use App\Models\FlightTicket;
use App\Models\BusTicket;
use App\Models\Hotel;
use App\Models\WisataSpot;

class TicketController extends Controller
{
    private function getActiveProductQuery($model)
    {
        return $model::query()
            ->join('users', 'users.id', '=', $model->getTable() . '.user_id')
            ->join('partners', 'partners.user_id', '=', 'users.id')
            ->where($model->getTable() . '.status', 'active')
            ->where('partners.status', 'verified')
            ->select($model->getTable() . '.*');
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

        return view('beranda', compact('categories', 'tickets', 'recentBookings'));
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
            case 'wisata':
                $destinations = ($category === 'hotel') ? Hotel::distinct()->pluck('location') : WisataSpot::distinct()->pluck('location');
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
                $tickets = $query->get();
                break;
            case 'pesawat':
                $query = $this->getActiveProductQuery(new FlightTicket);
                if ($origin)
                    $query->where('origin', $origin);
                if ($destination)
                    $query->where('destination', $destination);
                if ($date)
                    $query->whereDate('departure_time', $date);
                if ($class && $class !== 'All')
                    $query->where('class', 'LIKE', "%$class%");
                $tickets = $query->get();
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
                $tickets = $query->get();
                break;
            case 'wisata':
                $query = $this->getActiveProductQuery(new WisataSpot);
                if ($destination)
                    $query->where('location', $destination);
                $tickets = $query->get();
                break;
            default:
                $tickets = [];
        }

        return response()->json([
            'tickets' => $tickets,
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

        // Limit check: Max 4 active/pending tickets per user
        $activeBookingsCount = \App\Models\Booking::where('user_id', auth()->id())
            ->whereNotIn('status', [\App\Enums\BookingStatus::CANCELLED])
            ->count();

        if ($activeBookingsCount >= 4) {
            return response()->json(['error' => 'Batas maksimal pemesanan adalah 4 tiket per user.'], 403);
        }

        $price = $item->price ?? $item->price_per_night;
        $total = ($price * $request->passenger_count) + 10000; // Service fee

        $booking = \App\Models\Booking::create([
            'booking_code' => 'VYG-' . strtoupper(str()->random(8)),
            'category' => $request->category,
            'item_id' => $request->item_id,
            'user_id' => auth()->id(),
            'mitra_id' => $item->user_id,
            'passenger_count' => $request->passenger_count,
            'total_price' => $total,
            'payment_method' => $request->payment_method,
            'status' => \App\Enums\BookingStatus::PENDING,
            'payment_status' => \App\Enums\PaymentStatus::PENDING,
        ]);

        // Award Points and update Badge
        $user = auth()->user();
        $user->points += 10;
        $user->updateBadge();
        $user->save();

        return response()->json([
            'success' => true,
            'booking_code' => $booking->booking_code,
            'awarded_points' => 10,
            'current_points' => $user->points,
            'current_badge' => $user->badge
        ]);
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
}
