<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bookingorder;
use App\Models\Histori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index()
    {
        $booking = Booking::where('status_kendaraan', 'Ditunggu')->where('status', '!=', 'Booking')->where('status', '!=', 'Selesai')->orderBy('created_at', 'ASC')->with('histori')->get();
        if (request()->ajax()) {
            return datatables()->of($booking)
                ->editColumn('no_pol_kendaraan', function ($booking) {
                    $plat = '<a href="#" class="fw-medium text-nowrap">' . $booking->no_pol_kendaraan . '</a>';
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

                            </tbody>
                        </table>
                    </center>';
                })
                ->editColumn('description', function ($booking) {
                    $orderan = Bookingorder::where('booking_id', $booking->id)->first();
                    return '<center>
                <table class="table table-bordered" width="100%" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="width: 20%">Orderan</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 50%">
                                    ' . $orderan->product_name . '
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
                    if ($booking->photocek && $booking->histori->first()) {
                        $histori = Histori::where('booking_id', $booking->id)->orderBy('created_at', 'DESC')->first();
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
                                    <td style="width: 20%">Pengerjaan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">
                                    ' . $histori->histori . '
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    } elseif ($booking->cekmasuk) {
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
                                    <td style="width: 20%">Pengerjaan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    } else {
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
                                    <td style="width: 20%">Pengerjaan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 50%">

                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                    }
                })
                ->editColumn('tipe_mobil', function ($booking) {
                    $url = $booking->photo_tipe_mobil ? asset('storage/tipemobil/' . $booking->photo_tipe_mobil) : asset('image/no_photo_tipe_mobil.png');
                    $tipe = '<center><img src="' . $url . '" style="width: 150px; height: auto;"/></center><br><center><h3>' . $booking->tipe_mobil . '</h3></center>';
                    return $tipe;
                })
                ->rawColumns(['aksi', 'no_pol_kendaraan', 'tgl_booking', 'description', 'status', 'tipe_mobil'])
                ->make(true);
        }
        return view('listing.listing');
    }
}
