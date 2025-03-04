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
use Illuminate\Support\Facades\Auth;
use Validator;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LoketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $booking = Booking::where('status', '!=', 'Selesai')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($booking)

                ->addColumn('booking', function ($booking) {
                    if ($booking->status_pembayaran == 'Sudah Bayar') {
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
                                        <td style="width: 2%">Nama</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . $booking->name . '</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Orderan</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        Orderan Sudah di Bayar
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
                                        <td style="width: 2%">Status</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . $booking->status .  '</a>
                                        </td>
                                    </tr>

                                    <tr>

                                        <td colspan="3" style="width: 20%">
                                        <div class="d-flex justify-content-center align-items-center"><button class="upload btn btn-sm btn-success w-20 me-1 mb-2" id=' . $booking->id . '>Upload</button></div>
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
                                        <td style="width: 2%">Nama</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . $booking->name . '</a>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td style="width: 2%">Tipe Mobil</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . $booking->tipe_mobil . '</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Orderan</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                        <button class="orderan btn btn-sm btn-warning w-20 me-1 mb-2" id=' . $booking->id . '>Orderan</button>
                                        <a target="_blank" href='.route('cetak.qrcode', $booking->id).' class="btn btn-sm btn-dark w-20 me-1 mb-2">QR CODE</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 2%">Status</td>
                                        <td style="width: 2%">:</td>
                                        <td style="width: 20%">
                                            <a href="#" class="fw-medium text-nowrap">' . $booking->status .  '</a>
                                        </td>
                                    </tr>
                                    <tr>

                                        <td colspan="3" style="width: 20%">
                                        <div class="d-flex justify-content-center align-items-center"><button class="edit btn btn-sm btn-warning w-20 me-1 mb-2" id=' . $booking->id . '>Edit</button><button class="upload btn btn-sm btn-success w-20 me-1 mb-2" id=' . $booking->id . '>Upload</button><button class="delete btn btn-sm btn-danger w-20 me-1 mb-2" id=' . $booking->id . '>Hapus</button></div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </center>';
                })

                ->rawColumns(['booking'])
                ->make(true);
        }
        return view('loket.dashoboard');
    }

    public function getProduk()
    {
        $produk = Product::orderBy('name', 'ASC')->get();

        return response()->json(['status' => 'sukses', 'data' => $produk]);
    }

    public function orderan($id)
    {
        $booking = Booking::where('id', $id)->with('bookingorder')->first();
        if (request()->ajax()) {
            return datatables()->of($booking->bookingorder)
                ->addColumn('bookingorder', function ($book) {
                    if (Auth::user()->role->role == 'loket' || $book->booking->status_pembayaran != 'Sudah Bayar' || Auth::user()->role->role == 'kasir' || Auth::user()->role->role == 'Superadmin') {
                        return '<table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 2%">Layanan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%">
                                    <a href="#" class="fw-medium text-nowrap">' . $book->product_name . '</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 2%">Extra Layanan</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%">
                                    <a href="#" class="fw-medium text-nowrap">' . $book->extraservice_name . '</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 2%">Aksi</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%">
                                        <button class="delete_layanan btn btn-sm btn-danger w-20 me-1 mb-2" id=' . $book->id . '>Hapus</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </center>';
                    }

                    return '<table class="table table-bordered" width="100%" cellspacing="0">
                        <tbody>
                            <tr>
                                <td style="width: 2%">Layanan</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 20%">
                                <a href="#" class="fw-medium text-nowrap">' . $book->product_name . ' | ' . 'Rp. ' . number_format($book->product_price, 0, ',', '.') . '</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 2%">Extra Layanan</td>
                                <td style="width: 2%">:</td>
                                <td style="width: 20%">
                                <a href="#" class="fw-medium text-nowrap">' . $book->extraservice_name . ' | ' . 'Rp. ' . number_format($book->extraservice_price, 0, ',', '.') .  '</a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </center>';
                })

                ->rawColumns(['bookingorder'])
                ->make(true);
        }
    }

    public function bookingorder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_pol_kendaraan'  => 'required|string',
            'name'              => 'required|string',
            'tipe_mobil'        => 'nullable|string',
            'phone'             => 'required|string',
            'status_kendaraan'  => 'required|string'
        ], [
            'no_pol_kendaraan.required' => 'Isi Kolom Nomor Pol. Kendaraan',
            'name.required'             => 'Isi Kolom Nama',
            'tipe_mobil.required'       => 'Isi Tipe & Warna Mobil',
            'phone.required'            => 'Isi No. HP',
            'status_kendaraan.required' => 'Pilih Status Kendaraan'
        ]);
        if ($validator->passes()) {
            $tipemobil = Tipemobil::find($request->tipe_mobil);
            $booking = Booking::create([
                'no_pol_kendaraan' => $this->plat($request->no_pol_kendaraan),
                'name'             => ucwords($request->name),
                'tipe_mobil'       => $tipemobil == null ? null : $tipemobil->name,
                'phone'            => $request->phone,
                'tgl_booking'      => date('Y-m-d'),
                'waktu_booking'    => date('H:i'),
                'description'      => 'Visit',
                'status'           => 'Booking',
                'tgl_proses'       => now(),
                'photo_tipe_mobil' => $tipemobil == null ? null : $tipemobil->photo,
                'status_kendaraan' => $request->status_kendaraan
            ]);

            return response()->json(['text' => 'Booking ' . $booking->no_pol_kendaraan . ' berhasil.']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    private function plat($text)
    {
        $string = strtoupper(trim($text));

        $pattern = '/^([A-Z]{1,3})(\s|-)*([1-9][0-9]{0,3})(\s|-)*([A-Z]{0,3}|[1-9][0-9]{1,2})$/i';
        if (preg_match($pattern, $string)) {
            return trim(strtoupper(preg_replace($pattern, '$1 $3 $5', $string)));
        }
    }

    public function edit($id)
    {
        $booking = Booking::where('id', $id)->with('bookingorder')->first();
        return response()->json(['data' => $booking]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'no_pol_kendaraan'  => 'required|string',
            'name'              => 'required|string',
            'tipe_mobil'        => 'required|string',
            'phone'             => 'required|string',
            'status_kendaraan'  => 'required|string'
        ], [
            'no_pol_kendaraan.required' => 'Isi Kolom Nomor Pol. Kendaraan',
            'name.required'             => 'Isi Kolom Nama',
            'tipe_mobil.required'       => 'Isi Tipe & Warna Mobil',
            'phone.required'            => 'Isi No. HP',
            'status_kendaraan.required' => 'Pilih Status Kendaraan'
        ]);


        if ($validator->passes()) {
            $booking = Booking::find($id);
            $tipemobil = Tipemobil::find($request->tipe_mobil);
            $booking->update([
                'no_pol_kendaraan' => $this->plat($request->no_pol_kendaraan),
                'name'             => ucwords($request->name),
                'tipe_mobil'       => $tipemobil->name,
                'phone'            => $request->phone,
                'status_kendaraan' => $request->status_kendaraan
            ]);

            return response()->json(['text' => 'Booking ' . $booking->no_pol_kendaraan . ' berhasil diubah.']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (Auth::user()->role->role != 'Superadmin') {
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
                            </tbody>
                        </table>
                    </center>';
                })

                ->rawColumns(['histori'])
                ->make(true);
        }
    }

    public function delete_orderan($id)
    {
        $bookingorder = Bookingorder::find($id);
        $transaksi = Transaksi::where('booking_id', $bookingorder->booking_id)->first();
        if ($transaksi) {
            $transaksi->update([
                'total' => $transaksi->total - ($bookingorder->product_price + $bookingorder->extraservice_price)
            ]);
        }
        $bookingorder->delete();

        return response()->json(['text' => 'Layanan berhasil dihapus.']);
    }

    public function tambah_orderan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product'  => 'required|string',
        ], [
            'product.required' => 'Pilih Kolom Layanan',
        ]);

        if ($validator->passes()) {
            $product = Product::find($request->product);
            if ($request->extraservice == null || !$request->extraservice) {
                $bookingorder = Bookingorder::create([
                    'booking_id' => $id,
                    'product_name'  => $product->name,
                    'product_price' => $product->price
                ]);

                $transaksi = Transaksi::where('booking_id', $id)->first();
                if ($transaksi) {
                    $transaksi->update([
                        'total' => (Bookingorder::where('booking_id', $id)->sum('product_price') + Bookingorder::where('booking_id', $id)->sum('extraservice_price')) - $transaksi->discount
                    ]);
                } else {
                    Transaksi::create([
                        'booking_id'        => $id,
                        'invoice'           => date('ymd') . time(),
                        'total'             => Bookingorder::where('booking_id', $id)->sum('product_price') + Bookingorder::where('booking_id', $id)->sum('extraservice_price')
                    ]);
                }
                return response()->json(['status' => 'sukses', 'text' => 'Tambah ' . $bookingorder->product_name . ' berhasil']);
            }

            $extraservice = Extraservice::find($request->extraservice);
            $bookingorder = Bookingorder::create([
                'booking_id' => $id,
                'product_name'  => $product->name,
                'product_price' => $product->price,
                'extraservice_name' => $extraservice->name,
                'extraservice_price' => $extraservice->price,
            ]);

            $transaksi = Transaksi::where('booking_id', $id)->first();
            if ($transaksi) {
                $transaksi->update([
                    'total' => (Bookingorder::where('booking_id', $id)->sum('product_price') + Bookingorder::where('booking_id', $id)->sum('extraservice_price')) - $transaksi->discount
                ]);
            } else {
                Transaksi::create([
                    'booking_id'        => $id,
                    'invoice'           => date('ymd') . time(),
                    'total'             => Bookingorder::where('booking_id', $id)->sum('product_price') + Bookingorder::where('booking_id', $id)->sum('extraservice_price')
                ]);
            }
            return response()->json(['status' => 'sukses', 'text' => 'Tambah ' . $bookingorder->product_name . ' berhasil']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function selesai()
    {
        $booking = Booking::where('status', 'Selesai')->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
        if (request()->ajax()) {
            return datatables()->of($booking)
                ->addColumn('orderan', function ($book) {
                    $bookingorder = Bookingorder::where('booking_id', $book->id)->get();
                    foreach ($bookingorder as $order) {
                        $data[]  = $order->product_name;
                    }

                    return $data;
                })

                ->rawColumns(['orderan'])
                ->make(true);
        }
    }

    public function serah_terima()
    {
        $booking = Booking::orderBy('created_at', 'DESC')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

        if (request()->ajax()) {
            return datatables()->of($booking)
                ->addColumn('orderan', function ($book) {
                    $bookingorder = Bookingorder::where('booking_id', $book->id)->get();
                    if ($bookingorder) {
                        foreach ($bookingorder as $order) {
                            if ($order->product_name) {
                                $data[]  = $order->product_name;
                            }else {
                                $data[] = '-';
                            }
                            return $data;
                        }

                    }
                })
                ->addColumn('aksi', function ($booking) {

                    $button = "<div class='d-flex justify-content-center align-items-center'><a target='_blank' href='" . route('form.cetak', $booking->id) . "' class='cetak btn btn-elevated-dark w-28 me-1 mb-2' id=" . $booking->id . ">Cetak Form</a></div>";

                    return $button;
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
