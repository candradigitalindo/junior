<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Bookingorder;
use App\Models\Cekkeluar;
use App\Models\Cekmasuk;
use App\Models\Histori;
use App\Models\Photocek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Auth;

class PengecekanController extends Controller
{
    public function index()
    {
        // $booking = Booking::where('status', '!=', 'Booking')->where('status', '!=', 'Selesai')->orderBy('created_at', 'ASC')->with(['cekmasuk', 'histori', 'cekkeluar'])->get();
        $cekkeluar = Cekkeluar::with(['booking'])->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($cekkeluar)

                // ->addColumn('booking', function ($booking) {
                //     $bookingorder = Bookingorder::where('booking_id', $booking->id)->get();
                //     foreach ($bookingorder as $order) {
                //         $data[]  = $order->product_name;
                //     }
                //     return '<table class="table table-bordered" width="100%" cellspacing="0">
                //                 <tbody>
                //                     <tr>
                //                         <td style="width: 2%">No</td>
                //                         <td style="width: 2%">:</td>
                //                         <td style="width: 20%">
                //                         <a href="#" class="fw-medium text-nowrap">' . $booking->no_pol_kendaraan . '</a><br><a href="#" class="fw-medium text-nowrap">(' . $booking->status_kendaraan . ')</a>
                //                         </td>
                //                     </tr>
                //                     <tr>
                //                         <td style="width: 2%">Tipe</td>
                //                         <td style="width: 2%">:</td>
                //                         <td style="width: 20%">
                //                             <a href="#" class="fw-medium text-nowrap">' . $booking->tipe_mobil . '</a>
                //                         </td>
                //                     </tr>
                //                     <tr>
                //                         <td style="width: 2%">Orderan</td>
                //                         <td style="width: 2%">:</td>
                //                         <td style="width: 20%">

                //                         </td>
                //                     </tr>

                //                     <tr>
                //                         <td style="width: 2%">Tanggal</td>
                //                         <td style="width: 2%">:</td>
                //                         <td style="width: 20%">
                //                             <a href="#" class="fw-medium text-nowrap">' . date('d-m-Y', strtotime($booking->tgl_booking)) . ' ' . date('H:i', strtotime($booking->waktu_booking)) .  '</a>
                //                         </td>
                //                     </tr>

                //                     <tr>

                //                         <td colspan="3" style="width: 20%">
                //                         <div class="d-flex justify-content-center align-items-center"><button class="upload btn btn-sm btn-success w-20 me-1 mb-2" id=' . $booking->id . '>Foto</button><button class="pengerjaan btn btn-sm btn-warning w-30 me-1 mb-2" id=' . $booking->id . '>Pekerjaan</button><button class="cek_keluar btn btn-sm btn-dark w-30 me-1 mb-2" id=' . $booking->id . '>Selesai</button></div>
                //                         </td>
                //                     </tr>

                //                 </tbody>
                //             </table>
                //         </center>';
                // })

                ->addColumn('no_kendaraan', function ($cekkeluar) {
                    return "<div class='d-flex justify-content-center align-items-center'>" . $cekkeluar->booking->no_pol_kendaraan . "</div>";
                })

                ->addColumn('name', function ($cekkeluar) {
                    return "<div class='d-flex justify-content-center align-items-center'>" . $cekkeluar->booking->name . "</div>";
                })

                ->addColumn('tgl_proses', function ($cekkeluar) {
                    return "<div class='d-flex justify-content-center align-items-center'>" . date('d-m-Y H:i:s', strtotime($cekkeluar->booking->tgl_proses))  . "</div>";
                })

                ->addColumn('tgl_selesai', function ($cekkeluar) {
                    return "<div class='d-flex justify-content-center align-items-center'>" . date('d-m-Y H:i:s', strtotime($cekkeluar->created_at))  . "</div>";
                })

                ->rawColumns(['no_kendaraan', 'name', 'tgl_proses', 'tgl_selesai'])
                ->make(true);
        }
        return view('pengecekan.pengecekan');
    }

    public function cekmasuk(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'exterior'      => 'nullable|string',
            'interior'      => 'nullable|string',
            'mesin'         => 'nullable|string',
            'barang_mobil'  => 'nullable|string',
        ]);

        if ($validator->passes()) {
            $booking = Booking::find($id);
            $booking->update([
                'status'    => 'Sedang Pengerjaan'
            ]);
            $cekmasuk = Cekmasuk::create([
                'booking_id'    => $booking->id,
                'exterior'      => ucwords($request->exterior),
                'interior'      => ucwords($request->interior),
                'mesin'         => ucwords($request->mesin),
                'barang_mobil'  => ucwords($request->barang_mobil)
            ]);

            return response()->json(['text' => 'Cek masuk ' . $booking->no_pol_kendaraan . ' berhasil.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function qury_cekmasuk($id)
    {
        $booking = Booking::find($id);
        $booking->update([
            'status'    => 'Selesai',
            'tgl_selesai' => now()
        ]);
        Histori::create([
            'booking_id' => $booking->id,
            'histori'    => 'Selesai Pekerjaan'
        ]);
        return response()->json(['text' => 'Pengecekan kendaraan ' . $booking->no_pol_kendaraan . ' berhasil.']);
    }

    public function cekkeluar(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'exterior'      => 'nullable|string',
        //     'interior'      => 'nullable|string',
        //     'mesin'         => 'nullable|string',
        //     'barang_mobil'  => 'nullable|string',
        // ]);
        $validator = Validator::make($request->all(), [
            'barcode'      => 'required',
        ]);

        if ($validator->passes()) {
            $booking = Booking::find($request->barcode);
            $booking->update([
                'status'    => 'Selesai',
                'tgl_selesai' => now()
            ]);
            Cekkeluar::create([
                'booking_id'    => $booking->id,
            ]);

            return response()->json(['text' => 'Cek Selesai ' . $booking->no_pol_kendaraan . ' berhasil.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function show_photocek($id)
    {
        $booking = Booking::where('id', $id)->with('photocek')->orderBy('created_at', 'DESC')->first();
        if (request()->ajax()) {
            return datatables()->of($booking->photocek)
                // ->addColumn('aksi', function ($book) {

                //     $button = "<div class='d-flex justify-content-center align-items-center'>
                // <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=" . $book->id . ">Hapus</button>
                // </div>";

                //     return $button;
                // })
                ->editColumn('photo', function ($book) {

                    // $foto = '<center><img src="' . asset('storage/photocek/' . $book->photo) . '" style="width: 200px" style="height: 200px"/></center>';
                    // return $foto;
                    if (Auth::user()->role->role == 'loket') {
                        return '<table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="width: 2%">Foto</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        <img src="' . asset('storage/photocek/' . $book->photo) . '" style="width: 200px" style="height: 200px"/></center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Nama</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            ' . $book->name . '
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Aksi</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        <button class="delete_photo btn btn-elevated-danger w-24 me-1 mb-2" id=' . $book->id . '>Hapus</button>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>';
                    }

                    return '<table class="table table-bordered" width="100%" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="width: 2%">Foto</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        <img src="' . asset('storage/photocek/' . $book->photo) . '" style="width: 200px" style="height: 200px"/></center>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Nama</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            ' . $book->name . '
                                        </td>
                                    </tr>
                                </tbody>
                            </table>';
                })
                ->rawColumns(['photo'])
                ->make(true);
        }
    }

    public function post_photo_cek(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'photo'      => 'required|image|mimes:jpeg,png,jpg',
            'name_photo' => 'required|string'
        ], [
            'photo.required'       => 'Isi Kolom Foto',
            'photo.image'          => 'File harus berupa gambar',
            'photo.mimes'          => 'File harus berupa jpeg,png,jpg',
            'name_photo.required'  => 'Isi Nama Foto'
        ]);

        if ($validator->passes()) {

            $img = $request->file('photo');
            $img->storeAs('public/photocek', $img->hashName());
            $booking = Booking::where('id', $id)->with('histori')->first();
            $booking->update(['status' => 'Proses']);
            Photocek::create(['booking_id' => $booking->id, 'photo' => $img->hashName(), 'name' => ucwords($request->name_photo)]);
            return response()->json(['text' => 'Photo berhasil ditambah.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function delete($id)
    {
        $photo = Photocek::find($id);
        Storage::disk('local')->delete('public/photocek/' . $photo->photo);
        $photo->delete();
        return response()->json(['text' => 'Foto berhasil dihapus.']);
    }
}
