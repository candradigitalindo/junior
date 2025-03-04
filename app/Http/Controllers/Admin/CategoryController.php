<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::orderBy('created_at', 'DESC')->with('product')->get();
        if (request()->ajax()) {
            return datatables()->of($category)
            ->addColumn('aksi', function ($category) {

                $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=".$category->id.">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$category->id.">Hapus</button>
                </div>";

                return $button;
            })
            ->editColumn('name', function ($category){
                $plat = '<a href="#" class="fw-medium text-nowrap">'.$category->name.'</a>';
                return $plat;
            })
            ->addColumn('jumlah_product', function ($category){
                $plat = '<a href="#" class="fw-medium text-nowrap">'.number_format($category->product->count(), 0, ',','.').'</a>';
                return $plat;
            })
            ->rawColumns(['aksi', 'jumlah_product', 'name'])
            ->make(true);
        }
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('created_at', 'DESC')->with('product')->get();
        return response()->json(['status' => 'sukses', 'data' => $category]);
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
            'name'              => 'required|string',
        ],[
            'name.required'     => 'Isi kolom nama Kategori',
        ]);

        if ($validator->passes()) {
            $category = Category::create([
                'name'      => strtoupper($request->name)
            ]);

            return response()->json(['text'=>'Kategori '.$category->name.' berhasil ditambah.']);
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
        $category = Category::find($id);
        return response()->json(['status' => 'sukses', 'data' => $category]);
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
            'name'              => 'required|string',
        ],[
            'name.required'     => 'Isi kolom nama Kategori',
        ]);

        if ($validator->passes()) {
            $category = Category::find($id);
            $category->update([
                'name'  => strtoupper($request->name)
            ]);
            return response()->json(['text'=>'Kategori '.$category->name.' berhasil diubah.']);
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
        $category   = Category::find($id);
        $product    = Product::where('category_id', $category->id)->first();
        if ($product) {
            return response()->json(['status' => 'gagal', 'text'=>'Kategori '.$category->name.' masih mempunyai Produk']);
        }

        $category->delete();
        return response()->json(['status' => 'sukses', 'text'=>'Kategori '.$category->name.' berhasil dihapus']);
    }
}
