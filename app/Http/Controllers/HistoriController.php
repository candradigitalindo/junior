<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bookingorder;
use App\Models\Histori;
use App\Models\Stepproduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class HistoriController extends Controller
{
    public function index()
    {
        $booking = Booking::where('status', '!=', 'Booking')->where('status', '!=', 'Selesai')->orderBy('waktu_selesai_booking', 'ASC')->orderBy('tgl_selesai_booking', 'ASC')->get();
        if (request()->ajax()) {
            return datatables()->of($booking)
                ->addColumn('booking', function ($booking) {
                    $bookingorder = Bookingorder::where('booking_id', $booking->id)->get();
                    foreach ($bookingorder as $order) {
                        $data[]  = $order->product_name;
                    }
                    if ($booking->tgl_selesai_booking == null) {

                        return '<table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="width: 2%">No</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        <a href="#" class="fw-medium text-nowrap">' . $booking->no_pol_kendaraan . '</a><br><a href="#" class="fw-medium text-nowrap">(' . $booking->status_kendaraan . ')</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Tipe</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . $booking->tipe_mobil . '</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Orderan</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        ' . implode(", ", $data) . '
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width: 2%">Tanggal</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) .  '</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Estimasi Selesai</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">Belum Ada</a>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="3" style="width: 20%">
                                        <div class="d-flex justify-content-center align-items-center"><button class="upload btn btn-sm btn-success w-20 me-1 mb-2" id=' . $booking->id . '>Foto</button><button class="waktu btn btn-sm btn-dark w-30 me-1 mb-2" id=' . $booking->id . '>Waktu</button><button class="pekerjaan btn btn-sm btn-warning w-30 me-1 mb-2" id=' . $booking->id . '>Pekerjaan</button></div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </center>';
                    }

                    return '<table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="width: 2%">No</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        <a href="#" class="fw-medium text-nowrap">' . $booking->no_pol_kendaraan . '</a><br><a href="#" class="fw-medium text-nowrap">(' . $booking->status_kendaraan . ')</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">No WA</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . $booking->phone . '</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Orderan</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        ' . implode(", ", $data) . '
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width: 2%">Tanggal</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) .  '</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Estimasi Selesai</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . date('d-m-Y', strtotime($booking->tgl_selesai_booking)) . ' ' . date('H:i', strtotime($booking->waktu_selesai_booking)) .  '</a>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="3" style="width: 20%">
                                        <div class="d-flex justify-content-center align-items-center"><button class="upload btn btn-sm btn-success w-20 me-1 mb-2" id=' . $booking->id . '>Foto</button><button class="waktu btn btn-sm btn-dark w-30 me-1 mb-2" id=' . $booking->id . '>Waktu</button><button class="pekerjaan btn btn-sm btn-warning w-24 me-1 mb-2" id=' . $booking->id . '>Pekerjaan</button></div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </center>';
                })

                ->rawColumns(['booking'])
                ->make(true);
        }
        return view('histori.histori');
    }

    public function show($id)
    {
        $booking = Booking::where('id', $id)->with('histori')->orderBy('created_at', 'DESC')->first();
        if (request()->ajax()) {
            return datatables()->of($booking->histori)
                ->addColumn('histori', function ($book) {
                    return '<table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 2%">Status</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%">
                                    <a href="#" class="fw-medium text-nowrap">' . $book->histori . '</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 2%">Tanggal</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%">
                                        ' . date('d-m-Y H:i', strtotime($book->created_at)) . ' WIB
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 2%">Aksi</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%">
                                    <button class="hapus btn btn-elevated-danger w-25 me-1 mb-2" id=' . $book->id . '>Hapus</button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';
                })

                ->rawColumns(['histori'])
                ->make(true);
        }
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'histori'       => 'required|string',
        ], [
            'histori.required'  => 'Isi Kolom Update Pekerjaan'
        ]);

        if ($validator->passes()) {
            $booking = Booking::where('id', $id)->with('histori')->first();
            $booking->update([
                'status'    => 'Sedang Pengerjaan'
            ]);
            // $step    = Stepproduct::find($request->histori);
            Histori::create([
                'booking_id' => $booking->id,
                'histori'    => $request->histori
            ]);

            return response()->json(['text' => 'Update Pekerjaan ' . $booking->no_pol_kendaraan . ' berhasil.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $histori = Histori::find($id);
        $histori->delete();
        return response()->json(['text' => 'Pekerjaan ' . $histori->histori . ' terhapus.']);
    }

    public function update_waktu(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'tgl_selesai_booking'       => 'required|string',
            'waktu_selesai_booking'     => 'required|string',
        ], [
            'tgl_selesai_booking.required'  => 'Isi Kolom Tgl. Selesai',
            'waktu_selesai_booking.required' => 'Isi kolom Waktu Selesai'
        ]);

        if ($validator->passes()) {
            $booking = Booking::find($id);
            $booking->update(['tgl_selesai_booking' => $request->tgl_selesai_booking, 'waktu_selesai_booking' => $request->waktu_selesai_booking]);
            return response()->json(['text' => 'Booking ' . $booking->no_pol_kendaraan . ' terupdate.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }
}
