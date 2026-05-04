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
            // Optimization: Eager load all relations and select only needed columns
            $query = Booking::with(['bookingorder', 'photocek', 'histori', 'transaksi'])
                ->orderBy('created_at', 'DESC');

            return datatables()->of($query)
                ->addColumn('aksi', function ($booking) {
                    if (Auth::user()->role->role == 'Superadmin') {
                        return '<div class="d-flex justify-content-center">
                                    <button class="delete btn btn-sm btn-danger w-20" id="' . $booking->id . '">Hapus</button>
                                </div>';
                    }
                })
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    return '<div class="fw-bold">' . $booking->no_pol_kendaraan . '</div><div class="text-gray-500 small">' . $booking->name . '</div>';
                })
                ->editColumn('tgl_booking', function ($booking) {
                    $html = '<div class="text-xs">';
                    $html .= '<div><strong>Booking:</strong> ' . date('d-m-Y H:i', strtotime($booking->tgl_booking . ' ' . $booking->waktu_booking)) . '</div>';
                    if ($booking->tgl_proses) $html .= '<div><strong>Proses:</strong> ' . date('d-m-Y H:i', strtotime($booking->tgl_proses)) . '</div>';
                    if ($booking->tgl_selesai) $html .= '<div><strong>Selesai:</strong> ' . date('d-m-Y H:i', strtotime($booking->tgl_selesai)) . '</div>';
                    $html .= '</div>';
                    return $html;
                })
                ->editColumn('description', function ($booking) {
                    $btn = '<button class="orderan btn btn-xs btn-warning mb-1" id="' . $booking->id . '">Orderan Details</button>';
                    return '<div>' . $btn . '</div><div class="text-xs text-gray-600">' . $booking->description . '</div>';
                })
                ->editColumn('status', function ($booking) {
                    $status = '<span class="badge bg-primary/10 text-primary rounded-pill px-2 py-1 mb-1">' . $booking->status . '</span>';
                    $payStatus = '<br><span class="badge bg-' . ($booking->status_pembayaran == 'Sudah Bayar' ? 'success' : 'warning') . '/10 text-' . ($booking->status_pembayaran == 'Sudah Bayar' ? 'success' : 'warning') . ' rounded-pill px-2 py-1">' . ($booking->status_pembayaran ?: 'Belum Bayar') . '</span>';
                    
                    $actions = '<div class="mt-2 d-flex gap-1">';
                    if ($booking->photocek->count() > 0) $actions .= '<button class="upload btn btn-xs btn-outline-secondary" id="' . $booking->id . '">Photos</button>';
                    if ($booking->histori->count() > 0) $actions .= '<button class="pengerjaan btn btn-xs btn-outline-secondary" id="' . $booking->id . '">Logs</button>';
                    $actions .= '</div>';
                    
                    return $status . $payStatus . $actions;
                })
                ->editColumn('tipe_mobil', function ($booking) {
                    $img = $booking->photo_tipe_mobil ? asset('storage/tipemobil/' . $booking->photo_tipe_mobil) : asset('image/no_photo_tipe_mobil.png');
                    return '<center><img src="' . $img . '" style="width: 80px; border-radius: 8px;"/><div class="mt-1 small fw-medium">' . $booking->tipe_mobil . '</div></center>';
                })
                ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'tipe_mobil'])
                ->make(true);
        }
        return view('admin.booking');
    }

    public function transaksi()
    {
        if (request()->ajax()) {
            $query = Booking::where('status_pembayaran', 'Sudah Bayar')
                ->with(['transaksi', 'bookingorder'])
                ->orderBy('created_at', 'DESC');

            return datatables()->of($query)
                ->addColumn('aksi', function ($booking) {
                    if (Auth::user()->role->role == 'Superadmin') {
                        return '<button type="button" class="reset btn btn-sm btn-dark w-full" id="' . $booking->id . '">Reset Transaksi</button>';
                    }
                })
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    return '<div><strong>' . $booking->no_pol_kendaraan . '</strong></div><div class="text-xs">' . $booking->tipe_mobil . '</div><div class="text-xs text-gray-500">' . $booking->phone . '</div>';
                })
                ->editColumn('tgl_booking', function ($booking) {
                    return '<div class="text-xs">
                                <div><strong>Book:</strong> ' . date('d-m-Y', strtotime($booking->tgl_booking)) . '</div>
                                <div><strong>Done:</strong> ' . ($booking->tgl_selesai ? date('d-m-Y H:i', strtotime($booking->tgl_selesai)) : '-') . '</div>
                            </div>';
                })
                ->editColumn('description', function ($booking) {
                    $items = $booking->bookingorder->pluck('product_name')->implode(', ');
                    $total = number_format($booking->transaksi->total ?? 0, 0, ',', '.');
                    $disc = number_format($booking->transaksi->discount ?? 0, 0, ',', '.');
                    return '<div class="text-xs">
                                <div class="mb-1"><strong>Items:</strong> ' . $items . '</div>
                                <div class="text-success fw-bold">Total: Rp ' . $total . '</div>
                                <div class="text-gray-500">Disc: Rp ' . $disc . '</div>
                            </div>';
                })
                ->editColumn('status', function ($booking) {
                    return '<span class="badge bg-success/10 text-success rounded-pill">' . $booking->status_pembayaran . '</span>';
                })
                ->addColumn('transaksi', function ($booking) {
                    if (!$booking->transaksi) return '-';
                    $html = '<div class="text-xs">';
                    $html .= '<div><strong>Inv:</strong> ' . $booking->transaksi->invoice . '</div>';
                    $html .= '<div><strong>Metode:</strong> ' . $booking->transaksi->metode_pembayaran . '</div>';
                    if ($booking->transaksi->keterangan) {
                        $html .= '<div class="mt-1"><img src="' . asset('storage/bukti-pembayaran/' . $booking->transaksi->keterangan) . '" style="width: 40px; border-radius: 4px;"/></div>';
                    }
                    $html .= '</div>';
                    return $html;
                })
                ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'transaksi'])
                ->make(true);
        }
        return view('admin.transaksi');
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
