<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Bookingorder;
use App\Models\Histori;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class KasirController extends Controller
{
    private function resolveKasirDateRange(Request $request): array
    {
        $today = now()->toDateString();
        $startInput = $request->start_date;
        $endInput = $request->end_date;

        // Default kasir view always uses daily data.
        if (!$startInput && !$endInput) {
            return [$today, $today];
        }

        if (!$startInput || !$endInput) {
            throw new \InvalidArgumentException('Mohon pilih tanggal awal dan akhir secara lengkap.');
        }

        try {
            $start = Carbon::parse($startInput)->startOfDay();
            $end = Carbon::parse($endInput)->startOfDay();
        } catch (\Throwable $e) {
            throw new \InvalidArgumentException('Format tanggal tidak valid.');
        }

        $limit = now()->subMonths(3)->startOfDay();

        if ($start->lt($limit) || $end->lt($limit)) {
            throw new \InvalidArgumentException('Kasir hanya boleh filter data 3 bulan terakhir.');
        }

        if ($start->gt($end)) {
            throw new \InvalidArgumentException('Tanggal awal tidak boleh lebih besar dari tanggal akhir.');
        }

        return [$start->toDateString(), $end->toDateString()];
    }

    private function getBookingData(string $startDate, string $endDate)
    {
        $query = Booking::with(['cekmasuk', 'transaksi', 'bookingorder', 'photocek', 'histori'])
            ->select('bookings.*')
            ->whereBetween('bookings.tgl_booking', [$startDate, $endDate])
            ->orderBy('bookings.tgl_booking', 'DESC')
            ->orderBy('bookings.waktu_booking', 'DESC');

        return $query;
    }

    public function index(Request $request)
    {
        if (request()->ajax()) {
            try {
                [$start, $end] = $this->resolveKasirDateRange($request);
            } catch (\InvalidArgumentException $e) {
                return response()->json(['message' => $e->getMessage()], 422);
            }

            $query = $this->getBookingData($start, $end);
            
            // Robust calculation for summaries
            $summaryPaid = \DB::table('bookings')
                ->leftJoin('transaksis', 'bookings.id', '=', 'transaksis.booking_id')
                ->whereBetween('bookings.tgl_booking', [$start, $end])
                ->where('bookings.status_pembayaran', 'Sudah Bayar')
                ->sum('transaksis.total') ?: 0;

            $summaryUnpaid = \DB::table('bookings')
                ->leftJoin('transaksis', 'bookings.id', '=', 'transaksis.booking_id')
                ->whereBetween('bookings.tgl_booking', [$start, $end])
                ->where(function($q) {
                    $q->where('bookings.status_pembayaran', '!=', 'Sudah Bayar')
                      ->orWhereNull('bookings.status_pembayaran');
                })
                ->sum('transaksis.total') ?: 0;

            return datatables()->of($query)
                ->editColumn('tgl_booking', function($booking) {
                    return $booking->tgl_booking . ' ' . $booking->waktu_booking;
                })
                ->addColumn('total_tagihan', function($booking) {
                    return $booking->transaksi->total ?? 0;
                })
                ->addColumn('discount_amount', function($booking) {
                    return $booking->transaksi->discount ?? 0;
                })
                ->addColumn('invoice_number', function($booking) {
                    return $booking->transaksi->invoice ?? '-';
                })
                ->addColumn('payment_method', function($booking) {
                    return $booking->transaksi->metode_pembayaran ?? '-';
                })
                ->addColumn('payment_proof', function($booking) {
                    return $booking->transaksi->keterangan ?? null;
                })
                ->addColumn('paid_at', function($booking) {
                    return $booking->transaksi->tgl_bayar ?? null;
                })
                ->with([
                    'totalPaid' => $summaryPaid,
                    'totalUnpaid' => $summaryUnpaid
                ])
                ->make(true);
        }
        return view('kasir.kasir');
    }

    public function unpaid_view(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        if (request()->ajax()) {
            $query = Booking::with(['cekmasuk', 'transaksi', 'bookingorder', 'photocek', 'histori'])
                ->select('bookings.*')
                ->where('bookings.status_pembayaran', '!=', 'Sudah Bayar')
                ->orderBy('bookings.tgl_booking', 'DESC')
                ->orderBy('bookings.waktu_booking', 'DESC');

            if ($start && $end) {
                $query->whereBetween('bookings.tgl_booking', [$start, $end]);
            } else {
                $query->whereMonth('bookings.tgl_booking', now()->month)
                      ->whereYear('bookings.tgl_booking', now()->year);
            }

            // Calculate total for summary
            $totalSum = (clone $query)->join('transaksis', 'bookings.id', '=', 'transaksis.booking_id')
                ->sum('transaksis.total') ?: 0;

            return datatables()->of($query)
                ->editColumn('tgl_booking', function($booking) {
                    return $booking->tgl_booking . ' ' . $booking->waktu_booking;
                })
                ->addColumn('total_tagihan', function($booking) {
                    return $booking->transaksi->total ?? 0;
                })
                ->addColumn('discount_amount', function($booking) {
                    return $booking->transaksi->discount ?? 0;
                })
                ->addColumn('invoice_number', function($booking) {
                    return $booking->transaksi->invoice ?? '-';
                })
                ->addColumn('payment_method', function($booking) {
                    return $booking->transaksi->metode_pembayaran ?? '-';
                })
                ->with('totalSum', $totalSum)
                ->make(true);
        }
        return view('kasir.unpaid');
    }

    public function bayar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'metode_pembayaran' => 'required|string',
            'foto_pembayaran'   => 'nullable|image|max:10240',
        ], [
            'metode_pembayaran.required' => 'Pilih Metode Pembayaran',
            'foto_pembayaran.max'        => 'Ukuran file maksimal 10MB',
        ]);

        if ($validator->passes()) {
            $booking = Booking::with('transaksi')->find($id);
            if (!$booking) return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);

            $updateData = [
                'metode_pembayaran' => $request->metode_pembayaran,
                'tgl_bayar'         => now()
            ];

            if ($request->hasFile('foto_pembayaran')) {
                $file = $request->file('foto_pembayaran');
                $fileName = $file->hashName();
                
                // Image Processing
                $img = Image::make($file->path());
                
                // Resize for proof (doesn't need to be huge)
                $img->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // Ensure directory exists
                if (!Storage::disk('public')->exists('bukti-pembayaran')) {
                    Storage::disk('public')->makeDirectory('bukti-pembayaran');
                }

                // Save optimized
                $img->save(storage_path('app/public/bukti-pembayaran/' . $fileName), 80);
                
                $updateData['keterangan'] = $fileName;
            }

            $booking->update(['status_pembayaran' => 'Sudah Bayar']);
            $booking->transaksi->update($updateData);

            return response()->json(['text' => 'Transaksi ' . $booking->no_pol_kendaraan . ' sukses diproses']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function diskon(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'diskon'  => 'required|numeric|min:0',
        ], [
            'diskon.required'  => 'Isi Kolom Diskon',
            'diskon.min'       => 'Minimal Diskon 0'
        ]);

        if ($validator->passes()) {
            $booking = Booking::with(['transaksi', 'bookingorder'])->find($id);
            if ($booking->status_pembayaran == 'Sudah Bayar') {
                return response()->json(['status' => 'gagal', 'text' => 'Gagal di update, Booking ' . $booking->no_pol_kendaraan . ' sudah terbayar']);
            }
            
            $baseTotal = $booking->bookingorder->sum('product_price') + $booking->bookingorder->sum('extraservice_price');
            $newTotal = $baseTotal - $request->diskon;

            $booking->transaksi->update([
                'discount' => $request->diskon, 
                'total' => $newTotal
            ]);
            
            return response()->json(['status' => 'sukses', 'text' => 'Diskon ' . $booking->no_pol_kendaraan . ' sebesar ' . number_format($request->diskon, 0, ',', '.') . ' sukses diproses']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function reset_dikon($id)
    {
        $booking = Booking::with(['transaksi', 'bookingorder'])->find($id);
        if ($booking->status_pembayaran == 'Sudah Bayar') {
            return response()->json(['status' => 'gagal', 'text' => 'Gagal di update, Booking ' . $booking->no_pol_kendaraan . ' sudah terbayar']);
        }
        
        $baseTotal = $booking->bookingorder->sum('product_price') + $booking->bookingorder->sum('extraservice_price');
        
        $booking->transaksi->update([
            'discount'      => 0,
            'total'         => $baseTotal
        ]);

        return response()->json(['status' => 'sukses', 'text' => 'Reset Diskon berhasil']);
    }

    public function dashboard(Request $request)
    {
        return $this->index($request);
    }
}
