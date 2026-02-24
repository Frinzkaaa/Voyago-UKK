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
        $totalRevenue = Booking::where('mitra_id', Auth::id())->where('status', BookingStatus::CONFIRMED)->sum('total_price');
        $totalCommission = Booking::where('mitra_id', Auth::id())->where('status', BookingStatus::CONFIRMED)->sum('commission_amount');

        return view('mitra.dashboard', compact('totalProducts', 'totalOrders', 'totalRevenue', 'totalCommission'));
    }

    public function products()
    {
        $serviceType = Auth::user()->partner->service_type ?? 'Lainnya';

        $type = 'wisata';
        if (str_contains($serviceType, 'Hotel') || str_contains($serviceType, 'Akomodasi'))
            $type = 'hotel';
        elseif (str_contains($serviceType, 'Pesawat') || str_contains($serviceType, 'Maskapai'))
            $type = 'pesawat';
        elseif (str_contains($serviceType, 'Kereta'))
            $type = 'kereta';
        elseif (str_contains($serviceType, 'Bus'))
            $type = 'bus';
        elseif (str_contains($serviceType, 'Wisata') || str_contains($serviceType, 'Hiburan'))
            $type = 'wisata';

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

        $type = 'wisata';
        if (str_contains($serviceType, 'Hotel') || str_contains($serviceType, 'Akomodasi'))
            $type = 'hotel';
        elseif (str_contains($serviceType, 'Pesawat') || str_contains($serviceType, 'Maskapai'))
            $type = 'pesawat';
        elseif (str_contains($serviceType, 'Kereta'))
            $type = 'kereta';
        elseif (str_contains($serviceType, 'Bus'))
            $type = 'bus';
        elseif (str_contains($serviceType, 'Wisata') || str_contains($serviceType, 'Hiburan'))
            $type = 'wisata';

        return view('mitra.products.create', compact('type'));
    }

    public function storeProduct(Request $request)
    {
        if (Auth::user()->status !== UserStatus::ACTIVE) {
            abort(403, 'Unauthorized. Partner not verified.');
        }

        // Determine Product Type
        $serviceType = Auth::user()->partner->service_type ?? 'Lainnya';
        $type = 'wisata';
        if (str_contains($serviceType, 'Hotel') || str_contains($serviceType, 'Akomodasi'))
            $type = 'hotel';
        elseif (str_contains($serviceType, 'Pesawat') || str_contains($serviceType, 'Maskapai'))
            $type = 'pesawat';
        elseif (str_contains($serviceType, 'Kereta'))
            $type = 'kereta';
        elseif (str_contains($serviceType, 'Bus'))
            $type = 'bus';

        // Validation
        $rules = [
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quota' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,webp|max:2048',
        ];

        // Category-specific validation
        if ($type == 'pesawat') {
            $rules['airline_logo'] = 'required|image|mimes:jpeg,png,webp|max:2048';
            $rules['interior_images.*'] = 'nullable|image|mimes:jpeg,png,webp|max:2048';
        } elseif ($type == 'hotel') {
            $rules['front_image'] = 'required|image|mimes:jpeg,png,webp|max:2048';
            $rules['room_images'] = 'required|array|min:1';
            $rules['room_images.*'] = 'image|mimes:jpeg,png,webp|max:2048';
        } elseif ($type == 'kereta') {
            $rules['train_images'] = 'required|array|min:1';
            $rules['train_images.*'] = 'image|mimes:jpeg,png,webp|max:2048';
        }

        $request->validate($rules);

        // Upload Common Media
        $imagePath = $this->uploadMedia($request, 'image', "products/{$type}/thumbnails");
        $galleryPaths = $this->uploadMedia($request, 'gallery', "products/{$type}/gallery", true);

        $commonData = [
            'user_id' => Auth::id(),
            'status' => ProductStatus::PENDING_REVIEW,
            'image' => $imagePath,
            'gallery' => $galleryPaths,
            'is_active' => false,
        ];

        switch ($type) {
            case 'hotel':
                Hotel::create(array_merge($commonData, [
                    'name' => $request->name,
                    'location' => $request->location,
                    'rating' => 5.0,
                    'price_per_night' => $request->price,
                    'room_type' => $request->room_type ?? 'Standard',
                    'availability' => $request->quota,
                    'front_image' => $this->uploadMedia($request, 'front_image', "products/hotel/front"),
                    'room_images' => $this->uploadMedia($request, 'room_images', "products/hotel/rooms", true),
                    'facility_images' => $this->uploadMedia($request, 'facility_images', "products/hotel/facilities", true),
                ]));
                break;

            case 'pesawat':
                FlightTicket::create(array_merge($commonData, [
                    'airline_name' => $request->name,
                    'flight_code' => $request->code,
                    'origin' => $request->origin,
                    'destination' => $request->destination,
                    'departure_time' => $request->departure_time,
                    'arrival_time' => $request->arrival_time ?? $request->departure_time,
                    'duration' => $request->duration ?? '0j',
                    'baggage_info' => '20kg',
                    'price' => $request->price,
                    'seats_available' => $request->quota,
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
                    'seats_available' => $request->quota,
                    'class' => $request->class ?? 'Economy',
                    'train_images' => $this->uploadMedia($request, 'train_images', "products/kereta/exterior", true),
                    'seat_images' => $this->uploadMedia($request, 'seat_images', "products/kereta/interior", true),
                ]));
                break;

            case 'bus':
                BusTicket::create(array_merge($commonData, [
                    'operator' => $request->name,
                    'origin_terminal' => $request->origin,
                    'destination_terminal' => $request->destination,
                    'departure_time' => $request->departure_time,
                    'price' => $request->price,
                    'seats_available' => $request->quota,
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
                    'availability' => $request->quota,
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
                $paths[] = $file->store($path, 'public');
            }
            return $paths;
        }

        return $request->file($field)->store($path, 'public');
    }

    public function editProduct($id)
    {
        $product = WisataSpot::findOrFail($id);
        Gate::authorize('update', $product);

        return view('mitra.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = WisataSpot::findOrFail($id);
        Gate::authorize('update', $product);

        $product->update([
            'name' => $request->name,
            'category' => $request->category,
            'location' => $request->location,
            'description' => $request->description,
            'price' => $request->price,
            'availability' => $request->quota,
            'status' => ProductStatus::PENDING_REVIEW, // Re-verify on update
        ]);

        return redirect()->route('partner.products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function deleteProduct($id)
    {
        $product = WisataSpot::findOrFail($id);
        Gate::authorize('update', $product); // Use update policy as deletion right

        $product->delete();
        return redirect()->route('partner.products')->with('success', 'Produk berhasil dihapus.');
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
        $orders = Booking::where('mitra_id', Auth::id())->where('status', BookingStatus::CONFIRMED)->get();
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
}
