<?php

namespace App\Http\Controllers;

use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class TestimoniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimoni = Testimoni::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($testimoni)
            ->addColumn('aksi', function ($testimoni) {

                $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=".$testimoni->id.">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$testimoni->id.">Hapus</button>
                </div>";

                return $button;
            })
            ->editColumn('photo', function ($testimoni){
                if ($testimoni->photo == null || $testimoni->photo == '') {
                    $foto = '<center><img src="'.asset('landing/images/testimonials/pic1.jpg').'" style="width: 100px" style="height: 100px"/></center>';
                    return $foto;
                }
                $foto = '<center><img src="'.asset('storage/testimoni/'.$testimoni->photo).'" style="width: 100px" style="height: 100px"/></center>';
                return $foto;
            })
            ->rawColumns(['aksi','photo'])
            ->make(true);
        }
        return view('testimoni.index');
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
            'name'      => 'required|string',
            'pekerjaan' => 'nullable|string',
            'testimoni' => 'required|string',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg'
        ],[
            'name.required'       => 'Isi Kolom Nama',
            'testimoni.required'  => 'Isi Kolom Testimoni',
            'photo.image'         => 'File harus berupa gambar',
            'photo.mimes'         => 'File harus berupa jpeg,png,jpg'
        ]);

        if ($validator->passes()) {
            if ($request->photo) {
                $img = $request->file('photo');
                $img->storeAs('public/testimoni', $img->hashName());
                $testimoni = Testimoni::create([
                    'photo'     => $img->hashName(),
                    'testimoni' => $request->testimoni,
                    'name'      => strtoupper($request->name),
                    'pekerjaan' => ucwords($request->pekerjaan)
                ]);
                return response()->json(['text'=> 'Testimoni '.$testimoni->name.' berhasil ditambahkan']);
            }

            $testimoni = Testimoni::create([
                'testimoni' => $request->testimoni,
                'name'      => strtoupper($request->name),
                'pekerjaan' => ucwords($request->pekerjaan)
            ]);
            return response()->json(['text'=> 'Testimoni '.$testimoni->name.' berhasil ditambahkan']);
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
        $testimoni = Testimoni::find($id);
        return response()->json(['data' => $testimoni]);
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
        $validator = Validator::make($request->all(), [
            'name_edit'      => 'required|string',
            'pekerjaan_edit' => 'nullable|string',
            'testimoni_edit' => 'required|string',
            'photo_edit'     => 'nullable|image|mimes:jpeg,png,jpg'
        ],[
            'name_edit.required'       => 'Isi Kolom Nama',
            'testimoni_edit.required'  => 'Isi Kolom Testimoni',
            'photo_edit.image'         => 'File harus berupa gambar',
            'photo_edit.mimes'         => 'File harus berupa jpeg,png,jpg'
        ]);

        if ($validator->passes()) {
            $testimoni = Testimoni::find($id);
            if ($request->photo) {
                Storage::disk('local')->delete('public/testimoni/'.$testimoni->photo);
                $image = $request->file('photo_edit');
                $image->storeAs('public/testimoni', $image->hashName());
                $testimoni->update([
                    'photo'     => $image->hashName(),
                    'testimoni' => $request->testimoni_edit,
                    'name'      => strtoupper($request->name_edit),
                    'pekerjaan' => ucwords($request->pekerjaan_edit)
                ]);
                return response()->json(['text'=> 'Testimoni '.$testimoni->name.' berhasil diubah']);
            }

            $testimoni->update([
                'testimoni' => $request->testimoni_edit,
                'name'      => strtoupper($request->name_edit),
                'pekerjaan' => ucwords($request->pekerjaan_edit)
            ]);
            return response()->json(['text'=> 'Testimoni '.$testimoni->name.' berhasil ditambahkan']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $testimoni = Testimoni::find($id);
        $testimoni->delete();
        Storage::disk('local')->delete('public/testimoni/'.$testimoni->photo);
        return response()->json(['text'=>'Testimoni '.$testimoni->name.' berhasil dihapus.']);
    }
}
