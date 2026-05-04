<?php

namespace App\Http\Controllers;

use App\Models\Tipemobil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\Facades\Image;

class TipemobilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $tipemobil = Tipemobil::query();
            return datatables()->of($tipemobil)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '<div class="flex justify-center items-center">
                        <button class="delete btn btn-sm btn-outline-danger w-16" id="' . $row->id . '">Hapus</button>
                    </div>';
                })
                ->editColumn('photo', function ($row) {
                    $url = $row->photo ? asset('storage/tipemobil/' . $row->photo) : asset('image/no_photo_tipe_mobil.png');
                    return '<div class="flex justify-center">
                        <div class="w-24 h-16 image-fit zoom-in">
                            <img alt="' . $row->name . '" class="rounded-md shadow-md" src="' . $url . '" style="object-fit: contain;">
                        </div>
                    </div>';
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
        return response()->json(['status' => 'sukses', 'data' => $tipe]);
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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:10240',
            'name'  => 'required|string|max:255'
        ], [
            'photo.image'   => 'File harus berupa gambar',
            'photo.mimes'   => 'Format gambar harus jpeg, png, atau jpg',
            'photo.max'     => 'Ukuran gambar maksimal 10MB',
            'name.required' => 'Isi Kolom Tipe Mobil'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()]);
        }

        $photoName = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $photoName = $file->hashName();
            
            // Image Processing
            $img = Image::make($file->path());
            
            // Resize for vehicle type (usually smaller than documentation)
            $img->resize(800, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Ensure directory exists
            if (!Storage::disk('public')->exists('tipemobil')) {
                Storage::disk('public')->makeDirectory('tipemobil');
            }

            // Save optimized
            $img->save(storage_path('app/public/tipemobil/' . $photoName), 85);
        }
        
        $tipemobil = Tipemobil::create([
            'photo' => $photoName, 
            'name'  => strtoupper($request->name)
        ]);
        
        return response()->json(['status' => 'sukses', 'text' => 'Tipe Mobil ' . $tipemobil->name . ' berhasil ditambah dengan optimasi gambar.']);
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
        if (!$tipemobil) {
            return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);
        }

        if ($tipemobil->photo) {
            Storage::disk('local')->delete('public/tipemobil/' . $tipemobil->photo);
        }
        
        $name = $tipemobil->name;
        $tipemobil->delete();
        
        return response()->json(['status' => 'sukses', 'text' => 'Tipe Mobil ' . $name . ' berhasil dihapus.']);
    }
}
