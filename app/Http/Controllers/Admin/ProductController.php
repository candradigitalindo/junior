<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Product::with('category')->orderBy('created_at', 'DESC');

            return datatables()->of($query)
                ->addColumn('aksi', function ($product) {
                    return '<div class="d-flex justify-content-center gap-1">
                                <button class="edit btn btn-sm btn-primary w-20" id="' . $product->id . '">Edit</button>
                                <button class="delete btn btn-sm btn-danger w-20" id="' . $product->id . '">Hapus</button>
                            </div>';
                })
                ->editColumn('name', function ($product) {
                    return '<div class="fw-bold text-theme-1">' . $product->name . '</div>
                            <div class="text-gray-500 text-xs mt-0.5">' . ($product->category->name ?? '-') . '</div>';
                })
                ->editColumn('price', function ($product) {
                    return '<div class="fw-medium text-success">Rp ' . number_format($product->price, 0, ',', '.') . '</div>';
                })
                ->editColumn('foto', function ($product) {
                    $url = $product->foto ? asset('storage/product/' . $product->foto) : asset('image/no_photo_tipe_mobil.png');
                    return '<center>
                                <img src="' . $url . '" class="rounded-2 shadow-sm border" style="width: 60px; height: 60px; object-fit: cover; background: #f9fafb;"/>
                                ' . (!$product->foto ? '<div class="text-gray-400" style="font-size: 8px; margin-top: 2px;">TIDAK ADA GAMBAR</div>' : '') . '
                            </center>';
                })
                ->rawColumns(['aksi', 'name', 'price', 'foto'])
                ->make(true);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::orderBy('created_at', 'DESC')->get();
        return response()->json(['status' => 'sukses', 'data' => $product]);
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
            'name_category' => 'required',
            'name'          => 'required|string',
            'price'         => 'required|numeric',
            'description'   => 'nullable|string',
            'foto'          => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        if ($validator->passes()) {
            $data = [
                'category_id' => $request->name_category,
                'name'        => ucwords($request->name),
                'price'       => $request->price,
                'description' => $request->description
            ];

            if ($request->hasFile('foto')) {
                $img = $request->file('foto');
                $filename = time() . '_' . $img->hashName();
                
                // Process: Resize without cropping, maintain aspect ratio with white background
                $processedImage = Image::canvas(450, 514, '#ffffff'); // Create white canvas
                $image = Image::make($img)->resize(450, 514, function ($constraint) {
                    $constraint->aspectRatio(); // Maintain ratio
                    $constraint->upsize(); // Prevent enlarging small images
                });
                
                $processedImage->insert($image, 'center'); // Center original image on canvas
                $encodedImage = $processedImage->encode('jpg', 80);
                
                Storage::put('public/product/' . $filename, $encodedImage);
                $data['foto'] = $filename;
            }

            $product = Product::create($data);
            return response()->json(['text' => 'Produk ' . $product->name . ' berhasil ditambah.']);
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
        $product = Product::find($id);
        return response()->json(['status' => 'sukses', 'data' => $product]);
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
            'name_category_edit' => 'required',
            'name_edit'          => 'required|string',
            'price_edit'         => 'required|numeric',
            'description_edit'   => 'nullable|string',
            'foto_edit'          => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        if ($validator->passes()) {
            $product = Product::find($id);
            $data = [
                'category_id' => $request->name_category_edit,
                'name'        => ucwords($request->name_edit),
                'price'       => $request->price_edit,
                'description' => $request->description_edit
            ];

            if ($request->hasFile('foto_edit')) {
                if ($product->foto) Storage::disk('local')->delete('public/product/' . $product->foto);
                
                $img = $request->file('foto_edit');
                $filename = time() . '_' . $img->hashName();

                // Process: Resize without cropping, maintain aspect ratio with white background
                $processedImage = Image::canvas(450, 514, '#ffffff');
                $image = Image::make($img)->resize(450, 514, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                
                $processedImage->insert($image, 'center');
                $encodedImage = $processedImage->encode('jpg', 80);
                
                Storage::put('public/product/' . $filename, $encodedImage);
                $data['foto'] = $filename;
            }

            $product->update($data);
            return response()->json(['text' => 'Produk ' . $product->name . ' berhasil diubah.']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            if ($product->foto) Storage::disk('local')->delete('public/product/' . $product->foto);
            $product->delete();
            return response()->json(['text' => 'Produk ' . $product->name . ' berhasil dihapus.']);
        }
        return response()->json(['status' => 'error', 'text' => 'Produk tidak ditemukan.']);
    }
}
