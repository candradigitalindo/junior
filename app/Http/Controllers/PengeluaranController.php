<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluaran = Pengeluaran::whereYear('created_at', date('Y'))->orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($pengeluaran)
                ->addColumn('aksi', function ($pengeluaran) {

                    $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=" . $pengeluaran->id . ">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=" . $pengeluaran->id . ">Hapus</button>
                </div>";

                    return $button;
                })
                ->editColumn('name', function ($pengeluaran) {
                    $name = '<a href="#" class="fw-medium text-nowrap">' . $pengeluaran->name . '</a>';
                    return $name;
                })
                ->editColumn('jumlah', function ($pengeluaran) {
                    $jumlah = '<a href="#" class="fw-medium text-nowrap">' . number_format($pengeluaran->jumlah, 0, ',', '.') . '</a>';
                    return $jumlah;
                })
                ->editColumn('created_at', function ($pengeluaran) {
                    $tgl = '<a href="#" class="fw-medium text-nowrap">' . date('d M Y H:i', strtotime($pengeluaran->created_at)) . '</a>';
                    return $tgl;
                })
                ->editColumn('foto', function ($pengeluaran) {
                    $foto = '<img src="' . asset('storage/bukti-pengeluaran/' . $pengeluaran->foto) . '" style="width: 100px" style="height: 100px"/>';
                    return $foto;
                })
                ->rawColumns(['aksi', 'jumlah', 'name', 'created_at', 'foto'])
                ->make(true);
        }
        return view('kasir.pengeluaran');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'jumlah'            => 'required|string',
            'foto_pengeluaran'  => 'required|image'
        ], [
            'name.required'     => 'Isi kolom keterangan',
            'jumlah.required'   => 'Isi jumlah pengeluaran',
            'foto_pengeluaran.required' => 'Foto Bukti Pengeluaran'
        ]);

        if ($validator->passes()) {
            if ($request->foto_pengeluaran) {
                $img = $request->file('foto_pengeluaran');
                $img->storeAs('public/bukti-pengeluaran', $img->hashName());
                $pengeluaran = Pengeluaran::create([
                    'name'  => ucwords($request->name),
                    'jumlah' => $request->jumlah,
                    'foto'  => $img->hashName()
                ]);

                return response()->json(['text' => 'Pengeluaran ' . $pengeluaran->name . ' berhasil ditambahkan']);
            }

            $pengeluaran = Pengeluaran::create([
                'name'  => ucwords($request->name),
                'jumlah' => $request->jumlah
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
            'editjumlah'            => 'required|string',
            'editfoto_pengeluaran'  => 'nullable|image'
        ], [
            'editname.required'     => 'Isi kolom keterangan',
            'editjumlah.required'   => 'Isi jumlah pengeluaran',
            'editfoto_pengeluaran.required' => 'Foto Bukti Pengeluaran'
        ]);

        if ($validator->passes()) {
            $pengeluaran = Pengeluaran::find($id);
            if ($request->editfoto_pengeluaran) {
                if ($pengeluaran->foto != null) {
                    Storage::disk('local')->delete('public/bukti-pengeluaran/' . $pengeluaran->foto);
                }
                $img = $request->file('editfoto_pengeluaran');
                $img->storeAs('public/bukti-pengeluaran', $img->hashName());
                $pengeluaran->update([
                    'name'  => ucwords($request->editname),
                    'jumlah' => $request->editjumlah,
                    'foto'  => $img->hashName()
                ]);
                return response()->json(['text' => 'Pengeluaran ' . $pengeluaran->name . ' berhasil diubah']);
            }

            $pengeluaran->update([
                'name'  => ucwords($request->editname),
                'jumlah' => $request->editjumlah
            ]);

            return response()->json(['text' => 'Pengeluaran ' . $pengeluaran->name . ' berhasil diubah']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $pengeluaran = Pengeluaran::find($id);
        Storage::disk('local')->delete('public/bukti-pengeluaran/' . $pengeluaran->foto);
        $pengeluaran->delete();
        return response()->json(['text' => 'Pengeluaran ' . $pengeluaran->name . ' berhasil dihapus']);
    }
}
