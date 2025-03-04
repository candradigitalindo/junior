<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Extraservice;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class ExtraserviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $e_service = Extraservice::orderBy('created_at', 'DESC')->with('product')->get();
        if (request()->ajax()) {
            return datatables()->of($e_service)
            ->addColumn('aksi', function ($e_service) {

                $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=".$e_service->id.">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$e_service->id.">Hapus</button>
                </div>";

                return $button;
            })
            ->addColumn('name_product', function ($e_service){
                $product = '<a href="#" class="fw-medium text-nowrap">'.$e_service->product->name.'</a>';
                return $product;
            })
            ->editColumn('name', function ($e_service){
                $service = '<a href="#" class="fw-medium text-nowrap">'.$e_service->name.'</a>';
                return $service;
            })
            ->editColumn('price', function ($e_service){
                $price = '<a href="#" class="fw-medium text-nowrap">'.number_format($e_service->price, 0, ',','.').'</a>';
                return $price;
            })
            ->rawColumns(['aksi', 'name_product', 'name', 'price'])
            ->make(true);
        }
        return view('admin.extra-service.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product = Product::find($request->id);
        if ($product) {
            return response()->json(['status' => 'sukses', 'data' => Extraservice::where('product_id', $product->id)->orderBy('price', 'ASC')->get()]);
        }

        return response()->json(['status' => 'gagal', 'text'=>'Extra Service tidak ditemukan']);
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
            'product'  => 'required|integer',
            'name'      => 'required|string',
            'price'     => 'required|integer',
            'description'=> 'nullable|string'
        ],[
            'product.required'     => 'Pilih Produk',
            'name.required'         => 'Isi Kolom Nama Produk',
            'price.required'        => 'Isi Kolom Harga Produk'
        ]);

        if ($validator->passes()) {
            $extra = Extraservice::create([
                'product_id'   => $request->product,
                'name'          => ucwords($request->name),
                'price'         => $request->price,
                'description'   => $request->description
            ]);

            return response()->json(['text'=>'Extra Produk '.$extra->name.' berhasil ditambah.']);
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
        $product = Product::where('name', $id)->first();
        if ($product) {
            return response()->json(['status' => 'sukses', 'data' => Extraservice::where('product_id', $product->id)->orderBy('price', 'ASC')->get()]);
        }

        return response()->json(['status' => 'gagal', 'text'=>'Extra Service tidak ditemukan']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $extra = Extraservice::find($id);
        return response()->json(['status' => 'sukses', 'data' => $extra]);
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
            'product'  => 'required|integer',
            'name'      => 'required|string',
            'price'     => 'required|integer',
            'description'=> 'nullable|string'
        ],[
            'product.required'     => 'Pilih Produk',
            'name.required'         => 'Isi Kolom Nama Produk',
            'price.required'        => 'Isi Kolom Harga Produk'
        ]);

        if ($validator->passes()) {
            $extra = Extraservice::find($id);
            $extra->update([
                'product_id'   => $request->product,
                'name'          => ucwords($request->name),
                'price'         => $request->price,
                'description'   => $request->description
            ]);

            return response()->json(['text'=>'Extra Produk '.$extra->name.' berhasil diubah.']);
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
        $extra = Extraservice::find($id);
        $extra->delete();
        return response()->json(['text'=>'Extra produk '.$extra->name.' berhasil dihapus.']);
    }
}
