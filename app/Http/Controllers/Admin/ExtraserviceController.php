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
        if (request()->ajax()) {
            $e_service = Extraservice::with('product')->select('extraservices.*');
            return datatables()->of($e_service)
                ->addIndexColumn()
                ->addColumn('aksi', function ($row) {
                    return '<div class="flex justify-center items-center">
                        <button class="edit btn btn-sm btn-outline-primary w-16 mr-1 mb-2" id="'.$row->id.'">Edit</button>
                        <button class="delete btn btn-sm btn-outline-danger w-16 mr-1 mb-2" id="'.$row->id.'">Hapus</button>
                    </div>';
                })
                ->addColumn('product_name', function ($row) {
                    return $row->product ? $row->product->name : '-';
                })
                ->editColumn('price', function ($row) {
                    return 'Rp ' . number_format($row->price, 0, ',', '.');
                })
                ->rawColumns(['aksi'])
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
        if ($request->has('id')) {
            $product = Product::find($request->id);
            if ($product) {
                return response()->json([
                    'status' => 'sukses',
                    'data' => Extraservice::where('product_id', $product->id)->orderBy('price', 'ASC')->get()
                ]);
            }
            return response()->json(['status' => 'gagal', 'text' => 'Produk tidak ditemukan']);
        }

        // Return all products for the dropdown
        $products = Product::orderBy('name', 'ASC')->get();
        return response()->json(['status' => 'sukses', 'data' => $products]);
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
            'product'     => 'required',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ], [
            'product.required' => 'Pilih Produk',
            'name.required'    => 'Isi Kolom Nama Extra Service',
            'price.required'   => 'Isi Kolom Harga'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()]);
        }

        $extra = Extraservice::create([
            'product_id'  => $request->product,
            'name'        => ucwords($request->name),
            'price'       => $request->price,
            'description' => $request->description
        ]);

        return response()->json(['status' => 'sukses', 'text' => 'Extra Produk ' . $extra->name . ' berhasil ditambah.']);
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
            return response()->json([
                'status' => 'sukses', 
                'data' => Extraservice::where('product_id', $product->id)->orderBy('price', 'ASC')->get()
            ]);
        }

        return response()->json(['status' => 'gagal', 'text' => 'Extra Service tidak ditemukan']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $extra = Extraservice::with('product')->find($id);
        if (!$extra) {
            return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);
        }
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
            'product'     => 'required',
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string'
        ], [
            'product.required' => 'Pilih Produk',
            'name.required'    => 'Isi Kolom Nama Extra Service',
            'price.required'   => 'Isi Kolom Harga'
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'errors' => $validator->errors()->all()]);
        }

        $extra = Extraservice::find($id);
        if (!$extra) {
            return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);
        }

        $extra->update([
            'product_id'  => $request->product,
            'name'        => ucwords($request->name),
            'price'       => $request->price,
            'description' => $request->description
        ]);

        return response()->json(['status' => 'sukses', 'text' => 'Extra Produk ' . $extra->name . ' berhasil diubah.']);
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
        if (!$extra) {
            return response()->json(['status' => 'gagal', 'text' => 'Data tidak ditemukan']);
        }
        $name = $extra->name;
        $extra->delete();
        return response()->json(['status' => 'sukses', 'text' => 'Extra produk ' . $name . ' berhasil dihapus.']);
    }
}
