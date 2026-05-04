<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\Facades\Image;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        if (request()->ajax()) {
            $query = Pengeluaran::query()
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
        return view('kasir.pengeluaran');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'jumlah'            => 'required|numeric',
            'foto_pengeluaran'  => 'required|image|max:10240'
        ], [
            'name.required'             => 'Isi kolom keterangan',
            'jumlah.required'           => 'Isi jumlah pengeluaran',
            'foto_pengeluaran.required' => 'Foto Bukti Pengeluaran',
            'foto_pengeluaran.max'      => 'Ukuran file maksimal 10MB'
        ]);

        if ($validator->passes()) {
            $file = $request->file('foto_pengeluaran');
            $fileName = $file->hashName();
            
            // Image Processing
            $img = Image::make($file->path());
            $img->resize(1000, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            if (!Storage::disk('public')->exists('bukti-pengeluaran')) {
                Storage::disk('public')->makeDirectory('bukti-pengeluaran');
            }

            $img->save(storage_path('app/public/bukti-pengeluaran/' . $fileName), 85);

            $pengeluaran = Pengeluaran::create([
                'name'  => ucwords($request->name),
                'jumlah' => $request->jumlah,
                'foto'  => $fileName
            ]);

            return response()->json(['text' => 'Pengeluaran ' . $pengeluaran->name . ' berhasil ditambahkan']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function edit($id)
    {
        return response()->json(['data' => Pengeluaran::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'editname'              => 'required|string',
            'editjumlah'            => 'required|numeric',
            'editfoto_pengeluaran'  => 'nullable|image|max:10240'
        ], [
            'editname.required'             => 'Isi kolom keterangan',
            'editjumlah.required'           => 'Isi jumlah pengeluaran',
            'editfoto_pengeluaran.max'      => 'Ukuran file maksimal 10MB'
        ]);

        if ($validator->passes()) {
            $pengeluaran = Pengeluaran::find($id);
            $updateData = [
                'name'  => ucwords($request->editname),
                'jumlah' => $request->editjumlah,
            ];

            if ($request->hasFile('editfoto_pengeluaran')) {
                // Delete old photo
                if ($pengeluaran->foto && Storage::disk('public')->exists('bukti-pengeluaran/' . $pengeluaran->foto)) {
                    Storage::disk('public')->delete('bukti-pengeluaran/' . $pengeluaran->foto);
                }

                $file = $request->file('editfoto_pengeluaran');
                $fileName = $file->hashName();
                
                // Image Processing
                $img = Image::make($file->path());
                $img->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $img->save(storage_path('app/public/bukti-pengeluaran/' . $fileName), 85);
                $updateData['foto'] = $fileName;
            }

            $pengeluaran->update($updateData);

            return response()->json(['text' => 'Pengeluaran ' . $pengeluaran->name . ' berhasil diubah']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        if ($pengeluaran->foto && Storage::disk('public')->exists('bukti-pengeluaran/' . $pengeluaran->foto)) {
            Storage::disk('public')->delete('bukti-pengeluaran/' . $pengeluaran->foto);
        }
        $pengeluaran->delete();
        return response()->json(['text' => 'Pengeluaran ' . $pengeluaran->name . ' berhasil dihapus']);
    }
}
