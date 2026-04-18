<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function toggle(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Silakan login terlebih dahulu.'], 401);
        }

        $request->validate([
            'id' => 'required',
            'type' => 'required'
        ]);

        $userId = Auth::id();
        $itemId = $request->id;
        $type = $request->type;

        // Map short names to full model names
        $modelMap = [
            'wisata' => 'App\Models\WisataSpot',
            'hotel' => 'App\Models\Hotel',
            'pesawat' => 'App\Models\FlightTicket',
            'kereta' => 'App\Models\TrainTicket',
            'bus' => 'App\Models\BusTicket',
        ];

        $modelClass = $modelMap[$type] ?? $type;

        $wishlist = Wishlist::where('user_id', $userId)
            ->where('wishlistable_id', $itemId)
            ->where('wishlistable_type', $modelClass)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Berhasil dihapus dari wishlist.'
            ]);
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'wishlistable_id' => $itemId,
                'wishlistable_type' => $modelClass
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Berhasil ditambahkan ke wishlist.'
            ]);
        }
    }
}
