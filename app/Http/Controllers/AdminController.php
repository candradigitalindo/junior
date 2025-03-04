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
    public function index()
    {
        $booking    = Booking::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $kunjungan  = Booking::where('status', 'Selesai')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();
        $product    = Product::count();
        $pengguna   = User::count();
        $transaksi  = Transaksi::where('tgl_bayar', '!=', null)->orderBy('created_at', 'DESC')->get()->take(5);
        $histori    = Histori::orderBy('created_at', 'DESC')->with('booking')->get()->take(5);
        $booking_t  = Booking::orderBy('created_at', 'DESC')->get()->take(7);
        $trx_now    = Transaksi::where('tgl_bayar', '!=', null)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('total');
        $tahun      = Transaksi::where('tgl_bayar', '!=', null)->whereYear('created_at', date('Y'))->sum('total');

        // Chart
        $labels      = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        for ($bulan = 1; $bulan < 13; $bulan++) {
            $trx_bulan   = Transaksi::where('tgl_bayar', '!=', null)->whereMonth('created_at', $bulan)->whereYear('created_at', date('Y'))->sum('total');
            $jumlah_trx_bln[] = $trx_bulan;
        }
        for ($bln = 01; $bln < 13; $bln++) {
            $peng_bulan = Pengeluaran::whereMonth('created_at', $bln)->whereYear('created_at', date('Y'))->sum('jumlah');
            $jumlah_peng_bln[] = $peng_bulan;
        }
        for ($bln = 01; $bln < 13; $bln++) {
            $pem_bulan = Pemasukan::whereMonth('created_at', $bln)->whereYear('created_at', date('Y'))->sum('jumlah');
            $jumlah_pem_bln[] = $pem_bulan;
        }
        $data = [
            ['bulan' => "Januari", "pemasukan" => $jumlah_trx_bln[0], "pemasukan_lainnya" => $jumlah_pem_bln[0], "pengeluaran" => $jumlah_peng_bln[0]],
            ['bulan' => "Februari", "pemasukan" => $jumlah_trx_bln[1], "pemasukan_lainnya" => $jumlah_pem_bln[1], "pengeluaran" => $jumlah_peng_bln[1]],
            ['bulan' => "Maret", "pemasukan" => $jumlah_trx_bln[2], "pemasukan_lainnya" => $jumlah_pem_bln[2], "pengeluaran" => $jumlah_peng_bln[2]],
            ['bulan' => "April", "pemasukan" => $jumlah_trx_bln[3], "pemasukan_lainnya" => $jumlah_pem_bln[3], "pengeluaran" => $jumlah_peng_bln[3]],
            ['bulan' => "Mei", "pemasukan" => $jumlah_trx_bln[4], "pemasukan_lainnya" => $jumlah_pem_bln[4], "pengeluaran" => $jumlah_peng_bln[4]],
            ['bulan' => "Juni", "pemasukan" => $jumlah_trx_bln[5], "pemasukan_lainnya" => $jumlah_pem_bln[5], "pengeluaran" => $jumlah_peng_bln[5]],
            ['bulan' => "Juli", "pemasukan" => $jumlah_trx_bln[6], "pemasukan_lainnya" => $jumlah_pem_bln[6], "pengeluaran" => $jumlah_peng_bln[6]],
            ['bulan' => "Agustus", "pemasukan" => $jumlah_trx_bln[7], "pemasukan_lainnya" => $jumlah_pem_bln[7], "pengeluaran" => $jumlah_peng_bln[7]],
            ['bulan' => "September", "pemasukan" => $jumlah_trx_bln[8], "pemasukan_lainnya" => $jumlah_pem_bln[8], "pengeluaran" => $jumlah_peng_bln[8]],
            ['bulan' => "Oktober", "pemasukan" => $jumlah_trx_bln[9], "pemasukan_lainnya" => $jumlah_pem_bln[9], "pengeluaran" => $jumlah_peng_bln[9]],
            ['bulan' => "November", "pemasukan" => $jumlah_trx_bln[10], "pemasukan_lainnya" => $jumlah_pem_bln[10], "pengeluaran" => $jumlah_peng_bln[10]],
            ['bulan' => "Desember", "pemasukan" => $jumlah_trx_bln[11], "pemasukan_lainnya" => $jumlah_pem_bln[11], "pengeluaran" => $jumlah_peng_bln[11]],
        ];
        // dd($data);

        $tanggal = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

        for ($i = 1; $i < $tanggal + 1; $i++) {
            $trx_tanggal   = Transaksi::where('tgl_bayar', '!=', null)->whereDay('updated_at', $i)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('total');
            $peng_tgl = Pengeluaran::whereDay('created_at', $i)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('jumlah');
            $pem_tgl = Pemasukan::whereDay('created_at', $i)->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('jumlah');
            $date[] = ['tanggal' => $i, 'trx_tanggal' => $trx_tanggal, 'pengeluaran' => $peng_tgl, 'pemasukan' => $pem_tgl];
        }
        return view('dashboard', compact('booking', 'kunjungan', 'product', 'pengguna', 'transaksi', 'histori', 'booking_t', 'trx_now', 'tahun', 'labels', 'jumlah_trx_bln', 'data', 'date'));
    }

    public function trx_tanggal($tanggal)
    {
        $trx_tanggal   = Transaksi::where('tgl_bayar', '!=', null)->whereDay('updated_at', $tanggal)->whereMonth('updated_at', date('m'))->whereYear('updated_at', date('Y'))->get();
        if (strlen($trx_tanggal) < 4) {
            $bookingorder = [];
        }
        foreach ($trx_tanggal as $key) {
            $bookingorder[] = Bookingorder::where('booking_id', $key->booking_id)->get();
            // foreach ($bookingorder as $order) {
            //     $data[]  = $order->product_name;
            // }
        }
        // dd($bookingorder);
        return view('admin.trx-tanggal', compact('trx_tanggal', 'tanggal', 'bookingorder'));
    }

    public function booking()
    {
        $booking = Booking::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($booking)
                ->addColumn('aksi', function ($booking) {
                    if (Auth::user()->role == 'Superadmin') {
                        # code...
                        $button = "<div class='d-flex justify-content-center align-items-center'><button class='delete btn btn-sm btn-danger w-20 me-1 mb-2' id=" . $booking->id . ">Hapus</button></div></div>";

                        return $button;
                    }
                })
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    $plat = '<a href="#" class="fw-medium text-nowrap">' . $booking->no_pol_kendaraan . ' / ' . $booking->name . '</a>';
                    return $plat;
                })
                ->editColumn('tgl_booking', function ($booking) {
                    if ($booking->tgl_proses == null && $booking->tgl_selesai == null) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Booking</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Diproses</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Selesai</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    } elseif ($booking->tgl_proses && $booking->tgl_selesai == null) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Booking</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) . '
                                    </td>
                                </tr>
                                <tr>
                                        <td style="width: 20%">Diproses</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                        ' . date('d-m-Y H:i', strtotime($booking->tgl_proses)) . '
                                        </td>
                                    </tr>
                                <tr>
                                    <td style="width: 20%">Selesai</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    }

                    return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Booking</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) . '
                                    </td>
                                </tr>
                                <tr>
                                        <td style="width: 20%">Diproses</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                        ' . date('d-m-Y H:i', strtotime($booking->tgl_proses)) . '
                                        </td>
                                    </tr>
                                <tr>
                                    <td style="width: 20%">Selesai</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    ' . date('d-m-Y H:i', strtotime($booking->tgl_selesai)) . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                })
                ->editColumn('description', function ($booking) {
                    if ($booking->bookingorder) {
                        if ($booking->status_pembayaran == 'Sudah Bayar') {
                            return '<center>
                        <table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="width: 20%">Orderan</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="orderan btn btn-sm btn-warning w-20 me-1 mb-2" id=' . $booking->id . '>Orderan</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Layanan</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            ' . $booking->description . '
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </center>';
                        }
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Orderan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    <button class="orderan btn btn-sm btn-warning w-20 me-1 mb-2" id=' . $booking->id . '>Orderan</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Layanan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->description . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    }

                    return '<center>
                <table class="table table-bordered" width="100%" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="width: 20%">Orderan</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 50%">
                                <button class="orderan btn btn-sm btn-warning w-20 me-1 mb-2" id=' . $booking->id . '>Orderan</button>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Layanan</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 50%">
                                    ' . $booking->description . '
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </center>';
                })
                ->editColumn('status', function ($booking) {
                    if ($booking->photocek && $booking->histori && $booking->status == 'Selesai') {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Pengecekan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    <div class="d-flex justify-content-center align-items-center"><button class="upload btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Foto</button><button class="pengerjaan btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Pekerjaan</button></div>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    } elseif ($booking->photocek && $booking->histori) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Pengecekan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    <div class="d-flex justify-content-center align-items-center"><button class="upload btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Foto</button><button class="pengerjaan btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Pekerjaan</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    } elseif ($booking->photocek) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Pengecekan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    <td>
                                    <div class="d-flex justify-content-center align-items-center"><button class="upload btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Foto</button></div>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    } else {
                        # code...
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Pengecekan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    }
                })
                ->editColumn('tipe_mobil', function ($booking) {
                    if ($booking->photo_tipe_mobil == null || $booking->photo_tipe_mobil == '') {
                        $tipe = '<center><img src="' . asset('image/no_photo_tipe_mobil.png') . '"  style="width: 150px; height: 100px; padding: 0px; box-sizing: border-box; "></div></center><br><center><h3>' . $booking->tipe_mobil . '</h3></center>';
                        return $tipe;
                    }
                    $tipe = '<center><img src="' . asset('storage/tipemobil/' . $booking->photo_tipe_mobil) . '" style="width: 200px" style="height: 200px"/></center><br><center><h3>' . $booking->tipe_mobil . '</h3></center>';
                    return $tipe;
                })
                ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'tipe_mobil'])
                ->make(true);
        }
        return view('admin.booking');
    }

    public function transaksi()
    {
        $booking = Booking::where('status_pembayaran', 'Sudah Bayar')->orderBy('created_at', 'ASC')->get();
        $transaksi = Transaksi::where('tgl_bayar', '!=', null)->sum('total');
        if (request()->ajax()) {
            return datatables()->of($booking)
                ->addColumn('aksi', function ($booking) {
                    if ($booking->status_pembayaran == 'Sudah Bayar' && Auth::user()->role->role == 'Superadmin') {
                        # code...
                        $button = "<div class='d-flex justify-content-center align-items-center'><button type='button' class='reset btn btn-elevated-dark w-28 me-1 mb-2' id=" . $booking->id . ">Reset Transaksi</a></div>";

                        return $button;
                    }
                })
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    return '<center>
                <table class="table table-bordered" width="100%" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="width: 20%">No. Pol Kendaraan</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 50%">
                                    ' . $booking->no_pol_kendaraan . '<br>
                                    ' . $booking->name . '
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Tipe Mobil & Warna</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 50%">
                                    ' . $booking->tipe_mobil . '
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%">No. HP</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 50%">
                                    ' . $booking->phone . '
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </center>';
                })
                ->editColumn('tgl_booking', function ($booking) {
                    if ($booking->tgl_proses == null && $booking->tgl_selesai == null) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Booking</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Diproses</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Selesai</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    } elseif ($booking->tgl_proses && $booking->tgl_selesai == null) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Booking</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) . '
                                    </td>
                                </tr>
                                <tr>
                                        <td style="width: 20%">Diproses</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                        ' . date('d-m-Y H:i', strtotime($booking->tgl_proses)) . '
                                        </td>
                                    </tr>
                                <tr>
                                    <td style="width: 20%">Selesai</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    }

                    return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Booking</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) . '
                                    </td>
                                </tr>
                                <tr>
                                        <td style="width: 20%">Diproses</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                        ' . date('d-m-Y H:i', strtotime($booking->tgl_proses)) . '
                                        </td>
                                    </tr>
                                <tr>
                                    <td style="width: 20%">Selesai</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    ' . date('d-m-Y H:i', strtotime($booking->tgl_selesai)) . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                })
                ->editColumn('description', function ($booking) {
                    $bookingorder = Bookingorder::where('booking_id', $booking->id)->get();
                    foreach ($bookingorder as $order) {
                        $data[]  = $order->product_name;
                    }
                    return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Orderan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    ' . implode(", ", $data) . '
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 20%">Total</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    ' . number_format($booking->transaksi->total, 0, ',', '.') . ' | Diskon : ' . number_format($booking->transaksi->discount, 0, ',', '.') . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </center>';
                })
                ->editColumn('status', function ($booking) {
                    if ($booking->cekmasuk && $booking->histori && $booking->cekkeluar) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Pengecekan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    <div class="d-flex justify-content-center align-items-center"><button class="cekmasuk btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Cek Masuk</button><button class="pengerjaan btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Pekerjaan</button><button class="cekkeluar btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Cek Keluar</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>';
                    } elseif ($booking->photocek && $booking->histori) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Pengecekan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                        <div class="d-flex justify-content-center align-items-center"><button class="cekmasuk btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Cek Masuk</button><button class="pengerjaan btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Pekerjaan</button></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>';
                    } elseif ($booking->cekmasuk) {
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Pengecekan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    <td>
                                    <div class="d-flex justify-content-center align-items-center"><button class="cekmasuk btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Cek Masuk</button></div>

                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    } else {
                        # code...
                        return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Pengecekan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                    <tr>
                                        <td style="width: 20%">Status Bayar</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            ' . $booking->status_pembayaran . '
                                        </td>
                                    </tr>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    }
                })
                ->addColumn('transaksi', function ($booking) {
                    if ($booking->transaksi) {
                        if ($booking->transaksi->tgl_bayar == null) {
                            return '<center>
                                    <table class="table table-bordered" width="100%" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 20%">Invoice</td>
                                                    <td style="width: 2%">:</td>
                                                    <td style="width: 50%">
                                                        ' . $booking->transaksi->invoice . '
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </center>';
                        }

                        if ($booking->transaksi->keterangan == null) {

                            return '<center>
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td style="width: 20%">Invoice</td>
                                                <td style="width: 2%">:</td>
                                                <td style="width: 50%">
                                                    ' . $booking->transaksi->invoice . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 20%">Metode Bayar</td>
                                                <td style="width: 2%">:</td>
                                                <td style="width: 50%">
                                                    ' . $booking->transaksi->metode_pembayaran . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 20%">Bukti Bayar</td>
                                                <td style="width: 2%">:</td>
                                                <td style="width: 50%">
                                                    Tidak Ada Bukti Foto
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">Tgl Bayar</td>
                                                <td style="width: 2%">:</td>
                                                <td style="width: 50%">
                                                    ' . date('d-m-Y H:i', strtotime($booking->transaksi->tgl_bayar)) . '
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </center>';
                        }

                        return '<center>
                                <table class="table table-bordered" width="100%" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td style="width: 20%">Invoice</td>
                                                <td style="width: 2%">:</td>
                                                <td style="width: 50%">
                                                    ' . $booking->transaksi->invoice . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 20%">Metode Bayar</td>
                                                <td style="width: 2%">:</td>
                                                <td style="width: 50%">
                                                    ' . $booking->transaksi->metode_pembayaran . '
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 20%">Bukti Bayar</td>
                                                <td style="width: 2%">:</td>
                                                <td style="width: 50%">
                                                    <img src="' . asset('storage/bukti-pembayaran/' . $booking->transaksi->keterangan) . '" style="width: 50px" style="height: 50px"/>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 20%">Tgl Bayar</td>
                                                <td style="width: 2%">:</td>
                                                <td style="width: 50%">
                                                    ' . date('d-m-Y H:i', strtotime($booking->transaksi->tgl_bayar)) . '
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </center>';
                    }

                    return '<center>
                    <table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 20%">Invoice</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    ' . $booking->transaksi->invoice . '
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                })
                ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'transaksi'])
                ->make(true);
        }
        return view('admin.transaksi', compact('transaksi'));
    }

    public function reset_transaksi($id)
    {
        $booking =  Booking::find($id);
        $booking->update(['status_pembayaran' => 'Belum Bayar']);
        Storage::disk('local')->delete('public/bukti-pembayaran/' . $booking->transaksi->keterangan);
        $booking->transaksi->update([
            'metode_pembayaran' => null,
            'tgl_bayar'         => null,
            'keterangan'        => null
        ]);

        return response()->json(['status' => 'sukses', 'text' => 'Transaksi ' . $booking->no_pol_kendaraan . ' berhasil direset!']);
    }

    public function histori()
    {
        $booking = Booking::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($booking)
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    $plat = '<a href="#" class="fw-medium text-nowrap">' . $booking->no_pol_kendaraan . '</a>';
                    return $plat;
                })
                ->editColumn('pengerjaan', function ($booking) {
                    if (strlen($booking->histori) < 4) {
                        return "Belum Ada Pengerjaan";
                    }
                    foreach ($booking->histori as $key) {
                        $data[] = $key->histori . '<br>';
                    }

                    return implode("<br />", $data);
                })
                ->addColumn('tanggal', function ($booking) {
                    $tgl = date('d-m-Y H:i', strtotime($booking->updated_at)) . ' WIB';
                    return $tgl;
                })
                ->addColumn('tipe_mobil', function ($booking) {
                    $mobil = $booking->tipe_mobil;
                    return $mobil;
                })

                ->rawColumns(['tanggal', 'no_pol_kendaraan', 'tipe_mobil', 'pengerjaan'])
                ->make(true);
        }
        return view('admin.histori');
    }

    public function pengeluaran_tahunan()
    {
        $pengeluaran = Pengeluaran::orderBy('created_at', 'DESC')->whereYear('created_at', date('Y'))->get();
        if (request()->ajax()) {
            return datatables()->of($pengeluaran)
                ->addColumn('aksi', function ($pengeluaran) {

                    $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=" . $pengeluaran->id . ">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=" . $pengeluaran->id . ">Hapus</button>
                </div>";

                    return $button;
                })
                ->editColumn('name', function ($pengeluaran) {
                    $name = '<a href="#" class="fw-medium text-nowrap">' . $pengeluaran->name . '</a>';
                    return $name;
                })
                ->editColumn('jumlah', function ($pengeluaran) {
                    $jumlah = '<a href="#" class="fw-medium text-nowrap">' . number_format($pengeluaran->jumlah, 0, ',', '.') . '</a>';
                    return $jumlah;
                })
                ->editColumn('created_at', function ($pengeluaran) {
                    $tgl = '<a href="#" class="fw-medium text-nowrap">' . date('d M Y H:i', strtotime($pengeluaran->created_at)) . '</a>';
                    return $tgl;
                })
                ->editColumn('foto', function ($pengeluaran) {
                    $foto = '<img src="' . asset('storage/bukti-pengeluaran/' . $pengeluaran->foto) . '" style="width: 100px" style="height: 100px"/>';
                    return $foto;
                })
                ->rawColumns(['aksi', 'jumlah', 'name', 'created_at', 'foto'])
                ->make(true);
        }
    }
}
