<?php

namespace App\Services;

use App\Models\User;
use App\Models\Partner;
use App\Models\Booking;
use App\Models\WisataSpot;
use App\Models\Hotel;
use App\Models\FlightTicket;
use App\Models\TrainTicket;
use App\Models\BusTicket;
use App\Models\ActivityLog;
use App\Models\BookingLog;
use Illuminate\Support\Facades\DB;
use App\Enums\UserRole;
use App\Enums\UserStatus;
use App\Enums\PartnerStatus;
use App\Enums\ProductStatus;
use App\Enums\BookingStatus;
use App\Enums\PaymentStatus;

class AdminService
{
    /**
     * Get platform statistics for admin dashboard.
     */
    public function getPlatformStats()
    {
        $totalUsers = User::where('role', UserRole::USER)->count();
        $totalPartners = User::where('role', UserRole::PARTNER)->count();

        $totalActiveProducts =
            WisataSpot::where('status', ProductStatus::ACTIVE)->count() +
            Hotel::where('status', ProductStatus::ACTIVE)->count() +
            FlightTicket::where('status', ProductStatus::ACTIVE)->count() +
            TrainTicket::where('status', ProductStatus::ACTIVE)->count() +
            BusTicket::where('status', ProductStatus::ACTIVE)->count();

        $totalBookings = Booking::count();
        $totalPlatformRevenue = Booking::where('payment_status', PaymentStatus::PAID)->sum('total_price');
        $totalCommissionEarned = Booking::where('payment_status', PaymentStatus::PAID)->sum('commission_amount');

        return [
            'total_users' => $totalUsers,
            'total_partners' => $totalPartners,
            'total_active_products' => $totalActiveProducts,
            'total_bookings' => $totalBookings,
            'total_platform_revenue' => $totalPlatformRevenue,
            'total_commission_earned' => $totalCommissionEarned,
        ];
    }

    /**
     * Get all bookings.
     */
    public function getAllBookings()
    {
        return Booking::with(['user', 'partner'])->latest()->get();
    }

    /**
     * Get activity logs.
     */
    public function getActivityLogs()
    {
        return ActivityLog::with('user')->latest()->get();
    }

    /**
     * Verify or Reject a Partner.
     */
    public function updatePartnerStatus($userId, $status, $reason = null)
    {
        return DB::transaction(function () use ($userId, $status, $reason) {
            $user = User::findOrFail($userId);

            if ($status === 'verified') {
                $user->status = UserStatus::ACTIVE;
            } elseif ($status === 'suspended') {
                $user->status = UserStatus::SUSPENDED;
            } elseif ($status === 'rejected') {
                $user->status = UserStatus::REJECTED;
            }

            $user->save();

            $partnerStatus = match ($status) {
                'verified' => PartnerStatus::VERIFIED,
                'rejected' => PartnerStatus::REJECTED,
                'suspended' => PartnerStatus::SUSPENDED,
                default => PartnerStatus::PENDING,
            };

            $partner = Partner::updateOrCreate(
                ['user_id' => $userId],
                ['status' => $partnerStatus, 'rejection_reason' => $reason]
            );

            // If suspended, deactivate products
            if ($status === 'suspended') {
                $this->deactivatePartnerProducts($userId);
            }

            // Log activity
            $this->logActivity(auth()->id(), "partner_status_updated", "Partner", $userId, "Status: $status. Reason: $reason");

            return $partner;
        });
    }

    /**
     * Approve or Reject a Product.
     */
    public function updateProductStatus($category, $productId, $status, $reason = null)
    {
        $model = $this->getProductModel($category);
        $product = $model::findOrFail($productId);

        $newStatus = match ($status) {
            'active' => ProductStatus::ACTIVE,
            'rejected' => ProductStatus::REJECTED,
            'pending_review' => ProductStatus::PENDING_REVIEW,
            default => ProductStatus::DRAFT,
        };

        $previousStatus = $product->status;
        $product->status = $newStatus;
        if (isset($product->is_active)) {
            $product->is_active = ($newStatus === ProductStatus::ACTIVE);
        }
        $product->save();

        $this->logActivity(auth()->id(), "product_status_updated", ucfirst($category), $productId, "Status changed from {$previousStatus->value} to {$newStatus->value}. Reason: $reason");

        return $product;
    }

    /**
     * Force Cancel a Booking.
     */
    public function forceCancelBooking($bookingId, $reason)
    {
        return DB::transaction(function () use ($bookingId, $reason) {
            $booking = Booking::findOrFail($bookingId);
            $previousStatus = $booking->status;

            $booking->status = BookingStatus::CANCELLED;
            $booking->refund_reason = $reason;
            $booking->save();

            BookingLog::create([
                'booking_id' => $bookingId,
                'user_id' => auth()->id(),
                'previous_status' => $previousStatus->value,
                'new_status' => BookingStatus::CANCELLED->value,
                'comment' => "Force cancelled by Admin. Reason: $reason",
            ]);

            $this->logActivity(auth()->id(), "booking_force_cancelled", "Booking", $bookingId, "Reason: $reason");

            return $booking;
        });
    }

    /**
     * Manage Partner Commission Rate.
     */
    public function updatePartnerCommission($userId, $rate)
    {
        $partner = Partner::updateOrCreate(
            ['user_id' => $userId],
            ['commission_rate' => $rate]
        );

        $this->logActivity(auth()->id(), "commission_rate_updated", "Partner", $userId, "New rate: $rate%");

        return $partner;
    }

    /**
     * Suspend any user or partner.
     */
    public function suspendUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->status = UserStatus::SUSPENDED;
        $user->save();

        if ($user->role === UserRole::PARTNER) {
            $this->updatePartnerStatus($userId, 'suspended');
        }

        $this->logActivity(auth()->id(), "user_suspended", "User", $userId);

        return $user;
    }

    /**
     * Helper to log activities.
     */
    public function logActivity($userId, $action, $targetType = null, $targetId = null, $description = null)
    {
        return ActivityLog::create([
            'user_id' => $userId,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'description' => $description,
        ]);
    }

    /**
     * Deactivate all products of a partner.
     */
    protected function deactivatePartnerProducts($userId)
    {
        $models = [WisataSpot::class, Hotel::class, FlightTicket::class, TrainTicket::class, BusTicket::class];
        foreach ($models as $model) {
            if (isset((new $model)->user_id)) {
                $model::where('user_id', $userId)->update(['status' => 'rejected', 'is_active' => false]);
            } elseif (isset((new $model)->mitra_id)) {
                $model::where('mitra_id', $userId)->update(['status' => 'rejected', 'is_active' => false]);
            }
        }
    }

    /**
     * Get report data based on filters.
     */
    public function getReportData($category, $month, $year, $startDate, $endDate)
    {
        $query = match ($category) {
            'transaksi' => Booking::with(['user', 'partner']),
            'mitra' => Partner::with('user'),
            'komplain' => \App\Models\Complaint::with(['user', 'partner']),
            default => throw new \Exception("Invalid category"),
        };

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif ($month && $year) {
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        } elseif ($year) {
            $query->whereYear('created_at', $year);
        }

        return $query->latest()->get();
    }

    /**
     * Get model class by category string.
     */
    protected function getProductModel($category)
    {
        return match (strtolower($category)) {
            'wisata' => WisataSpot::class,
            'hotel' => Hotel::class,
            'pesawat' => FlightTicket::class,
            'kereta' => TrainTicket::class,
            'bus' => BusTicket::class,
            default => throw new \Exception("Invalid category"),
        };
    }
}
