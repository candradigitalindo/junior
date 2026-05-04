<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Historibarang;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GudangController extends Controller
{
    public function index(Request $request)
    {
        if (request()->ajax()) {
            $query = Barang::query();

            // Optimization: Use withCount to avoid N+1 queries for history counts
            if (!empty($request->start_date)) {
                $query->withCount([
                    'historibarang as jml_masuk' => function ($q) use ($request) {
                        $q->where('status', 1)->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    },
                    'historibarang as jml_keluar' => function ($q) use ($request) {
                        $q->where('status', 2)->whereBetween('created_at', [$request->start_date, $request->end_date]);
                    }
                ]);
            } else {
                $query->withCount([
                    'historibarang as jml_masuk' => function ($q) {
                        $q->where('status', 1)->whereDate('created_at', date('Y-m-d'));
                    },
                    'historibarang as jml_keluar' => function ($q) {
                        $q->where('status', 2)->whereDate('created_at', date('Y-m-d'));
                    }
                ]);
            }

            return datatables()->of($query->orderBy('name', 'ASC'))
                ->addColumn('aksi', function ($barang) {
                    if (strtolower(Auth::user()->role->role) == 'superadmin') {
                        return "<div class='text-center'><a target='_blank' href='" . route('gudang.histori', $barang->id) . "' class='btn btn-xs btn-dark'>Riwayat</a></div>";
                    }
                    return "<div class='d-flex gap-1 justify-content-center'>
                                <a target='_blank' href='" . route('gudang.histori', $barang->id) . "' class='btn btn-xs btn-dark'>Riwayat</a>
                                <button class='edit btn btn-xs btn-primary' id=".$barang->id.">Edit</button>
                                <button class='delete btn btn-xs btn-danger' id=".$barang->id.">Hapus</button>
                            </div>";
                })
                ->editColumn('jml_barang_masuk', function ($barang) {
                    return "<div class='text-center fw-bold text-success'>" . ($barang->jml_masuk ?? 0) . "</div>";
                })
                ->editColumn('jml_barang_keluar', function ($barang) {
                    return "<div class='text-center fw-bold text-danger'>" . ($barang->jml_keluar ?? 0) . "</div>";
                })
                ->editColumn('stok', function ($barang) {
                    $color = 'text-success';
                    if ($barang->stok <= 1) $color = 'text-danger';
                    elseif ($barang->stok <= 3) $color = 'text-warning';
                    return "<div class='text-center fw-bold $color'>" . number_format($barang->stok, 0, ',', '.') . "</div>";
                })
                ->editColumn('barang_masuk', function ($barang) {
                    return $barang->barang_masuk ? date('d-m-Y H:i', strtotime($barang->barang_masuk)) : '-';
                })
                ->editColumn('barang_keluar', function ($barang) {
                    return $barang->barang_keluar ? date('d-m-Y H:i', strtotime($barang->barang_keluar)) : '-';
                })
                ->rawColumns(['aksi', 'jml_barang_masuk', 'jml_barang_keluar', 'stok'])
                ->make(true);
        }
        return view('gudang.index');
    }

    public function store(Request $request)
    {
        if (strtolower(auth()->user()->role->role) == 'superadmin') {
            return response()->json(['status' => 'error', 'text' => 'Akses ditolak: Superadmin hanya bisa melihat data.']);
        }
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'barcode'           => 'required|string|unique:barangs',
            'description'       => 'nullable|string'
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
        if (strtolower(auth()->user()->role->role) == 'superadmin') {
            return response()->json(['status' => 'error', 'text' => 'Akses ditolak: Superadmin hanya bisa melihat data.']);
        }
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'barcode'           => 'required|string|unique:barangs,barcode,'.$id,
            'description'       => 'nullable|string'
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
            $query = Historibarang::with('barang')
                ->where('status', 1)
                ->whereDate('created_at', date('Y-m-d'));

            return datatables()->of($query)
                ->addColumn('aksi', function ($h) {
                    return "<button class='delete btn btn-xs btn-danger' id=".$h->id.">Hapus</button>";
                })
                ->editColumn('name', function ($h) { return $h->barang->name ?? '-'; })
                ->editColumn('barcode', function ($h) { return $h->barang->barcode ?? '-'; })
                ->editColumn('created_at', function ($h) { return $h->created_at->format('d-m-Y H:i'); })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('gudang.masuk');
    }

    public function view_keluar()
    {
        if (request()->ajax()) {
            $query = Historibarang::with('barang')
                ->where('status', 2)
                ->whereDate('created_at', date('Y-m-d'));

            return datatables()->of($query)
                ->addColumn('aksi', function ($h) {
                    return "<button class='delete btn btn-xs btn-danger' id=".$h->id.">Hapus</button>";
                })
                ->editColumn('name', function ($h) { return $h->barang->name ?? '-'; })
                ->editColumn('barcode', function ($h) { return $h->barang->barcode ?? '-'; })
                ->editColumn('created_at', function ($h) { return $h->created_at->format('d-m-Y H:i'); })
                ->rawColumns(['aksi'])
                ->make(true);
        }
        return view('gudang.keluar');
    }

    public function post_masuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string',
        ]);

        if ($validator->passes()) {
            $barang = Barang::where('barcode', $request->barcode)->first();
            if ($barang) {
                $histori = Historibarang::create(['barang_id' => $barang->id, 'status' => 1]);
                $barang->update(['barang_masuk' => $histori->created_at, 'stok' => $barang->stok + 1]);
                return response()->json(['status' => 'sukses', 'text' => 'Barang masuk '.$barang->name. ' berhasil']);
            }
            return response()->json(['status' => 'error', 'text' => 'Barcode tidak ditemukan']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function post_keluar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'barcode' => 'required|string',
        ]);

        if ($validator->passes()) {
            $barang = Barang::where('barcode', $request->barcode)->first();
            if ($barang) {
                $histori = Historibarang::create(['barang_id' => $barang->id, 'status' => 2]);
                $barang->update(['barang_keluar' => $histori->created_at, 'stok' => $barang->stok - 1]);
                return response()->json(['status' => 'sukses', 'text' => 'Barang keluar '.$barang->name. ' berhasil']);
            }
            return response()->json(['status' => 'error', 'text' => 'Barcode tidak ditemukan']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }

    public function delete_barang($id)
    {
        if (strtolower(auth()->user()->role->role) == 'superadmin') {
            return response()->json(['status' => 'error', 'text' => 'Akses ditolak: Superadmin hanya bisa melihat data.']);
        }
        $barang = Barang::find($id);
        if ($barang) {
            Historibarang::where('barang_id', $id)->delete();
            $barang->delete();
            return response()->json(['status' => 'sukses', 'text'=>'Barang '.$barang->name.' berhasil dihapus']);
        }
        return response()->json(['status' => 'error', 'text'=>'Data tidak ditemukan']);
    }

    public function delete($id)
    {
        $histori = Historibarang::with('barang')->find($id);
        if ($histori) {
            $histori->barang->decrement('stok');
            $histori->delete();
            return response()->json(['status' => 'sukses', 'text'=>'Histori berhasil dihapus']);
        }
        return response()->json(['status' => 'error', 'text'=>'Data tidak ditemukan']);
    }

    public function delete_keluar($id)
    {
        $histori = Historibarang::with('barang')->find($id);
        if ($histori) {
            $histori->barang->increment('stok');
            $histori->delete();
            return response()->json(['status' => 'sukses', 'text'=>'Histori berhasil dihapus']);
        }
        return response()->json(['status' => 'error', 'text'=>'Data tidak ditemukan']);
    }

    public function histori(Request $request, $id)
    {
        if (request()->ajax()) {
            $query = Historibarang::with('barang')->where('barang_id', $id)->orderBy('created_at', 'DESC');
            
            if (!empty($request->start_date)) {
                $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            } else {
                $query->whereDate('created_at', date('Y-m-d'));
            }

            return datatables()->of($query)
                ->addColumn('aksi', function ($h) {
                    return "<button class='delete btn btn-xs btn-danger' id=".$h->id.">Hapus</button>";
                })
                ->editColumn('name', function ($h) { return $h->barang->name ?? '-'; })
                ->editColumn('barcode', function ($h) { return $h->barang->barcode ?? '-'; })
                ->editColumn('created_at', function ($h) { return $h->created_at->format('d-m-Y H:i'); })
                ->editColumn('status', function ($h) {
                    return $h->status == 1 ? '<b class="text-success">Masuk</b>' : '<b class="text-danger">Keluar</b>';
                })
                ->rawColumns(['aksi', 'status'])
                ->make(true);
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
            'barcode' => 'required|string',
            'jumlah'  => 'required|numeric|min:1|max:100'
        ]);

        $qrData = QrCode::format('svg')->size(150)->errorCorrection('H')->generate($request->barcode);

        $qrcode = array_fill(0, $request->jumlah, ['barcode' => $qrData, 'nomor' => $request->barcode]);
        
        $pdf = PDF::loadView('gudang.cetak', compact('qrcode'));
        return $pdf->stream();
    }
}
