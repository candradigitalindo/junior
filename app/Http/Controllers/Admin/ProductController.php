<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('created_at', 'DESC')->with('category')->get();
        if (request()->ajax()) {
            return datatables()->of($product)
            ->addColumn('aksi', function ($product) {

                $button = "<div class='d-flex justify-content-center align-items-center'>
                
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=".$product->id.">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$product->id.">Hapus</button>
                </div>";

                return $button;
            })
            ->addColumn('name_category', function ($product){
                $category = '<a href="#" class="fw-medium text-nowrap">'.$product->category->name.'</a>';
                return $category;
            })
            ->editColumn('name', function ($product){
                $category = '<a href="#" class="fw-medium text-nowrap">'.$product->name.'</a>';
                return $category;
            })
            ->editColumn('price', function ($product){
                $price = '<a href="#" class="fw-medium text-nowrap">'.number_format($product->price, 0, ',','.').'</a>';
                return $price;
            })
            ->addColumn('foto', function ($product){
                if ($product->foto == null || $product->foto == '') {
                    $foto = '<center><img src="'.asset('landing/images/product/item1.jpg').'" style="width: 100px" style="height: 100px"/></center>';
                return $foto;
                }
                $foto = '<center><img src="'.asset('storage/product/'.$product->foto).'" style="width: 100px" style="height: 100px"/></center>';
                return $foto;
            })
            ->rawColumns(['aksi', 'name_category', 'name', 'price', 'foto'])
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
            'name_category'  => 'required|string',
            'name'      => 'required|string',
            'price'     => 'required|integer',
            'description'=> 'nullable|string',
            'foto'      => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=450,height=514'
        ],[
            'name_category.required'     => 'Pilih Kategori',
            'name.required'         => 'Isi Kolom Nama Produk',
            'price.required'        => 'Isi Kolom Harga Produk',
            'foto.image'            => 'File harus berupa gambar',
            'foto.mimes'            => 'File harus berupa jpeg,png,jpg',
            'foto.dimensions'       => 'Ukuran Foto harus Lebar : 450px dan Tinggi : 514px'
        ]);

        if ($validator->passes()) {
            if ($request->foto) {
                $img = $request->file('foto');
                $img->storeAs('public/product', $img->hashName());
                $product = Product::create([
                    'category_id'   => $request->name_category,
                    'name'          => ucwords($request->name),
                    'price'         => $request->price,
                    'description'   => $request->description,
                    'foto'          => $img->hashName()
                ]);
                return response()->json(['text'=>'Produk '.$product->name.' berhasil ditambah.']);
            }

            $product = Product::create([
                'category_id'   => $request->name_category,
                'name'          => ucwords($request->name),
                'price'         => $request->price,
                'description'   => $request->description
            ]);

            return response()->json(['text'=>'Produk '.$product->name.' berhasil ditambah.']);
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
            'name_category_edit'  => 'required|integer',
            'name_edit'           => 'required|string',
            'price_edit'          => 'required|integer',
            'description_edit'    => 'nullable|string',
            'foto_edit'           => 'nullable|image|mimes:jpeg,png,jpg|dimensions:width=450,height=514'
        ],[
            'name_category_edit.required'=> 'Pilih Kategori',
            'name_edit.required'         => 'Isi Kolom Nama Produk',
            'price_edit.required'        => 'Isi Kolom Harga Produk',
            'description_edit.image'     => 'File harus berupa gambar',
            'foto_edit.mimes'            => 'File harus berupa jpeg,png,jpg',
            'foto_edit.dimensions'            => 'Ukuran Foto harus Lebar : 450px dan Tinggi : 514px'
        ]);

        if ($validator->passes()) {
            $product = Product::find($id);
            if ($request->foto_edit) {
                Storage::disk('local')->delete('public/product/'.$product->foto);
                $image = $request->file('foto_edit');
                $image->storeAs('public/product', $image->hashName());
                $product->update([
                    'category_id'   => $request->name_category_edit,
                    'name'          => ucwords($request->name_edit),
                    'price'         => $request->price_edit,
                    'description'   => $request->description_edit,
                    'foto'          => $image->hashName()
                ]);

                return response()->json(['text'=>'Produk '.$product->name.' berhasil diubah.']);

            }

            $product->update([
                'category_id'   => $request->name_category_edit,
                'name'          => ucwords($request->name_edit),
                'price'         => $request->price_edit,
                'description'   => $request->description_edit
            ]);

            return response()->json(['text'=>'Produk '.$product->name.' berhasil diubah.']);
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
        $product = Product::find($id);
        $product->delete();
        Storage::disk('local')->delete('public/product/'.$product->foto);
        return response()->json(['text'=>'Produk '.$product->name.' berhasil dihapus.']);
    }


}
