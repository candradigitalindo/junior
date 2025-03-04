<?php

namespace App\Http\Controllers;

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

class KasirController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            // dd($request->all());
            if (!empty($request->start_date)) {
                $booking = Booking::orderBy('created_at', 'DESC')->whereDate('created_at', '>=', $request->start_date)->whereDate('created_at', '<=', $request->end_date)->with(['cekmasuk', 'transaksi', 'bookingorder'])->get();
                // return response()->json($booking);
                return datatables()->of($booking)
                    ->addColumn('aksi', function ($booking) {
                        if ($booking->status_pembayaran == 'Sudah Bayar') {
                            # code...
                            $button = "<div class='d-flex justify-content-center align-items-center'><a target='_blank' href='" . route('invoice.cetak', $booking->id) . "' class='cetak btn btn-elevated-dark w-28 me-1 mb-2' id=" . $booking->id . ">Cetak Invoice</a></div>";

                            return $button;
                        } else {
                            # code...
                            $button = "<div class='d-flex justify-content-center align-items-center'><button class='bayar btn btn-elevated-warning w-28 me-1 mb-2' id=" . $booking->id . ">Proses Bayar</button></div>";

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
                                        ' . $booking->no_pol_kendaraan . '</a><br><a href="#" class="fw-medium text-nowrap">(' . $booking->status_kendaraan . ')</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Nama</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
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
                        if ($booking->bookingorder != null) {
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
                                        <td style="width: 20%">Total</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            ' . number_format($booking->transaksi == null ? 0 : $booking->transaksi->total, 0, ',', '.') . ' | Diskon : ' . number_format($booking->transaksi == null ? 0 : $booking->transaksi->discount, 0, ',', '.') . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Diskon</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Diskon</button><button class="reset_diskon btn btn-sm btn-dark w-24 me-1 mb-2" id=' . $booking->id . '>Reset</button>
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
                                        <td style="width: 20%">Total</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                        ' .  $booking->transaksi == null ? 0 : number_format($booking->transaksi->total, 0, ',', '.') . ' | Diskon : ' . number_format($booking->transaksi->discount, 0, ',', '.') . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Diskon</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Diskon</button><button class="reset_diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Reset</button>
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Status Bayar</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            ' . $booking->status_pembayaran . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Informasi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="panggil btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Panggilan</button>

                                            <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>';
                        } elseif ($booking->photocek && $booking->histori && $booking->status == 'Sedang Pengerjaan') {
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
                                    <tr>
                                        <td style="width: 20%">Informasi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="informasi btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Informasi</button>
                                            <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>';
                        } elseif ($booking->photocek != null) {
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
                                    <tr>
                                        <td style="width: 20%">Informasi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="panggil btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Panggilan</button>

                                            <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>
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
                                    <tr>
                                        <td style="width: 20%">Informasi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="panggil btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Panggilan</button>

                                            <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </center>';
                        }
                    })
                    ->addColumn('transaksi', function ($booking) {
                        if ($booking->transaksi != null) {
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
                    })
                    ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'transaksi'])
                    ->make(true);
            } else {
                $booking = Booking::whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('created_at', 'DESC')->with('cekmasuk')->get();
                return datatables()->of($booking)
                    ->addColumn('aksi', function ($booking) {
                        if ($booking->status_pembayaran == 'Sudah Bayar') {
                            # code...
                            $button = "<div class='d-flex justify-content-center align-items-center'><a target='_blank' href='" . route('invoice.cetak', $booking->id) . "' class='cetak btn btn-elevated-dark w-28 me-1 mb-2' id=" . $booking->id . ">Cetak Invoice</a></div>";

                            return $button;
                        } else {
                            # code...
                            $button = "<div class='d-flex justify-content-center align-items-center'><button class='bayar btn btn-elevated-warning w-28 me-1 mb-2' id=" . $booking->id . ">Proses Bayar</button></div>";

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
                                        ' . $booking->no_pol_kendaraan . '</a><br><a href="#" class="fw-medium text-nowrap">(' . $booking->status_kendaraan . ')</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Nama</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
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
                        if ($booking->bookingorder) {
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
                                        <td style="width: 20%">Total</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            ' . number_format($booking->transaksi->total, 0, ',', '.') . ' | Diskon : ' . number_format($booking->transaksi->discount, 0, ',', '.') . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Diskon</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Diskon</button><button class="reset_diskon btn btn-sm btn-dark w-24 me-1 mb-2" id=' . $booking->id . '>Reset</button>
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
                                        <td style="width: 20%">Total</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                        ' . number_format($booking->transaksi->total, 0, ',', '.') . ' | Diskon : ' . number_format($booking->transaksi->discount, 0, ',', '.') . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Diskon</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Diskon</button><button class="reset_diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Reset</button>
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
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Status Bayar</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            ' . $booking->status_pembayaran . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Informasi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="panggil btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Panggilan</button>

                                            <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </center>';
                        } elseif ($booking->photocek && $booking->histori && $booking->status == 'Sedang Pengerjaan') {
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
                                        <td style="widh:20%">
                                                <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 20%">Informasi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 50%">
                                            <button class="panggil btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Panggilan</button>

                                            <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>
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
                                    <tr>
                                    <td style="width: 20%">Informasi</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        <button class="panggil btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Panggilan</button>

                                        <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>
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
                    })
                    ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'transaksi'])
                    ->make(true);
            }
        }
        return view('kasir.kasir');
    }

    public function bayar(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'metode_pembayaran' => 'required|string',
            'foto_pembayaran'   => 'nullable|image',
        ], [
            'metode_pembayaran.required' => 'Pilih Metode Pembayaran',
            'foto_pembayaran.required'   => 'Upload Bukti Pembayaran'
        ]);

        if ($validator->passes()) {
            if ($request->foto_pembayaran) {
                $booking = Booking::where('id', $id)->with('bookingorder')->first();
                $booking->update(['status_pembayaran' => 'Sudah Bayar']);
                $img = $request->file('foto_pembayaran');
                $img->storeAs('public/bukti-pembayaran', $img->hashName());

                $booking->transaksi->update([
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'keterangan'        => $img->hashName(),
                    'tgl_bayar'         => now()
                ]);

                return response()->json(['text' => 'Transaksi ' . $booking->no_pol_kendaraan . ' sukses diproses']);
            }

            $booking = Booking::where('id', $id)->with('bookingorder')->first();
            $booking->update(['status_pembayaran' => 'Sudah Bayar']);
            $booking->transaksi->update([
                'metode_pembayaran' => $request->metode_pembayaran,
                'tgl_bayar'         => now()
            ]);

            return response()->json(['text' => 'Transaksi ' . $booking->no_pol_kendaraan . ' sukses diproses']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function diskon(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'diskon'  => 'required|string|min:0',
        ], [
            'diskon.required'  => 'Isi Kolom Diskon',
            'diskon.min'       => 'Minimal Diskon 0'
        ]);

        if ($validator->passes()) {
            $booking = Booking::where('id', $id)->with('bookingorder')->first();
            if ($booking->status_pembayaran == 'Sudah Bayar') {
                return response()->json(['status' => 'gagal', 'text' => 'Gagal di update, Booking ' . $booking->no_pol_kendaraan . ' sudah terbayar']);
            }
            $booking->transaksi->update(['discount' => $request->diskon, 'total' => $booking->transaksi->total - $request->diskon]);
            return response()->json(['status' => 'sukses', 'text' => 'Diskon ' . $booking->no_pol_kendaraan . ' sebesar ' . number_format($request->diskon, 0, ',', '.') . ' sukses diproses']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function reset_dikon($id)
    {
        $booking = Booking::where('id', $id)->with('bookingorder')->first();
        if ($booking->status_pembayaran == 'Sudah Bayar') {
            return response()->json(['status' => 'gagal', 'text' => 'Gagal di update, Booking ' . $booking->no_pol_kendaraan . ' sudah terbayar']);
        }
        $booking->transaksi->update([
            'discount'      => 0,
            'total'         => ($booking->bookingorder->sum('product_price') + $booking->bookingorder->sum('extraservice_price'))
        ]);

        return response()->json(['status' => 'sukses', 'text' => 'Reset Diskon berhasil']);
    }

    public function dashboard()
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
        for ($bulan = 01; $bulan < 13; $bulan++) {
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
        return view('kasir.dashboard', compact('booking', 'kunjungan', 'product', 'pengguna', 'transaksi', 'histori', 'booking_t', 'trx_now', 'tahun', 'labels', 'jumlah_trx_bln', 'data', 'date'));
    }

    public function filter(Request $request)
    {
        dd($request->strat_date);
        $booking = Booking::where('created_at', $request->start_date)->where('created_at', $request->end_date)->orderBy('created_at', 'DESC')->with('cekmasuk')->get();
        if (request()->ajax()) {
            return datatables()->of($booking)
                ->addColumn('aksi', function ($booking) {
                    if ($booking->status_pembayaran == 'Sudah Bayar') {
                        # code...
                        $button = "<div class='d-flex justify-content-center align-items-center'><a target='_blank' href='" . route('invoice.cetak', $booking->id) . "' class='cetak btn btn-elevated-dark w-28 me-1 mb-2' id=" . $booking->id . ">Cetak Invoice</a></div>";

                        return $button;
                    } else {
                        # code...
                        $button = "<div class='d-flex justify-content-center align-items-center'><button class='bayar btn btn-elevated-warning w-28 me-1 mb-2' id=" . $booking->id . ">Proses Bayar</button></div>";

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
                                    ' . $booking->no_pol_kendaraan . '</a><br><a href="#" class="fw-medium text-nowrap">(' . $booking->status_kendaraan . ')</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 20%">Nama</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 50%">
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
                    if ($booking->bookingorder) {
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
                                    <td style="width: 20%">Total</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . number_format($booking->transaksi->total, 0, ',', '.') . ' | Diskon : ' . number_format($booking->transaksi->discount, 0, ',', '.') . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Diskon</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        <button class="diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Diskon</button><button class="reset_diskon btn btn-sm btn-dark w-24 me-1 mb-2" id=' . $booking->id . '>Reset</button>
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
                                    <td style="width: 20%">Total</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    ' . number_format($booking->transaksi->total, 0, ',', '.') . ' | Diskon : ' . number_format($booking->transaksi->discount, 0, ',', '.') . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Diskon</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        <button class="diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Diskon</button><button class="reset_diskon btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Reset</button>
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
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Status Bayar</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        ' . $booking->status_pembayaran . '
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 20%">Informasi</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        <button class="panggil btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Panggilan</button>

                                        <button id=' . $booking->id . ' class="whatsapp btn btn-sm btn-success w-20 me-1 mb-2">Kirim WA</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>';
                    } elseif ($booking->photocek && $booking->histori && $booking->status == 'Sedang Pengerjaan') {
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
                                <tr>
                                    <td style="width: 20%">Informasi</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                        <button class="informasi btn btn-sm btn-dark w-20 me-1 mb-2" id=' . $booking->id . '>Informasi</button>

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
                })
                ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'transaksi'])
                ->make(true);
        }
    }
}
