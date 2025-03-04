<?php

namespace App\Http\Controllers;

use App\Models\Pemasukan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class PemasukanController extends Controller
{
    public function index()
    {
        $pemasukan = Pemasukan::whereYear('created_at', date('Y'))->orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($pemasukan)
                ->addColumn('aksi', function ($pemasukan) {

                    $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=" . $pemasukan->id . ">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=" . $pemasukan->id . ">Hapus</button>
                </div>";

                    return $button;
                })
                ->editColumn('name', function ($pemasukan) {
                    $name = '<a href="#" class="fw-medium text-nowrap">' . $pemasukan->name . '</a>';
                    return $name;
                })
                ->editColumn('jumlah', function ($pemasukan) {
                    $jumlah = '<a href="#" class="fw-medium text-nowrap">' . number_format($pemasukan->jumlah, 0, ',', '.') . '</a>';
                    return $jumlah;
                })
                ->editColumn('created_at', function ($pemasukan) {
                    $tgl = '<a href="#" class="fw-medium text-nowrap">' . date('d M Y H:i', strtotime($pemasukan->created_at)) . '</a>';
                    return $tgl;
                })
                ->editColumn('foto', function ($pemasukan) {
                    $foto = '<img src="' . asset('storage/bukti-pemasukan/' . $pemasukan->foto) . '" style="width: 100px" style="height: 100px"/>';
                    return $foto;
                })
                ->rawColumns(['aksi', 'jumlah', 'name', 'created_at', 'foto'])
                ->make(true);
        }
        return view('kasir.pemasukan');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'jumlah'            => 'required|string',
            'foto_pemasukan'  => 'required|image'
        ], [
            'name.required'     => 'Isi kolom keterangan',
            'jumlah.required'   => 'Isi jumlah',
            'foto_pemasukan.required' => 'Isi Foto Bukti'
        ]);

        if ($validator->passes()) {

            $img = $request->file('foto_pemasukan');
            $img->storeAs('public/bukti-pemasukan', $img->hashName());
            $pemasukan = Pemasukan::create([
                'name'  => ucwords($request->name),
                'jumlah' => $request->jumlah,
                'foto'  => $img->hashName()
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
            'editjumlah'            => 'required|string',
            'editfoto_pemasukan'  => 'nullable|image'
        ], [
            'editname.required'     => 'Isi kolom keterangan',
            'editjumlah.required'   => 'Isi jumlah',
            'editfoto_pemasukan.required' => 'Isi Foto Bukti'
        ]);

        if ($validator->passes()) {
            $pemasukan = Pemasukan::find($id);
            if ($request->editfoto_pemasukan) {
                if ($pemasukan->foto != null) {
                    Storage::disk('local')->delete('public/bukti-pemasukan/' . $pemasukan->foto);
                }
                $img = $request->file('editfoto_pemasukan');
                $img->storeAs('public/bukti-pemasukan', $img->hashName());
                $pemasukan->update([
                    'name'  => ucwords($request->editname),
                    'jumlah' => $request->editjumlah,
                    'foto'  => $img->hashName()
                ]);
                return response()->json(['text' => 'Pemasukan ' . $pemasukan->name . ' berhasil diubah']);
            }

            $pemasukan->update([
                'name'  => ucwords($request->editname),
                'jumlah' => $request->editjumlah
            ]);

            return response()->json(['text' => 'Pengeluaran ' . $pemasukan->name . ' berhasil diubah']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $pemasukan = Pemasukan::find($id);
        Storage::disk('local')->delete('public/bukti-pemasukan/' . $pemasukan->foto);
        $pemasukan->delete();
        return response()->json(['text' => 'Pemasukan ' . $pemasukan->name . ' berhasil dihapus']);
    }
}
