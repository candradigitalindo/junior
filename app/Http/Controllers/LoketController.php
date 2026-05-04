<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bookingorder;
use App\Models\Category;
use App\Models\Extraservice;
use App\Models\Product;
use App\Models\Tipemobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Photocek;
use App\Models\Transaksi;
use App\Traits\PlatHelper;
use Illuminate\Support\Facades\Auth;
use Validator;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LoketController extends Controller
{
    use PlatHelper;

    private function baseLoketQuery()
    {
        return Booking::query()
            ->where('status', '!=', 'Selesai')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    private function loketBookingQuery()
    {
        return $this->baseLoketQuery()
            ->with([
                'bookingorder:id,booking_id,product_name,extraservice_name',
            ])
            ->withCount('photocek')
            ->orderBy('created_at', 'DESC');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $bookings = $this->loketBookingQuery()->get()->map(function ($booking) {
                $services = $booking->bookingorder->map(function ($order) {
                    $label = trim((string) $order->product_name);

                    if ($order->extraservice_name) {
                        $label .= ' + ' . trim((string) $order->extraservice_name);
                    }

                    return $label;
                })->filter()->values();

                return [
                    'id' => $booking->id,
                    'no_pol_kendaraan' => $booking->no_pol_kendaraan,
                    'tipe_mobil' => $booking->tipe_mobil ?: 'Tipe belum dipilih',
                    'name' => $booking->name,
                    'phone' => $booking->phone,
                    'created_label' => $booking->created_at ? $booking->created_at->format('d M Y, H:i') : '-',
                    'service_preview' => $services->take(2)->implode(', ') ?: 'Belum ada layanan',
                    'service_summary' => $services->implode(', '),
                    'service_count' => $services->count(),
                    'service_more_count' => max($services->count() - 2, 0),
                    'photo_count' => (int) $booking->photocek_count,
                    'payment_status' => $booking->status_pembayaran ?: 'Belum Bayar',
                    'vehicle_status' => $booking->status_kendaraan ?: '-',
                    'booking_status' => $booking->status ?: 'Booking',
                ];
            })->values();

            return response()->json(['data' => $bookings]);
        }

        $statsQuery = $this->baseLoketQuery();
        $stats = [
            'active' => (clone $statsQuery)->count(),
            'waiting' => (clone $statsQuery)->where('status_kendaraan', 'Ditunggu')->count(),
            'dropoff' => (clone $statsQuery)->where('status_kendaraan', 'Ditinggal')->count(),
            'unpaid' => (clone $statsQuery)
                ->where(function ($query) {
                    $query->whereNull('status_pembayaran')
                        ->orWhere('status_pembayaran', '!=', 'Sudah Bayar');
                })
                ->count(),
        ];

        return view('loket.dashoboard', compact('stats'));
    }

    public function getProduk()
    {
        $produk = Product::orderBy('name', 'ASC')->get();
        return response()->json(['status' => 'sukses', 'data' => $produk]);
    }

    public function orderan($id)
    {
        $booking = Booking::with('bookingorder')->find($id);
        if (!$booking && request()->ajax()) {
            return datatables()->of([])->make(true);
        }

        if (request()->ajax()) {
            return datatables()->of($booking->bookingorder)
                ->addIndexColumn()
                ->addColumn('bookingorder', function ($row) {
                    $extra = $row->extraservice_name
                        ? '<div class="service-item-card__extra">Extra: ' . e($row->extraservice_name) . ' (Rp ' . number_format($row->extraservice_price, 0, ',', '.') . ')</div>'
                        : '<div class="service-item-card__extra service-item-card__extra--empty">Tanpa layanan tambahan</div>';
                    
                    return '
                    <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center gap-3 p-3 p-sm-4 border border-light rounded-3 mb-2 bg-white shadow-sm">
                        <div class="me-auto w-full">
                            <div class="service-item-card__title">' . e($row->product_name) . '</div>
                            <div class="service-item-card__price">Harga utama: Rp ' . number_format($row->product_price, 0, ',', '.') . '</div>
                            ' . $extra . '
                        </div>
                        <div class="d-flex align-items-center justify-content-sm-end w-full w-sm-auto gap-2">
                            <button class="delete_layanan btn btn-sm btn-outline-danger w-full w-sm-auto" id="' . $row->id . '">
                                <i data-feather="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['bookingorder'])
                ->make(true);
        }
    }

    public function bookingorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_pol_kendaraan' => 'required|string',
            'name'             => 'required|string',
            'tipe_mobil'       => 'nullable|string',
            'phone'            => 'required|string',
            'status_kendaraan' => 'required|string'
        ], [
            'no_pol_kendaraan.required' => 'Nomor Polisi wajib diisi',
            'name.required'             => 'Nama Pelanggan wajib diisi',
            'phone.required'            => 'Nomor HP wajib diisi',
            'status_kendaraan.required' => 'Status Kendaraan wajib dipilih'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()]);
        }

        $tipemobil = Tipemobil::find($request->tipe_mobil);
        $booking = Booking::create([
            'no_pol_kendaraan' => $this->plat($request->no_pol_kendaraan),
            'name'             => ucwords($request->name),
            'tipe_mobil'       => $tipemobil ? $tipemobil->name : null,
            'phone'            => $request->phone,
            'tgl_booking'      => date('Y-m-d'),
            'waktu_booking'    => date('H:i'),
            'description'      => 'Visit',
            'status'           => 'Booking',
            'tgl_proses'       => now(),
            'photo_tipe_mobil' => $tipemobil ? $tipemobil->photo : null,
            'status_kendaraan' => $request->status_kendaraan
        ]);

        return response()->json(['status' => 'sukses', 'text' => 'Booking ' . $booking->no_pol_kendaraan . ' berhasil dibuat.']);
    }

    public function edit($id)
    {
        $booking = Booking::with('bookingorder')->find($id);
        if (!$booking) {
            return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);
        }
        return response()->json(['status' => 'sukses', 'data' => $booking]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'no_pol_kendaraan' => 'required|string',
            'name'             => 'required|string',
            'tipe_mobil'       => 'required|string',
            'phone'            => 'required|string',
            'status_kendaraan' => 'required|string'
        ], [
            'no_pol_kendaraan.required' => 'Nomor Polisi wajib diisi',
            'name.required'             => 'Nama Pelanggan wajib diisi',
            'tipe_mobil.required'       => 'Tipe Mobil wajib dipilih',
            'phone.required'            => 'Nomor HP wajib diisi',
            'status_kendaraan.required' => 'Status Kendaraan wajib dipilih'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()]);
        }

        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);
        }

        $tipemobil = Tipemobil::find($request->tipe_mobil);
        $booking->update([
            'no_pol_kendaraan' => $this->plat($request->no_pol_kendaraan),
            'name'             => ucwords($request->name),
            'tipe_mobil'       => $tipemobil ? $tipemobil->name : $booking->tipe_mobil,
            'phone'            => $request->phone,
            'status_kendaraan' => $request->status_kendaraan
        ]);

        return response()->json(['status' => 'sukses', 'text' => 'Booking ' . $booking->no_pol_kendaraan . ' berhasil diupdate.']);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);
        }

        if (strcasecmp(Auth::user()->role->role, 'Superadmin') !== 0) {
            if ($booking->status == 'Selesai') {
                return response()->json(['status' => 'gagal', 'text' => 'Booking ' . $booking->no_pol_kendaraan . ' gagal dihapus status sudah Selesai']);
            }
        }

        $photocek = Photocek::where('booking_id', $booking->id)->get();
        if ($photocek) {
            foreach ($photocek as $photo) {
                Storage::disk('local')->delete('public/photocek/' . $photo->photo);
            }
        }

        $transaksi = Transaksi::where('booking_id', $booking->id)->first();
        if ($transaksi) {
            Storage::disk('local')->delete('public/bukti-pembayaran/' . $transaksi->keterangan);
        }

        $booking->delete();
        return response()->json(['status' => 'sukses', 'text' => 'Booking ' . $booking->no_pol_kendaraan . ' terhapus']);
    }

    public function pengecekan($id)
    {
        $booking = Booking::where('id', $id)->with(['cekmasuk', 'histori', 'cekkeluar'])->first();
        return response()->json(['data' => $booking]);
    }

    public function pengerjaan($id)
    {
        $booking = Booking::with('histori')->find($id);
        if (request()->ajax()) {
            return datatables()->of($booking->histori()->orderBy('created_at', 'DESC'))
                ->addIndexColumn()
                ->addColumn('histori', function ($row) {
                    return '
                    <div class="d-flex align-items-center p-3 border-start border-4 border-primary bg-light rounded-end mb-2 shadow-sm">
                        <div class="me-auto">
                            <div class="fw-bold text-dark">' . $row->histori . '</div>
                            <div class="small text-secondary mt-1 d-flex align-items-center">
                                <i data-feather="clock" class="w-3 h-3 me-1"></i> ' . $row->created_at->format('d M Y H:i') . ' WIB
                            </div>
                        </div>
                    </div>';
                })
                ->rawColumns(['histori'])
                ->make(true);
        }
    }

    public function delete_orderan($id)
    {
        $bookingorder = Bookingorder::find($id);
        if (!$bookingorder) {
            return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);
        }

        $booking_id = $bookingorder->booking_id;
        $bookingorder->delete();

        $this->updateTransaksiTotal($booking_id);

        return response()->json(['status' => 'sukses', 'text' => 'Layanan berhasil dihapus.']);
    }

    public function tambah_orderan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product' => 'required',
        ], [
            'product.required' => 'Pilih Layanan',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()]);
        }

        $product = Product::find($request->product);
        if (!$product) {
            return response()->json(['status' => 'gagal', 'text' => 'Produk tidak ditemukan']);
        }

        $extraservice = $request->extraservice ? Extraservice::find($request->extraservice) : null;

        $bookingorder = Bookingorder::create([
            'booking_id'         => $id,
            'product_name'       => $product->name,
            'product_price'      => $product->price,
            'extraservice_name'  => $extraservice ? $extraservice->name : null,
            'extraservice_price' => $extraservice ? $extraservice->price : 0,
        ]);

        $this->updateTransaksiTotal($id);

        return response()->json(['status' => 'sukses', 'text' => 'Tambah ' . $bookingorder->product_name . ' berhasil']);
    }

    private function updateTransaksiTotal($booking_id)
    {
        $total = Bookingorder::where('booking_id', $booking_id)->sum('product_price') + 
                 Bookingorder::where('booking_id', $booking_id)->sum('extraservice_price');

        $transaksi = Transaksi::where('booking_id', $booking_id)->first();
        if ($transaksi) {
            $transaksi->update([
                'total' => $total - $transaksi->discount
            ]);
        } else {
            Transaksi::create([
                'booking_id' => $booking_id,
                'invoice'    => date('ymd') . time(),
                'total'      => $total
            ]);
        }
    }

    public function selesai()
    {
        if (request()->ajax()) {
            $booking = Booking::with(['bookingorder:id,booking_id,product_name'])
                ->where('status', 'Selesai')
                ->whereDate('updated_at', now()->toDateString())
                ->orderBy('updated_at', 'DESC');

            return datatables()->of($booking)
                ->addIndexColumn()
                ->addColumn('orderan', function ($row) {
                    return $row->bookingorder->pluck('product_name')->implode(", ");
                })
                ->rawColumns(['orderan'])
                ->make(true);
        }
    }

    public function serah_terima()
    {
        if (request()->ajax()) {
            $booking = Booking::with(['bookingorder:id,booking_id,product_name'])
                ->orderBy('created_at', 'DESC')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'));

            return datatables()->of($booking)
                ->addIndexColumn()
                ->addColumn('orderan', function ($row) {
                    return $row->bookingorder->pluck('product_name')->implode(", ") ?: '-';
                })
                ->addColumn('aksi', function ($row) {
                    return '<div class="flex justify-center items-center">
                        <a target="_blank" href="' . route('form.cetak', $row->id) . '" class="btn btn-sm btn-dark">
                            <i data-feather="printer" class="w-4 h-4 mr-1"></i> Cetak Form
                        </a>
                    </div>';
                })
                ->rawColumns(['orderan', 'aksi'])
                ->make(true);
        }

        return view('loket.serah_terima');
    }

    public function cetak($id)
    {
        $transaksi = Transaksi::where('booking_id', $id)->with('booking')->first();
        $booking = Booking::where('id', $transaksi->booking_id)->with('bookingorder')->first();
        $pdf = PDF::loadView('cetak.form', compact('transaksi', 'booking'));
        return $pdf->stream();
    }

    public function qrcode ($id)
    {
        $booking = Booking::find($id);
        $qrcode = QrCode::size(100)->generate($booking->id);
        return view('cetak.qrcode', compact('qrcode', 'booking'));
    }
}
