<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\WisataSpot;
use App\Models\Hotel;
use App\Models\FlightTicket;
use App\Models\TrainTicket;
use App\Models\BusTicket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Enums\ProductStatus;
use App\Enums\BookingStatus;

class MitraController extends Controller
{
    public function authPage()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role === UserRole::ADMIN)
                return redirect()->route('admin.dashboard');
            if ($user->role === UserRole::PARTNER) {
                if ($user->status === UserStatus::PENDING)
                    return redirect()->route('partner.auth.verification');
                return redirect()->route('partner.dashboard');
            }
        }
        return view('mitra.auth');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'service_type' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Plain text as requested
            'role' => UserRole::PARTNER,
            'status' => UserStatus::PENDING, // Menunggu Verifikasi
        ]);

        \App\Models\Partner::create([
            'user_id' => $user->id,
            'status' => \App\Enums\PartnerStatus::PENDING,
            'service_type' => $request->service_type,
        ]);

        Auth::login($user);

        return redirect()->route('partner.auth.verification');
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->password === $request->password) {
            Auth::login($user);

            if ($user->role !== UserRole::PARTNER && $user->role !== UserRole::ADMIN) {
                Auth::logout();
                return back()->withErrors(['email' => 'Akses ditolak. Anda bukan Partner.']);
            }

            if ($user->status === UserStatus::PENDING || $user->status === UserStatus::REJECTED) {
                return redirect()->route('partner.auth.verification');
            }

            if ($user->role === UserRole::ADMIN) {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('partner.dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah.']);
    }

    public function verificationStatus()
    {
        if (Auth::check() && Auth::user()->status === UserStatus::ACTIVE) {
            return redirect()->route('partner.dashboard')->with('success', 'Selamat! Akun Anda telah aktif.');
        }
        return view('mitra.verification');
    }

    public function dashboard()
    {
        // Calculate total products across all tables for this user
        $totalProducts = TrainTicket::where('user_id', Auth::id())->count() +
            FlightTicket::where('user_id', Auth::id())->count() +
            BusTicket::where('user_id', Auth::id())->count() +
            Hotel::where('user_id', Auth::id())->count() +
            WisataSpot::where('user_id', Auth::id())->count();

        $totalOrders = Booking::where('mitra_id', Auth::id())->count();
        
        // Revenue should be based on PAID status or successful work statuses
        $paidStatuses = [\App\Enums\PaymentStatus::PAID];
        $workStatuses = [\App\Enums\BookingStatus::CONFIRMED, \App\Enums\BookingStatus::COMPLETED];

        $totalRevenue = Booking::where('mitra_id', Auth::id())
            ->whereIn('payment_status', $paidStatuses)
            ->sum('total_price');

        $totalCommission = Booking::where('mitra_id', Auth::id())
            ->whereIn('payment_status', $paidStatuses)
            ->sum('commission_amount');

        $recentOrders = Booking::where('mitra_id', Auth::id())
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        // Dynamic Chart Data (Last 6 Months)
        $chartLabels = [];
        $chartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $chartLabels[] = $month->format('M');
            $chartData[] = Booking::where('mitra_id', Auth::id())
                ->whereIn('payment_status', $paidStatuses)
                ->whereMonth('created_at', $month->month)
                ->whereYear('created_at', $month->year)
                ->sum('total_price');
        }

        return view('mitra.dashboard', compact(
            'totalProducts', 
            'totalOrders', 
            'totalRevenue', 
            'totalCommission', 
            'recentOrders',
            'chartLabels',
            'chartData'
        ));
    }

    public function products()
    {
        $serviceType = Auth::user()->partner->service_type ?? 'Lainnya';
        $type = $this->resolveProductType($serviceType);

        $products = match ($type) {
            'hotel' => Hotel::where('user_id', Auth::id())->get(),
            'pesawat' => FlightTicket::where('user_id', Auth::id())->get(),
            'kereta' => TrainTicket::where('user_id', Auth::id())->get(),
            'bus' => BusTicket::where('user_id', Auth::id())->get(),
            default => WisataSpot::where('user_id', Auth::id())->get(),
        };

        return view('mitra.products.index', compact('products', 'type'));
    }

    public function createProduct()
    {
        if (Auth::user()->status !== UserStatus::ACTIVE) {
            return redirect()->route('partner.auth.verification')->with('error', 'Akun Anda harus diverifikasi oleh admin sebelum dapat membuat produk.');
        }

        $serviceType = Auth::user()->partner->service_type ?? 'Lainnya';
        $type = $this->resolveProductType($serviceType);

        return view('mitra.products.create', compact('type'));
    }

    public function storeProduct(Request $request)
    {
        if (Auth::user()->status !== UserStatus::ACTIVE) {
            abort(403, 'Unauthorized. Partner not verified.');
        }

        // Determine Product Type
        $serviceType = Auth::user()->partner->service_type ?? 'Lainnya';
        $type = $this->resolveProductType($serviceType);

        // Common Validation
        $rules = [
            'image' => ($type == 'pesawat' || $type == 'kereta') ? 'nullable' : 'required|image|mimes:jpeg,png,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];

        if ($type == 'pesawat') {
            $rules['airline_name'] = 'required|string|max:255';
            $rules['flight_code'] = 'required|string|max:255';
            $rules['origin'] = 'required|string';
            $rules['destination'] = 'required|string';
            $rules['baggage_info'] = 'required|string';
        } elseif ($type == 'hotel') {
            $rules['name'] = 'required|string|max:255';
            $rules['front_image'] = 'required|image|mimes:jpeg,png,webp|max:2048';
            $rules['room_images'] = 'required|array|min:1';
            $rules['room_images.*'] = 'image|mimes:jpeg,png,webp|max:2048';
        } else {
            if ($type == 'bus') {
                $rules['operator'] = 'required|string|max:255';
            } elseif ($type == 'kereta') {
                $rules['name'] = 'required|string|max:255';
                $rules['code'] = 'required|string|max:255';
            } else {
                $rules['name'] = 'required|string|max:255';
            }
        }

        $request->validate($rules);

        // Upload Common Media
        $imagePath = $this->uploadMedia($request, 'image', "products/{$type}/thumbnails");
        $galleryPaths = $this->uploadMedia($request, 'gallery', "products/{$type}/gallery", true);

        $commonData = [
            'user_id' => Auth::id(),
            'status' => ProductStatus::ACTIVE,
            'image' => $imagePath,
            'gallery' => $galleryPaths,
            'is_active' => true,
        ];

        switch ($type) {
            case 'hotel':
                Hotel::create(array_merge($commonData, [
                    'name' => $request->name,
                    'location' => $request->location,
                    'rating' => 5.0,
                    'price_per_night' => $request->price,
                    'room_type' => $request->room_type ?? 'Standard',
                    'availability' => $request->stock,
                    'front_image' => $this->uploadMedia($request, 'front_image', "products/hotel/front"),
                    'room_images' => $this->uploadMedia($request, 'room_images', "products/hotel/rooms", true),
                    'facility_images' => $this->uploadMedia($request, 'facility_images', "products/hotel/facilities", true),
                ]));
                break;

            case 'pesawat':
                FlightTicket::create(array_merge($commonData, [
                    'airline_name' => $request->airline_name,
                    'flight_code' => $request->flight_code,
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'departure_time' => $request->departure_time,
                    'arrival_time' => $request->arrival_time ?? $request->departure_time,
                    'duration' => $request->duration ?? '0j',
                    'baggage_info' => $request->baggage_info,
                    'price' => $request->price,
                    'seats_available' => $request->stock,
                    'class' => $request->class ?? 'Economy',
                    'airline_logo' => $this->uploadMedia($request, 'airline_logo', "products/pesawat/logos"),
                    'interior_images' => $this->uploadMedia($request, 'interior_images', "products/pesawat/interior", true),
                ]));
                break;

            case 'kereta':
                TrainTicket::create(array_merge($commonData, [
                    'name' => $request->name,
                    'code' => $request->code,
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'departure_time' => $request->departure_time,
                    'arrival_time' => $request->arrival_time ?? $request->departure_time,
                    'duration' => $request->duration ?? '0j',
                    'price' => $request->price,
                    'seats_available' => $request->stock,
                    'class' => $request->class ?? 'Economy',
                    'train_images' => $this->uploadMedia($request, 'train_images', "products/kereta/exterior", true),
                    'seat_images' => $this->uploadMedia($request, 'seat_images', "products/kereta/interior", true),
                ]));
                break;

            case 'bus':
                BusTicket::create(array_merge($commonData, [
                    'operator' => $request->operator,
                    'origin_terminal' => $request->origin_terminal,
                    'destination_terminal' => $request->destination_terminal,
                    'departure_time' => $request->departure_time,
                    'arrival_time' => $request->arrival_time ?? $request->departure_time,
                    'duration' => $request->duration ?? '0j',
                    'price' => $request->price,
                    'seats_available' => $request->stock,
                    'seat_type' => $request->class ?? 'Standard',
                ]));
                break;

            case 'wisata':
            default:
                WisataSpot::create(array_merge($commonData, [
                    'name' => $request->name,
                    'category' => $request->category ?? 'Wisata',
                    'location' => $request->location,
                    'description' => $request->description ?? '-',
                    'price' => $request->price,
                    'availability' => $request->stock,
                    'open_hours' => '08:00 - 17:00',
                    'main_image' => $this->uploadMedia($request, 'main_image', "products/wisata/main"),
                    'spot_images' => $this->uploadMedia($request, 'spot_images', "products/wisata/spots", true),
                    'package_images' => $this->uploadMedia($request, 'package_images', "products/wisata/packages", true),
                ]));
                break;
        }

        return redirect()->route('partner.products')->with('success', 'Produk berhasil ditambahkan dan sedang menunggu peninjauan admin.');
    }

    /**
     * Helper to handle image uploads
     */
    private function uploadMedia($request, $field, $path, $isMultiple = false)
    {
        if (!$request->hasFile($field))
            return null;

        if ($isMultiple) {
            $paths = [];
            foreach ($request->file($field) as $file) {
                // Simpan ke 'public' disk, bersihkan path agar konsisten
                $storedPath = $file->store($path, 'public');
                $paths[] = str_replace('public/', '', $storedPath);
            }
            return json_encode($paths); // Simpan sebagai JSON string agar aman di DB
        }

        $storedPath = $request->file($field)->store($path, 'public');
        return str_replace('public/', '', $storedPath);
    }

    public function editProduct($id)
    {
        [$product, $type] = $this->findManagedProductOrFail($id);

        return view('mitra.products.edit', compact('product', 'type'));
    }

    public function updateProduct(Request $request, $id)
    {
        [$product, $type] = $this->findManagedProductOrFail($id);

        $data = [
            'status' => ProductStatus::PENDING_REVIEW, // Re-verify on update
        ];

        if ($type == 'pesawat') {
            $data = array_merge($data, [
                'airline_name' => $request->airline_name,
                'flight_code' => $request->flight_code,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'departure_time' => $request->departure_time,
                'arrival_time' => $request->arrival_time ?? $request->departure_time,
                'duration' => $request->duration,
                'baggage_info' => $request->baggage_info ?? '20kg',
                'price' => $request->price,
                'seats_available' => $request->stock,
                'class' => $request->class ?? 'Economy',
            ]);
        } elseif ($type == 'hotel') {
            $data = array_merge($data, [
                'name' => $request->name,
                'location' => $request->location,
                'price_per_night' => $request->price,
                'room_type' => $request->room_type,
                'availability' => $request->stock,
                'description' => $request->description,
            ]);
        } elseif ($type == 'kereta') {
            $data = array_merge($data, [
                'name' => $request->name,
                'code' => $request->code,
                'origin' => $request->origin,
                'destination' => $request->destination,
                'departure_time' => $request->departure_time,
                'arrival_time' => $request->arrival_time ?? $request->departure_time,
                'duration' => $request->duration,
                'price' => $request->price,
                'seats_available' => $request->stock,
                'class' => $request->class ?? 'Economy',
            ]);
        } elseif ($type == 'bus') {
            $data = array_merge($data, [
                'operator' => $request->operator,
                'origin_terminal' => $request->origin_terminal,
                'destination_terminal' => $request->destination_terminal,
                'departure_time' => $request->departure_time,
                'arrival_time' => $request->arrival_time ?? $request->departure_time,
                'duration' => $request->duration,
                'price' => $request->price,
                'seats_available' => $request->stock,
            ]);
        } else {
            $data = array_merge($data, [
                'name' => $request->name,
                'category' => $request->category,
                'location' => $request->location,
                'description' => $request->description,
                'price' => $request->price,
                'availability' => $request->stock,
            ]);
        }

        // Handle Image Updates
        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadMedia($request, 'image', "products/{$type}/thumbnails");
        }
        if ($request->hasFile('gallery')) {
            $data['gallery'] = $this->uploadMedia($request, 'gallery', "products/{$type}/gallery", true);
        }

        if ($type == 'pesawat') {
            if ($request->hasFile('airline_logo')) {
                $data['airline_logo'] = $this->uploadMedia($request, 'airline_logo', "products/pesawat/logos");
            }
            if ($request->hasFile('interior_images')) {
                $data['interior_images'] = $this->uploadMedia($request, 'interior_images', "products/pesawat/interior", true);
            }
        } elseif ($type == 'hotel') {
            if ($request->hasFile('front_image')) {
                $data['front_image'] = $this->uploadMedia($request, 'front_image', "products/hotel/front");
            }
            if ($request->hasFile('room_images')) {
                $data['room_images'] = $this->uploadMedia($request, 'room_images', "products/hotel/rooms", true);
            }
        } elseif ($type == 'kereta') {
            if ($request->hasFile('train_images')) {
                $data['train_images'] = $this->uploadMedia($request, 'train_images', "products/kereta/exterior", true);
            }
        } elseif ($type == 'wisata') {
            if ($request->hasFile('main_image')) {
                $data['main_image'] = $this->uploadMedia($request, 'main_image', "products/wisata/main");
            }
        }

        $product->update($data);

        return redirect()->route('partner.products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function toggleProductStatus($id)
    {
        [$product] = $this->findManagedProductOrFail($id);

        $product->is_active = !($product->is_active);
        $product->save();

        return back()->with('success', 'Status ketersediaan produk berhasil diperbarui.');
    }

    public function deleteProduct($id)
    {
        [$product] = $this->findManagedProductOrFail($id);

        $product->delete();
        return redirect()->route('partner.products')->with('success', 'Produk berhasil dihapus dari katalog.');
    }

    public function orders()
    {
        $orders = Booking::where('mitra_id', Auth::id())->get();
        return view('mitra.orders.index', compact('orders'));
    }

    public function confirmOrder($id)
    {
        $booking = Booking::findOrFail($id);
        Gate::authorize('confirm', $booking);

        $booking->status = BookingStatus::CONFIRMED;
        $booking->confirmed_at = now();

        // Commission logic from config
        $commissionRate = Auth::user()->partner->commission_rate ?? config('voyago.default_commission', 10);
        $booking->commission_amount = $booking->total_price * ($commissionRate / 100);
        $booking->net_income = $booking->total_price - $booking->commission_amount;
        $booking->save();

        return back()->with('success', 'Pesanan berhasil dikonfirmasi.');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        Gate::authorize('confirm', $booking); // Reuse confirm permission as update permission

        $request->validate([
            'status' => 'required'
        ]);

        $booking->status = $request->status;
        $booking->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function reports()
    {
        $orders = Booking::where('mitra_id', Auth::id())
            ->where('payment_status', \App\Enums\PaymentStatus::PAID)
            ->latest()
            ->get();
        return view('mitra.reports', compact('orders'));
    }

    public function settings()
    {
        return view('mitra.settings');
    }

    public function complaints()
    {
        $complaints = \App\Models\Complaint::with(['user', 'booking'])
            ->where('mitra_id', Auth::id())
            ->where('is_forwarded', true)
            ->latest()
            ->get();
        return view('mitra.complaints', compact('complaints'));
    }

    public function respondToComplaint(Request $request, $id)
    {
        $request->validate(['response' => 'required|string']);
        $complaint = \App\Models\Complaint::where('mitra_id', Auth::id())
            ->where('is_forwarded', true)
            ->findOrFail($id);

        $complaint->update([
            'mitra_response' => $request->response,
            'status' => 'in_progress' // Keep it in progress or set to something else
        ]);

        return back()->with('success', 'Tanggapan Anda telah dikirim ke admin.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('partner.auth.page');
    }

    /**
     * Product IDs can overlap across tables, so we can't trust service_type alone.
     */
    private function findManagedProductOrFail($id): array
    {
        $preferredType = $this->resolveProductType(Auth::user()->partner->service_type ?? 'Lainnya');
        $orderedTypes = array_values(array_unique(array_merge([$preferredType], array_keys($this->productModelMap()))));
        $firstExistingProduct = null;

        foreach ($orderedTypes as $type) {
            $modelClass = $this->productModelMap()[$type];
            $product = $modelClass::find($id);

            if (!$product) {
                continue;
            }

            $firstExistingProduct ??= $product;

            if (Gate::allows('update', $product)) {
                return [$product, $type];
            }
        }

        if ($firstExistingProduct) {
            abort(403);
        }

        abort(404);
    }

    private function productModelMap(): array
    {
        return [
            'hotel' => Hotel::class,
            'pesawat' => FlightTicket::class,
            'kereta' => TrainTicket::class,
            'bus' => BusTicket::class,
            'wisata' => WisataSpot::class,
        ];
    }

    /**
     * Resolve user's service type into internal product type slug
     */
    private function resolveProductType($serviceType)
    {
        $serviceType = strtolower(trim($serviceType));
        
        if (str_contains($serviceType, 'hotel') || str_contains($serviceType, 'akomodasi') || str_contains($serviceType, 'stay')) {
            return 'hotel';
        }
        if (str_contains($serviceType, 'pesawat') || str_contains($serviceType, 'maskapai') || str_contains($serviceType, 'flight')) {
            return 'pesawat';
        }
        if (str_contains($serviceType, 'kereta') || str_contains($serviceType, 'train')) {
            return 'kereta';
        }
        if (str_contains($serviceType, 'bus')) {
            return 'bus';
        }
        
        return 'wisata';
    }
}
