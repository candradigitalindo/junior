<?php

namespace App\Http\Controllers;

use App\Models\Tipemobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class TipemobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipemobil = Tipemobil::orderBy('name', 'ASC')->get();
        if (request()->ajax()) {
            return datatables()->of($tipemobil)
                ->addColumn('aksi', function ($tipemobil) {

                    $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=" . $tipemobil->id . ">Hapus</button>
                </div>";

                    return $button;
                })
                ->editColumn('photo', function ($tipemobil) {

                    $foto = '<center><img src="' . asset('storage/tipemobil/' . $tipemobil->photo) . '" style="width: 200px" style="height: 200px"/></center>';
                    return $foto;
                })
                ->rawColumns(['aksi', 'photo'])
                ->make(true);
        }
        return view('tipemobil.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tipe = Tipemobil::orderBy('name', 'ASC')->get();
        return response()->json(['data' => $tipe]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo'      => 'required|image|mimes:jpeg,png,jpg',
            'name'       => 'required|string'
        ], [
            'photo.required'       => 'Isi Kolom Foto',
            'photo.image'          => 'File harus berupa gambar',
            'photo.mimes'          => 'File harus berupa jpeg,png,jpg',
            'name.required'        => 'Isi Kolom Tipe Mobil'
        ]);

        if ($validator->passes()) {
            $img = $request->file('photo');
            $img->storeAs('public/tipemobil', $img->hashName());
            $tipemobil = Tipemobil::create(['photo' => $img->hashName(), 'name' => strtoupper($request->name)]);
            return response()->json(['text' => 'Tipe Mobil ' . $tipemobil->name . ' berhasil ditambah.']);
        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipemobil = Tipemobil::find($id);
        Storage::disk('local')->delete('public/tipemobil/' . $tipemobil->photo);
        $tipemobil->delete();
        return response()->json(['text' => 'Tipe Mobil ' . $tipemobil->name . ' berhasil dihapus.']);
    }
}
