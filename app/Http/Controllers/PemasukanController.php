<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\Facades\Image;

class PemasukanController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        if (request()->ajax()) {
            $query = Pemasukan::query()
                ->when($start && $end, function ($q) use ($start, $end) {
                    $q->whereDate('created_at', '>=', $start)
                      ->whereDate('created_at', '<=', $end);
                }, function ($q) {
                    $q->whereMonth('created_at', now()->month)
                      ->whereYear('created_at', now()->year);
                })
                ->orderBy('created_at', 'DESC');
            
            $totalSum = (clone $query)->sum('jumlah') ?: 0;
            
            return datatables()->of($query)
                ->editColumn('created_at', function ($p) {
                    return $p->created_at->format('Y-m-d H:i:s');
                })
                ->with('totalSum', $totalSum)
                ->make(true);
        }
        return view('kasir.pemasukan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'            => 'required|string',
            'jumlah'          => 'required|numeric',
            'foto_pemasukan'  => 'required|image|max:10240'
        ], [
            'name.required'           => 'Isi kolom keterangan',
            'jumlah.required'         => 'Isi jumlah',
            'foto_pemasukan.required' => 'Isi Foto Bukti',
            'foto_pemasukan.max'      => 'Ukuran file maksimal 10MB'
        ]);

        if ($validator->passes()) {
            $file = $request->file('foto_pemasukan');
            $fileName = $file->hashName();
            
            // Image Processing
            $img = Image::make($file->path());
            $img->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if (!Storage::disk('public')->exists('bukti-pemasukan')) {
                Storage::disk('public')->makeDirectory('bukti-pemasukan');
            }

            $img->save(storage_path('app/public/bukti-pemasukan/' . $fileName), 85);

            $pemasukan = Pemasukan::create([
                'name'  => ucwords($request->name),
                'jumlah' => $request->jumlah,
                'foto'  => $fileName
            ]);

            return response()->json(['text' => 'Pemasukan ' . $pemasukan->name . ' berhasil ditambahkan']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function edit($id)
    {
        return response()->json(['data' => Pemasukan::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'editname'              => 'required|string',
            'editjumlah'            => 'required|numeric',
            'editfoto_pemasukan'  => 'nullable|image|max:10240'
        ], [
            'editname.required'     => 'Isi kolom keterangan',
            'editjumlah.required'   => 'Isi jumlah',
            'editfoto_pemasukan.max' => 'Ukuran file maksimal 10MB'
        ]);

        if ($validator->passes()) {
            $pemasukan = Pemasukan::find($id);
            $updateData = [
                'name'  => ucwords($request->editname),
                'jumlah' => $request->editjumlah,
            ];

            if ($request->hasFile('editfoto_pemasukan')) {
                // Delete old photo
                if ($pemasukan->foto && Storage::disk('public')->exists('bukti-pemasukan/' . $pemasukan->foto)) {
                    Storage::disk('public')->delete('bukti-pemasukan/' . $pemasukan->foto);
                }

                $file = $request->file('editfoto_pemasukan');
                $fileName = $file->hashName();
                
                // Image Processing
                $img = Image::make($file->path());
                $img->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save(storage_path('app/public/bukti-pemasukan/' . $fileName), 85);
                $updateData['foto'] = $fileName;
            }

            $pemasukan->update($updateData);

            return response()->json(['text' => 'Pemasukan ' . $pemasukan->name . ' berhasil diubah']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $pemasukan = Pemasukan::find($id);
        if ($pemasukan->foto && Storage::disk('public')->exists('bukti-pemasukan/' . $pemasukan->foto)) {
            Storage::disk('public')->delete('bukti-pemasukan/' . $pemasukan->foto);
        }
        $pemasukan->delete();
        return response()->json(['text' => 'Pemasukan ' . $pemasukan->name . ' berhasil dihapus']);
    }
}
