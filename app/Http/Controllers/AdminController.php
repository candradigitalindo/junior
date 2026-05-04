<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bookingorder;
use App\Models\Histori;
use App\Models\Pengeluaran;
use App\Models\Pemasukan;
use App\Models\Product;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function trx_tanggal($tanggal)
    {
        $trx_tanggal = Transaksi::whereNotNull('tgl_bayar')
            ->whereDay('updated_at', $tanggal)
            ->whereMonth('updated_at', date('m'))
            ->whereYear('updated_at', date('Y'))
            ->get();

        $bookingorder = [];
        foreach ($trx_tanggal as $key) {
            $bookingorder[] = Bookingorder::where('booking_id', $key->booking_id)->get();
        }

        return view('admin.trx-tanggal', compact('trx_tanggal', 'tanggal', 'bookingorder'));
    }

    public function booking()
    {
        if (request()->ajax()) {
            $dateFrom = request('date_from');
            $dateTo   = request('date_to');
            $status   = request('status');

            $query = Booking::query()
                ->select('id', 'no_pol_kendaraan', 'name', 'tipe_mobil', 'phone', 'tgl_booking', 'waktu_booking', 'tgl_proses', 'tgl_selesai', 'description', 'status', 'status_pembayaran', 'photo_tipe_mobil', 'created_at')
                ->with([
                    'bookingorder' => fn($q) => $q->select('id', 'booking_id', 'product_name'),
                    'photocek' => fn($q) => $q->select('id', 'booking_id'),
                    'histori' => fn($q) => $q->select('id', 'booking_id'),
                    'transaksi' => fn($q) => $q->select('id', 'booking_id')
                ])
                ->when($dateFrom, fn($q) => $q->whereDate('tgl_booking', '>=', $dateFrom))
                ->when($dateTo,   fn($q) => $q->whereDate('tgl_booking', '<=', $dateTo))
                ->when(!$dateFrom && !$dateTo, function($q) {
                    $q->whereMonth('tgl_booking', now()->month)
                      ->whereYear('tgl_booking', now()->year);
                })
                ->when($status,   fn($q) => $q->where('status', $status))
                ->orderByDesc('created_at');

            return datatables()->of($query)
                ->addColumn('aksi', function ($booking) {
                    if (Auth::user()->role->role === 'Superadmin') {
                        return '<button class="delete btn btn-sm btn-outline-danger px-3 shadow-none" id="' . $booking->id . '">Hapus</button>';
                    }
                    return '';
                })
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    return '<div class="fw-semibold text-dark">' . $booking->no_pol_kendaraan . '</div>'
                        . '<div class="text-xs text-gray-500">' . $booking->name . '</div>';
                })
                ->editColumn('tgl_booking', function ($booking) {
                    $html = '<div class="text-xs">';
                    $html .= '<div><span class="text-gray-400">Book:</span> ' . date('d/m/Y', strtotime($booking->tgl_booking)) . ' ' . $booking->waktu_booking . '</div>';
                    if ($booking->tgl_proses) $html .= '<div class="mt-1"><span class="text-gray-400">Proses:</span> ' . date('d/m/Y H:i', strtotime($booking->tgl_proses)) . '</div>';
                    $html .= '</div>';
                    return $html;
                })
                ->editColumn('description', function ($booking) {
                    $btn = '<button class="orderan btn btn-xs btn-soft-warning mb-2 w-full" id="' . $booking->id . '">Orderan Details</button>';
                    $logs = $booking->histori->count() > 0 ? '<button class="pengerjaan btn btn-xs btn-outline-secondary w-full" id="' . $booking->id . '">View Logs</button>' : '';
                    return '<div style="min-width: 120px;">' . $btn . $logs . '</div>';
                })
                ->editColumn('status', function ($booking) {
                    $statusColor = match($booking->status) {
                        'Booking' => 'primary',
                        'Proses' => 'warning',
                        'Selesai' => 'success',
                        default => 'secondary'
                    };
                    
                    $payColor = $booking->status_pembayaran === 'Sudah Bayar' ? 'success' : 'warning';
                    
                    $html = '<div class="mb-1"><span class="badge badge-soft-' . $statusColor . ' px-2 py-1 w-full text-center" style="font-size: 10px;">' . strtoupper($booking->status) . '</span></div>';
                    $html .= '<div class="mb-2"><span class="badge badge-soft-' . $payColor . ' px-2 py-1 w-full text-center" style="font-size: 10px;">' . strtoupper($booking->status_pembayaran ?: 'BELUM BAYAR') . '</span></div>';
                    
                    if ($booking->photocek->count() > 0) {
                        $html .= '<button class="upload btn btn-xs btn-outline-secondary w-full py-1" id="' . $booking->id . '">Photos</button>';
                    }
                    
                    return '<div style="min-width: 100px;">' . $html . '</div>';
                })
                ->editColumn('tipe_mobil', function ($booking) {
                    $img = $booking->photo_tipe_mobil ? asset('storage/tipemobil/' . $booking->photo_tipe_mobil) : asset('image/no_photo_tipe_mobil.png');
                    return '<div class="d-flex align-items-center gap-3">
                                <img src="' . $img . '" class="rounded border" style="width: 60px; height: 45px; object-fit: cover;"/>
                                <div class="small fw-medium text-gray-700">' . $booking->tipe_mobil . '</div>
                            </div>';
                })
                ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'tipe_mobil'])
                ->make(true);
        }
        return view('admin.booking');
    }

    public function transaksi()
    {
        if (request()->ajax()) {
            $dateFrom = request('date_from') ?: now()->subMonth()->toDateString();
            $dateTo   = request('date_to') ?: now()->toDateString();
            $metode   = request('metode');

            $query = Booking::where('status_pembayaran', 'Sudah Bayar')
                ->with(['transaksi', 'bookingorder'])
                ->whereHas('transaksi', function ($t) use ($dateFrom, $dateTo, $metode) {
                    $t->whereDate('tgl_bayar', '>=', $dateFrom)
                        ->whereDate('tgl_bayar', '<=', $dateTo);
                    if ($metode) {
                        $t->where('metode_pembayaran', $metode);
                    }
                })
                ->orderByDesc('created_at');

            return datatables()->of($query)
                ->addColumn('aksi', function ($booking) {
                    if (Auth::user()->role->role === 'Superadmin') {
                        return '<button type="button" class="reset btn btn-sm btn-outline-danger px-3" id="' . $booking->id . '">Reset</button>';
                    }
                    return '';
                })
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    return '<div class="fw-semibold text-dark">' . $booking->no_pol_kendaraan . '</div>'
                        . '<div class="text-xs text-gray-500">' . $booking->tipe_mobil . '</div>'
                        . '<div class="text-xs text-gray-400">' . $booking->phone . '</div>';
                })
                ->editColumn('tgl_booking', function ($booking) {
                    $bayar = optional($booking->transaksi)->tgl_bayar
                        ? date('d/m/Y H:i', strtotime($booking->transaksi->tgl_bayar))
                        : '-';
                    return '<div class="text-xs">'
                        . '<div class="fw-medium">' . date('d/m/Y', strtotime($booking->tgl_booking)) . '</div>'
                        . '<div class="text-gray-400 mt-1">Bayar: ' . $bayar . '</div>'
                        . '</div>';
                })
                ->editColumn('description', function ($booking) {
                    $items = $booking->bookingorder->pluck('product_name')->implode(', ');
                    $total = number_format(optional($booking->transaksi)->total ?? 0, 0, ',', '.');
                    $disc  = optional($booking->transaksi)->discount ?? 0;
                    $html  = '<div class="text-xs"><div class="text-gray-600 mb-1">' . $items . '</div>'
                        . '<div class="fw-bold text-success">Rp ' . $total . '</div>';
                    if ($disc > 0) {
                        $html .= '<div class="text-gray-400">Diskon: Rp ' . number_format($disc, 0, ',', '.') . '</div>';
                    }
                    return $html . '</div>';
                })
                ->addColumn('transaksi_html', function ($booking) {
                    if (!$booking->transaksi) return '<span class="text-gray-400">—</span>';
                    $mp      = $booking->transaksi->metode_pembayaran ?? '';
                    $mpLow   = strtolower($mp);
                    $mpColor = str_contains($mpLow, 'cash') ? 'success' : (str_contains($mpLow, 'qris') ? 'warning' : 'primary');
                    $html    = '<div class="text-xs">'
                        . '<div class="text-gray-400 mb-1">' . $booking->transaksi->invoice . '</div>'
                        . '<span class="badge bg-' . $mpColor . '/10 text-' . $mpColor . ' border border-' . $mpColor . '/20 rounded-pill px-2">' . strtoupper($mp) . '</span>';
                    if ($booking->transaksi->keterangan) {
                        $url   = asset('storage/bukti-pembayaran/' . $booking->transaksi->keterangan);
                        $html .= '<div class="mt-1"><a href="' . $url . '" target="_blank" rel="noopener">'
                            . '<img src="' . $url . '" class="rounded shadow-sm" style="width:32px;height:32px;object-fit:cover;"/>'
                            . '</a></div>';
                    }
                    return $html . '</div>';
                })
                ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'transaksi_html'])
                ->make(true);
        }

        return view('admin.transaksi');
    }

    public function transaksi_stats()
    {
        $dateFrom = request('date_from') ?: now()->subMonth()->toDateString();
        $dateTo   = request('date_to') ?: now()->toDateString();
        $metode   = request('metode');

        $stats = Transaksi::query()
            ->whereNotNull('tgl_bayar')
            ->whereHas('booking', fn ($q) => $q->where('status_pembayaran', 'Sudah Bayar'))
            ->whereDate('tgl_bayar', '>=', $dateFrom)
            ->whereDate('tgl_bayar', '<=', $dateTo)
            ->when($metode,   fn ($q) => $q->where('metode_pembayaran', $metode))
            ->selectRaw("
                COUNT(*) as count,
                COALESCE(SUM(total), 0) as revenue,
                COALESCE(SUM(CASE WHEN LOWER(metode_pembayaran) LIKE '%cash%' THEN total ELSE 0 END), 0) as cash,
                COALESCE(SUM(CASE WHEN LOWER(metode_pembayaran) LIKE '%qris%' OR LOWER(metode_pembayaran) LIKE '%transfer%' THEN total ELSE 0 END), 0) as non_cash
            ")
            ->first();

        return response()->json([
            'count'    => (int) ($stats->count ?? 0),
            'revenue'  => (float) ($stats->revenue ?? 0),
            'cash'     => (float) ($stats->cash ?? 0),
            'non_cash' => (float) ($stats->non_cash ?? 0),
        ]);
    }

    public function reset_transaksi($id)
    {
        $booking = Booking::with('transaksi')->find($id);
        if ($booking) {
            $booking->update(['status_pembayaran' => 'Belum Bayar']);
            if ($booking->transaksi && $booking->transaksi->keterangan) {
                Storage::disk('local')->delete('public/bukti-pembayaran/' . $booking->transaksi->keterangan);
            }
            $booking->transaksi->update([
                'metode_pembayaran' => null,
                'tgl_bayar'         => null,
                'keterangan'        => null
            ]);
        }

        return response()->json(['status' => 'sukses', 'text' => 'Transaksi ' . $booking->no_pol_kendaraan . ' berhasil direset!']);
    }

    public function histori()
    {
        if (request()->ajax()) {
            $query = Booking::with('histori')->orderBy('created_at', 'DESC');

            return datatables()->of($query)
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    return '<div class="fw-bold text-theme-1">' . $booking->no_pol_kendaraan . '</div><div class="text-xs">' . $booking->tipe_mobil . '</div>';
                })
                ->editColumn('pengerjaan', function ($booking) {
                    if ($booking->histori->isEmpty()) return '<span class="text-gray-400 italic">No activity logs</span>';
                    return '<div class="text-xs">' . $booking->histori->pluck('histori')->map(function($h) {
                        return '• ' . $h;
                    })->implode('<br>') . '</div>';
                })
                ->addColumn('tanggal', function ($booking) {
                    return '<div class="text-xs">' . $booking->updated_at->format('d-m-Y H:i') . ' WIB</div>';
                })
                ->rawColumns(['no_pol_kendaraan', 'pengerjaan', 'tanggal'])
                ->make(true);
        }
        return view('admin.histori');
    }

    public function pengeluaran_tahunan()
    {
        if (request()->ajax()) {
            $query = Pengeluaran::whereYear('created_at', date('Y'))->orderBy('created_at', 'DESC');
            
            return datatables()->of($query)
                ->addColumn('aksi', function ($p) {
                    return '<div class="d-flex gap-1">
                                <button class="edit btn btn-xs btn-warning" id="' . $p->id . '">Edit</button>
                                <button class="delete btn btn-xs btn-danger" id="' . $p->id . '">Hapus</button>
                            </div>';
                })
                ->editColumn('name', function ($p) {
                    return '<div class="fw-medium">' . $p->name . '</div>';
                })
                ->editColumn('jumlah', function ($p) {
                    return '<div class="fw-bold text-danger">Rp ' . number_format($p->jumlah, 0, ',', '.') . '</div>';
                })
                ->editColumn('created_at', function ($p) {
                    return '<div class="text-xs">' . $p->created_at->format('d M Y H:i') . '</div>';
                })
                ->editColumn('foto', function ($p) {
                    if (!$p->foto) return '-';
                    return '<img src="' . asset('storage/bukti-pengeluaran/' . $p->foto) . '" style="width: 60px; border-radius: 4px; cursor: pointer;" onclick="window.open(this.src)"/>';
                })
                ->rawColumns(['aksi', 'jumlah', 'name', 'created_at', 'foto'])
                ->make(true);
        }
    }
}
