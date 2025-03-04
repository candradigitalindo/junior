<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Historibarang;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;

use function PHPUnit\Framework\isEmpty;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            if (!empty($request->start_date)) {
                $barang = Barang::orderBy('name', 'ASC')->with(['historibarang'])->get();

                return datatables()->of($barang)
                    ->addColumn('aksi', function ($barang) {
                        return "<div class='d-flex justify-content-center align-items-center'><a target='_blank' href='" . route('gudang.histori', $barang->id) . "' class='btn btn-elevated-dark w-28 me-1 mb-2' id=" . $barang->id . ">Histori</a><button class='edit btn btn-elevated-primary w-24 me-1 mb-2' id=".$barang->id.">Edit</button><button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$barang->id.">Hapus</button></div>";
                    })
                    ->addColumn('jml_barang_masuk', function ($barang) use ($request) {
                        $jumlah = Historibarang::where('barang_id', $barang->id)->where('status', 1)->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
                        return "<div class='d-flex justify-content-center align-items-center'>" . $jumlah->count() . "</div>";
                    })
                    ->addColumn('jml_barang_keluar', function ($barang) use ($request) {
                        $jumlah = Historibarang::where('barang_id', $barang->id)->where('status', 2)->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
                        return "<div class='d-flex justify-content-center align-items-center'>" . $jumlah->count() . "</div>";
                    })

                    ->editColumn('stok', function ($barang) {
                        switch ($barang->stok) {
                            case 0:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: red'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;
                            case 1:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: red'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;
                            case 2:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: orange'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;
                            case 3:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: orange'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;

                            default:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: green'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;

                        }
                    })
                    ->editColumn('barang_masuk', function ($barang) {
                        if ($barang->barang_masuk == null) {
                            $date = "Belum ada Update";
                        }else {
                            $date = date('d-m-Y H:i', strtotime($barang->barang_masuk));
                        }
                        return "<div class='d-flex justify-content-center align-items-center'>" . $date . "</div>";
                    })
                    ->editColumn('barang_keluar', function ($barang) {
                        if ($barang->barang_keluar == null) {
                            $date = "Belum ada Update";
                        }else {
                            $date = date('d-m-Y H:i', strtotime($barang->barang_keluar));
                        }
                        return "<div class='d-flex justify-content-center align-items-center'>" . $date . "</div>";
                    })
                    ->rawColumns(['aksi', 'jml_barang_masuk', 'jml_barang_keluar', 'jml_barang_rusak', 'stok', 'barang_masuk', 'barang_keluar'])
                    ->make(true);
            } else {
                $barang = Barang::orderBy('name', 'ASC')->with('historibarang')->get();
                return datatables()->of($barang)
                    ->addColumn('aksi', function ($barang) {
                        return "<div class='d-flex justify-content-center align-items-center'><a href='" . route('gudang.histori', $barang->id) . "' class='keluar btn btn-elevated-dark w-28 me-1 mb-2' id=" . $barang->id . ">Histori</a><button class='edit btn btn-elevated-primary w-24 me-1 mb-2' id=".$barang->id.">Edit</button><button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$barang->id.">Hapus</button></div>";
                    })
                    ->addColumn('jml_barang_masuk', function ($barang) {
                        $histori = Historibarang::where('barang_id', $barang->id)->where('status', 1)->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();

                        return "<div class='d-flex justify-content-center align-items-center'>" . $histori->count() . "</div>";
                    })
                    ->addColumn('jml_barang_keluar', function ($barang) {
                        $histori = Historibarang::where('barang_id', $barang->id)->where('status', 2)->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
                        return "<div class='d-flex justify-content-center align-items-center'>" . $histori->count() . "</div>";
                    })

                    ->editColumn('stok', function ($barang) {
                        switch ($barang->stok) {
                            case 0:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: red'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;
                            case 1:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: red'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;
                            case 2:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: orange'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;
                            case 3:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: orange'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;

                            default:
                                return "<div class='d-flex justify-content-center align-items-center' style='color: green'><b>" . number_format($barang->stok, 0, ',', '.') . "</b></div>";
                                break;
                                break;
                        }
                    })
                    ->editColumn('barang_masuk', function ($barang) {
                        if ($barang->barang_masuk == null) {
                            $date = "Belum ada Update";
                        }else {
                            $date = date('d-m-Y H:i', strtotime($barang->barang_masuk));
                        }
                        return "<div class='d-flex justify-content-center align-items-center'>" . $date . "</div>";
                    })
                    ->editColumn('barang_keluar', function ($barang) {
                        if ($barang->barang_keluar == null) {
                            $date = "Belum ada Update";
                        }else {
                            $date = date('d-m-Y H:i', strtotime($barang->barang_keluar));
                        }
                        return "<div class='d-flex justify-content-center align-items-center'>" . $date . "</div>";
                    })
                    ->rawColumns(['aksi', 'jml_barang_masuk', 'jml_barang_keluar', 'jml_barang_rusak', 'stok', 'barang_masuk', 'barang_keluar'])
                    ->make(true);
            }
        }
        return view('gudang.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'barcode'           => 'required|string|unique:barangs',
            'description'       => 'nullable|string'
        ], [
            'name.required'     => 'Isi kolom nama barang',
            'barcode.required'  => 'Isi kolom barcode',
            'barcode.unique'    => 'Barcode sudah terdaftar'
        ]);

        if ($validator->passes()) {
            $barang = Barang::create([
                'name'      => strtoupper($request->name),
                'slug'      => Str::slug($request->name) . '-' . rand(10, 99),
                'barcode'   => $request->barcode,
                'description' => $request->description
            ]);

            return response()->json(['text' => 'Barang ' . $barang->name . ' berhasil ditambah.']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function edit($id)
    {
        $barang = Barang::find($id);
        return response()->json(['status' => 'sukses', 'data' => $barang]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'barcode'           => 'required|string|unique:barangs,barcode,'.$id,
            'description'       => 'nullable|string'
        ], [
            'name.required'     => 'Isi kolom nama barang',
            'barcode.required'  => 'Isi kolom barcode',
            'barcode.unique'    => 'Barcode sudah terdaftar'
        ]);

        if ($validator->passes()) {
            $barang = Barang::find($id);
            $barang->update([
                'name'      => strtoupper($request->name),
                'barcode'   => $request->barcode,
                'description' => $request->description
            ]);

            return response()->json(['text' => 'Barang ' . $barang->name . ' berhasil diubah.']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function view_masuk()
    {
        if (request()->ajax()) {
            $barang = Historibarang::where('status', 1)->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
            return datatables()->of($barang)
                ->addColumn('aksi', function ($barang) {
                    return "<div class='d-flex justify-content-center align-items-center'><button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$barang->id.">Hapus</button></div>";
                })
                ->addColumn('name', function ($barang) {
                    return $barang->barang->name;
                })
                ->addColumn('barcode', function ($barang) {
                    return $barang->barang->barcode;
                })
                ->editColumn('created_at', function ($barang) {
                    return "<div class='d-flex justify-content-center align-items-center'>" . date('d-m-Y H:i', strtotime($barang->created_at)) . "</div>";
                })
                ->rawColumns(['aksi', 'created_at', 'name', 'barcode'])
                ->make(true);
        }
        return view('gudang.masuk');
    }

    public function view_keluar()
    {
        if (request()->ajax()) {
            $barang = Historibarang::where('status', 2)->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
            return datatables()->of($barang)
                ->addColumn('aksi', function ($barang) {
                    return "<div class='d-flex justify-content-center align-items-center'><button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$barang->id.">Hapus</button></div>";
                })
                ->addColumn('name', function ($barang) {
                    return $barang->barang->name;
                })
                ->addColumn('barcode', function ($barang) {
                    return $barang->barang->barcode;
                })
                ->editColumn('created_at', function ($barang) {
                    return "<div class='d-flex justify-content-center align-items-center'>" . date('d-m-Y H:i', strtotime($barang->created_at)) . "</div>";
                })
                ->rawColumns(['aksi', 'created_at', 'name', 'barcode'])
                ->make(true);
        }
        return view('gudang.keluar');
    }

    public function post_masuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode'           => 'required|string',
        ], [
            'barcode.required'  => 'Isi kolom barcode',
        ]);

        if ($validator->passes()) {
            $barang = Barang::where('barcode', $request->barcode)->first();
            if ($barang) {
                $histori = Historibarang::create([
                    'barang_id' => $barang->id,
                    'status' => 1
                ]);
                $barang->update(['barang_masuk' => $histori->created_at, 'stok' => $barang->stok + 1]);
                return response()->json(['status' => 'sukses', 'text' => 'Barang masuk '.$barang->name. ' berhasil']);
            }else {
                return response()->json(['status' => 'error', 'text' => 'Barcode Barang tidak ditemukan']);
            }

        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function post_keluar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode'           => 'required|string',
        ], [
            'barcode.required'  => 'Isi kolom barcode',
        ]);

        if ($validator->passes()) {
            $barang = Barang::where('barcode', $request->barcode)->first();
            if ($barang) {
                $histori = Historibarang::create([
                    'barang_id' => $barang->id,
                    'status' => 2
                ]);
                $barang->update(['barang_keluar' => $histori->created_at, 'stok' => $barang->stok - 1]);
                return response()->json(['status' => 'sukses', 'text' => 'Barang keluar '.$barang->name. ' berhasil']);
            }else {
                return response()->json(['status' => 'error', 'text' => 'Barcode Barang tidak ditemukan']);
            }

        }

        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function delete_barang($id)
    {
        $barang = Barang::find($id);
        foreach ($barang->historibarang as $key) {
            $key->delete();
        }
        $barang->delete();
        return response()->json(['status' => 'sukses', 'text'=>'Barang '.$barang->name.' berhasil dihapus']);
    }

    public function delete($id)
    {
        $histori = Historibarang::find($id);
        $histori->delete();
        $histori->barang->update(['stok' => $histori->barang->stok - 1]);
        return response()->json(['status' => 'sukses', 'text'=>'Histori Barang '.$histori->barang->name.' berhasil dihapus']);
    }

    public function delete_keluar($id)
    {
        $histori = Historibarang::find($id);
        $histori->delete();
        $histori->barang->update(['stok' => $histori->barang->stok + 1]);
        return response()->json(['status' => 'sukses', 'text'=>'Histori Barang '.$histori->barang->name.' berhasil dihapus']);
    }

    public function histori(Request $request, $id)
    {
        // $barang = Historibarang::where('barang_id', $id)->whereBetween('created_at', [$request->start_date, $request->end_date])->where('created_at', 'DESC')->get();
        // dd($barang);
        if (request()->ajax()) {
            if (!empty($request->start_date)) {
                $barang = Historibarang::where('barang_id', $id)->orderBy('created_at', 'DESC')->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
                return datatables()->of($barang)
                ->addColumn('aksi', function ($barang) {
                    return "<div class='d-flex justify-content-center align-items-center'><button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$barang->id.">Hapus</button></div>";
                })
                ->addColumn('name', function ($barang) {
                    return $barang->barang->name;
                })
                ->addColumn('barcode', function ($barang) {
                    return $barang->barang->barcode;
                })
                ->editColumn('created_at', function ($barang) {
                    return "<div class='d-flex justify-content-center align-items-center'>" . date('d-m-Y H:i', strtotime($barang->created_at)) . "</div>";
                })
                ->editColumn('status', function ($barang) {
                    if ($barang->status == 1) {
                        return "<div class='d-flex justify-content-center align-items-center' style='color: green'><b>Barang Masuk</b></div>";
                    }else {
                        return "<div class='d-flex justify-content-center align-items-center' style='color: red'><b>Barang Keluar</b></div>";

                    }
                })
                ->rawColumns(['aksi', 'created_at', 'name', 'barcode', 'status'])
                ->make(true);
            }else {
                $barang = Historibarang::where('barang_id', $id)->orderBy('created_at', 'DESC')->whereDay('created_at', date('d'))->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->get();
                return datatables()->of($barang)
                ->addColumn('aksi', function ($barang) {
                    return "<div class='d-flex justify-content-center align-items-center'><button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$barang->id.">Hapus</button></div>";
                })
                ->addColumn('name', function ($barang) {
                    return $barang->barang->name;
                })
                ->addColumn('barcode', function ($barang) {
                    return $barang->barang->barcode;
                })
                ->editColumn('created_at', function ($barang) {
                    return "<div class='d-flex justify-content-center align-items-center'>" . date('d-m-Y H:i', strtotime($barang->created_at)) . "</div>";
                })
                ->editColumn('status', function ($barang) {
                    if ($barang->status == 1) {
                        return "<div class='d-flex justify-content-center align-items-center' style='color: green'><b>Barang Masuk</b></div>";
                    }else {
                        return "<div class='d-flex justify-content-center align-items-center' style='color: red'><b>Barang Keluar</b></div>";

                    }
                })
                ->rawColumns(['aksi', 'created_at', 'name', 'barcode', 'status'])
                ->make(true);
            }
        }
        $query = Barang::find($id);
        return view('gudang.histori', compact('query'));
    }

    public function view_barcode()
    {
        return view('gudang.barcode');
    }

    public function post_barcode(Request $request)
    {
        $this->validate($request,[
            'barcode' => 'required|string|unique:barangs',
            'jumlah'    => 'required|string'
        ],[
            'barcode.required' => 'Kolom Barcode masih kosong',
            'barcode.unique' => 'Barcode ini sudah terdaftar',
            'jumlah.required'   => 'Kolom jumlah masih kosong'
        ]);

        for ($i=0; $i < $request->jumlah; $i++) {
            $qrcode[] = ['barcode' => base64_encode(QrCode::format('svg')->size(100)->errorCorrection('H')->generate($request->barcode)), 'nomor' => $request->barcode];
        }
        // dd($qrcode);
        $pdf = PDF::loadView('gudang.cetak', compact('qrcode'));
        return $pdf->stream();
    }
}
