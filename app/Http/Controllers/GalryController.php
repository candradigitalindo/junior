<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class GalryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galery = Galery::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($galery)
            ->addColumn('aksi', function ($galery) {

                $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$galery->id.">Hapus</button>
                </div>";

                return $button;
            })
            ->addColumn('foto', function ($galery){

                $foto = '<center><img src="'.asset('storage/galery/'.$galery->galery).'" style="width: 300px" style="height: 300px"/></center>';
                return $foto;
            })
            ->rawColumns(['aksi','foto'])
            ->make(true);
        }
        return view('galery.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'galery'      => 'required|image|mimes:jpeg,png,jpg|dimensions:width=450,height=514'
        ],[
            'galery.required'       => 'Isi Kolom Foto',
            'galery.image'          => 'File harus berupa gambar',
            'galery.mimes'          => 'File harus berupa jpeg,png,jpg',
            'galery.dimensions'     => 'Ukuran Foto harus Lebar : 450px dan Tinggi : 514px'
        ]);

        if ($validator->passes()) {
            $img = $request->file('galery');
            $img->storeAs('public/galery', $img->hashName());
            Galery::create(['galery' => $img->hashName()]);
            return response()->json(['text'=>'Galery berhasil ditambah.']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
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
        $galery = Galery::find($id);
        Storage::disk('local')->delete('public/galery/'.$galery->galery);
        $galery->delete();
        return response()->json(['text'=>'Galery berhasil dihapus.']);
    }
}
