<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class TagihanController extends Controller
{
    public function index()
    {
        $booking = Booking::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->where('status_pembayaran', 'Belum Bayar')->orderBy('created_at', 'DESC')->with('cekmasuk')->get();
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
        return view('kasir.tagihan');
    }
}
