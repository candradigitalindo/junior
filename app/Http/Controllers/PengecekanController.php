<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Cekkeluar;
use App\Models\Cekmasuk;
use App\Models\Histori;
use App\Models\Photocek;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PengecekanController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            // Optimization: Eager load booking and select only needed columns
            $query = Cekkeluar::with('booking')->orderBy('created_at', 'DESC');

            return datatables()->of($query)
                ->addColumn('no_kendaraan', function ($ck) {
                    return "<div class='text-center fw-bold text-theme-1'>" . ($ck->booking->no_pol_kendaraan ?? '-') . "</div>";
                })
                ->addColumn('name', function ($ck) {
                    return "<div class='text-center'>" . ($ck->booking->name ?? '-') . "</div>";
                })
                ->addColumn('tgl_proses', function ($ck) {
                    return "<div class='text-center small'>" . ($ck->booking->tgl_proses ? date('d-m-Y H:i', strtotime($ck->booking->tgl_proses)) : '-') . "</div>";
                })
                ->addColumn('tgl_selesai', function ($ck) {
                    return "<div class='text-center small fw-medium'>" . $ck->created_at->format('d-m-Y H:i') . "</div>";
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
            if (!$booking) return response()->json(['status' => 'error', 'text' => 'Data tidak ditemukan']);

            $booking->update(['status' => 'Sedang Pengerjaan']);
            Cekmasuk::create([
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

    public function selesaiPengecekan($id)
    {
        $booking = Booking::find($id);
        if ($booking) {
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
        return response()->json(['status' => 'error', 'text' => 'Data tidak ditemukan']);
    }

    public function cekkeluar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required',
        ]);

        if ($validator->passes()) {
            $booking = Booking::find($request->barcode);
            if (!$booking) {
                return response()->json(['status' => 'error', 'text' => 'Data Booking tidak ditemukan.']);
            }
            $booking->update([
                'status'    => 'Selesai',
                'tgl_selesai' => now()
            ]);
            Cekkeluar::create(['booking_id' => $booking->id]);

            return response()->json(['text' => 'Cek Selesai ' . $booking->no_pol_kendaraan . ' berhasil.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function show_photocek($id)
    {
        if (request()->ajax()) {
            $booking = Booking::with('photocek')->find($id);
            if (!$booking) return datatables()->of([])->make(true);

            return datatables()->of($booking->photocek)
                ->editColumn('photo', function($p) {
                    $url = asset('storage/photocek/'.$p->photo);
                    return '
                    <div class="d-flex align-items-center gap-4 p-3 border rounded-3 bg-white shadow-sm mb-2">
                        <div class="flex-none">
                            <a href="'.$url.'" target="_blank" title="Klik untuk memperbesar">
                                <img src="'.$url.'" class="rounded-2 shadow-sm" style="width: 120px; height: 80px; object-fit: cover; cursor: zoom-in;"/>
                            </a>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold text-dark fs-base mb-1">'.e($p->name ?: 'Tanpa Keterangan').'</div>
                            <div class="text-muted small">Diunggah: '.$p->created_at->format('d M Y H:i').'</div>
                        </div>
                        <div class="flex-none">
                            <button class="delete_photo btn btn-sm btn-outline-danger" data-id="'.$p->id.'" title="Hapus foto">
                                <i data-feather="trash-2" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>';
                })
                ->rawColumns(['photo'])
                ->make(true);
        }
    }

    public function post_photo_cek(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'photo'      => 'required|image|max:10240', // Max 10MB to allow high-res original
            'name'       => 'required|string',
        ], [
            'photo.max' => 'Ukuran file terlalu besar. Maksimal 10MB.',
            'photo.image' => 'File harus berupa gambar.',
        ]);

        if ($validator->passes()) {
            $file = $request->file('photo');
            $fileName = $file->hashName();
            
            // Image Processing
            $img = Image::make($file->path());
            
            // Resize if width > 1200px, maintain aspect ratio
            $img->resize(1200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Ensure directory exists
            if (!Storage::disk('public')->exists('photocek')) {
                Storage::disk('public')->makeDirectory('photocek');
            }

            // Save with 85% quality for balance between size and sharpness
            $img->save(storage_path('app/public/photocek/' . $fileName), 85);

            Photocek::create([
                'booking_id' => $id,
                'photo'      => $fileName,
                'name'       => ucwords($request->name)
            ]);

            return response()->json(['text' => 'Photo berhasil diunggah dengan optimasi web.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function delete($id)
    {
        $photocek = Photocek::find($id);
        if ($photocek) {
            // Delete from storage
            if (Storage::disk('public')->exists('photocek/' . $photocek->photo)) {
                Storage::disk('public')->delete('photocek/' . $photocek->photo);
            }
            
            $photocek->delete();
            return response()->json(['text' => 'Photo berhasil dihapus.']);
        }
        return response()->json(['status' => 'error', 'text' => 'Data tidak ditemukan']);
    }
}
