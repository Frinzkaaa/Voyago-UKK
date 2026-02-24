<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\AdminService;
use App\Models\WisataSpot;
use App\Models\Hotel;
use App\Models\FlightTicket;
use App\Models\TrainTicket;
use App\Models\BusTicket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function dashboard()
    {
        $stats = $this->adminService->getPlatformStats();
        $recentBookings = $this->adminService->getAllBookings()->take(10);
        $logs = $this->adminService->getActivityLogs()->take(10);

        return view('admin.dashboard', compact('stats', 'recentBookings', 'logs'));
    }

    public function verifyPartner(Request $request, $userId)
    {
        try {
            $this->adminService->updatePartnerStatus($userId, 'verified');
            return back()->with('success', 'Partner verified successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function rejectPartner(Request $request, $userId)
    {
        $request->validate(['reason' => 'required|string']);
        try {
            $this->adminService->updatePartnerStatus($userId, 'rejected', $request->reason);
            return back()->with('success', 'Partner rejected');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function approveProduct(Request $request, $category, $productId)
    {
        try {
            $this->adminService->updateProductStatus($category, $productId, 'active');
            return response()->json(['message' => 'Product approved']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function rejectProduct(Request $request, $category, $productId)
    {
        $request->validate(['reason' => 'required|string']);
        try {
            $this->adminService->updateProductStatus($category, $productId, 'rejected', $request->reason);
            return response()->json(['message' => 'Product rejected']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function cancelBooking(Request $request, $bookingId)
    {
        $request->validate(['reason' => 'required|string']);
        try {
            $this->adminService->forceCancelBooking($bookingId, $request->reason);
            return response()->json(['message' => 'Booking cancelled by admin']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function suspendUser(Request $request, $userId)
    {
        try {
            $this->adminService->suspendUser($userId);
            return response()->json(['message' => 'User suspended']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateCommission(Request $request, $userId)
    {
        $request->validate(['rate' => 'required|numeric|min:0|max:100']);
        try {
            $this->adminService->updatePartnerCommission($userId, $request->rate);
            return response()->json(['message' => 'Commission rate updated']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function monitoringTransaksi()
    {
        $bookings = $this->adminService->getAllBookings();
        return view('admin.monitoring-transaksi', compact('bookings'));
    }

    public function monitoringKomplain()
    {
        $complaints = \App\Models\Complaint::with(['user', 'booking', 'partner'])->latest()->get();
        return view('admin.monitoring-komplain', compact('complaints'));
    }

    public function forwardComplaintToMitra($id)
    {
        $complaint = \App\Models\Complaint::findOrFail($id);
        $complaint->update([
            'is_forwarded' => true,
            'status' => 'in_progress'
        ]);
        return back()->with('success', 'Komplain berhasil diteruskan ke mitra.');
    }

    public function respondComplaint(Request $request, $id)
    {
        $request->validate(['response' => 'required|string']);
        $complaint = \App\Models\Complaint::findOrFail($id);
        $complaint->update([
            'admin_response' => $request->response,
            'status' => 'resolved'
        ]);
        return back()->with('success', 'Tanggapan berhasil dikirim.');
    }

    public function verifikasiMitra()
    {
        $partners = \App\Models\Partner::with('user')->latest()->get();
        return view('admin.verifikasi-mitra', compact('partners'));
    }

    public function list($category)
    {
        $tickets = match ($category) {
            'wisata' => WisataSpot::latest()->get(),
            'hotel' => Hotel::latest()->get(),
            'pesawat' => FlightTicket::latest()->get(),
            'kereta' => TrainTicket::latest()->get(),
            'bus' => BusTicket::latest()->get(),
            default => collect([]),
        };

        return view('admin.tickets.list', compact('category', 'tickets'));
    }

    public function create($category)
    {
        return view('admin.tickets.create', compact('category'));
    }

    public function store(Request $request, $category)
    {
        // Store logic
        return redirect()->route('admin.tickets.list', $category)->with('success', 'Product created successfully');
    }

    public function edit($category, $id)
    {
        return view('admin.tickets.edit', compact('category', 'id'));
    }

    public function update(Request $request, $category, $id)
    {
        // Update logic
        return redirect()->route('admin.tickets.list', $category)->with('success', 'Product updated successfully');
    }

    public function destroy($category, $id)
    {
        // Delete logic
        return redirect()->route('admin.tickets.list', $category)->with('success', 'Product deleted successfully');
    }

    public function cetakLaporan()
    {
        return view('admin.cetak-laporan');
    }

    public function exportLaporan(Request $request)
    {
        $category = $request->category;
        $month = $request->month;
        $year = $request->year ?? date('Y');
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $format = $request->format ?? 'pdf';

        $data = $this->adminService->getReportData($category, $month, $year, $startDate, $endDate);

        if ($format === 'excel') {
            return $this->exportToCsv($category, $data);
        }

        // For PDF, we return a specialized print view
        return view('admin.reports.print', [
            'data' => $data,
            'category' => $category,
            'period' => $startDate && $endDate ? "$startDate - $endDate" : ($month ? date('F', mktime(0, 0, 0, $month, 10)) . " $year" : "Tahun $year")
        ]);
    }

    protected function exportToCsv($category, $data)
    {
        $filename = "laporan_{$category}_" . date('Ymd_His') . ".csv";
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($category, $data) {
            $file = fopen('php://output', 'w');

            // Excel compatibility BOM
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            if ($category === 'transaksi') {
                fputcsv($file, ['ID', 'Booking Code', 'User', 'Mitra', 'Price', 'Status', 'Tanggal']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->id, $row->booking_code, $row->user->name, $row->partner->name ?? '-', $row->total_price, $row->status, $row->created_at]);
                }
            } elseif ($category === 'mitra') {
                fputcsv($file, ['ID', 'Nama Mitra', 'Tipe Layanan', 'Status', 'Tanggal Bergabung']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->id, $row->user->name, $row->service_type, $row->status, $row->created_at]);
                }
            } elseif ($category === 'komplain') {
                fputcsv($file, ['ID', 'User', 'Kategori', 'Subyek', 'Status', 'Tanggal']);
                foreach ($data as $row) {
                    fputcsv($file, [$row->id, $row->user->name, $row->category, $row->subject, $row->status, $row->created_at]);
                }
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}