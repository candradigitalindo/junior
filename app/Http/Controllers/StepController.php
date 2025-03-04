<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stepproduct;
use Illuminate\Http\Request;
use Validator;

class StepController extends Controller
{
    public function step($id)
    {
        $product = Product::where('id', $id)->with('stepproduct')->first();
        if (request()->ajax()) {
            return datatables()->of($product->stepproduct)
            ->editColumn('aksi', function ($step) {
                $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=".$step->id.">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$step->id.">Hapus</button>
                </div>";
                return $button;
            })
            ->editColumn('step', function ($step) {
                return '<table class="table table-bordered" width="100%" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="width: 2%">Step</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 20%">
                                    <a href="#" class="fw-medium text-nowrap">'.$step->step.'</a>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </center>';

            })

            ->rawColumns(['step', 'aksi'])
            ->make(true);
        }

        return view('admin.step.index', compact('product'));
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'step'  => 'required|string'
        ],[
            'step.required'=> 'Isi Kolom Step Pengerjaan',
        ]);

        if ($validator->passes()) {
            $product = Product::find($id);
            Stepproduct::create(['product_id' => $product->id, 'step' => ucwords($request->step)]);
            return response()->json(['text'=>'Step Pekerjaan berhasil ditambah.']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function edit($id)
    {
        $step = Stepproduct::find($id);
        return response()->json(['data' => $step]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'step'  => 'required|string'
        ],[
            'step.required'=> 'Isi Kolom Step Pengerjaan',
        ]);

        if ($validator->passes()) {
            $step = Stepproduct::find($id);
            $step->update(['step' => ucwords($request->step)]);
            return response()->json(['text'=>'Step Pekerjaan berhasil diubah.']);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function destroy($id)
    {
        $step = Stepproduct::find($id);
        $step->delete();
        return response()->json(['text'=>'Step Pekerjaan berhasil dihapus.']);
    }

    public function show($id)
    {
        $step = Stepproduct::where('product_id', $id)->orderBy('created_at', 'ASC')->get();
        return response()->json(['data' => $step]);
    }
}
