<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Validator;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $member = Member::orderBy('created_at', 'DESC')->get();
        if (request()->ajax()) {
            return datatables()->of($member)
            ->addColumn('aksi', function ($member) {

                $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=".$member->id.">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$member->id.">Hapus</button>
                </div>";

                return $button;
            })
            ->editColumn('no_plat', function ($member){
                $plat = '<a href="#" class="fw-medium text-nowrap">'.$member->no_plat.'</a>';
                return $plat;
            })
            ->rawColumns(['aksi', 'no_plat'])
            ->make(true);
        }
        return view('admin.member.index');
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
            'no_plat'           => 'required|string',
            'tipe_mobil'        => 'required|string',
            'name'              => 'required|string',
            'phone'             => 'required|string',
        ],[
            'no_plat.required'     => 'Isi Kolom Nomor Plat',
            'no_plat.unique'       => 'Plat Nomor '.$this->plat($request->no_plat).' sudah terdaftar',
            'tipe_mobil.required'  => 'Isi kolom Tipe Mobil',
            'name.required'        => 'Isi kolom nama pemilik',
            'phone.required'       => 'Isi kolom No WhatsApp'
        ]);

        if ($validator->passes()) {
            $validasi = Member::where('no_plat', $this->plat($request->no_plat))->first();
            if ($validasi) {
                return response()->json(['status' => 'gagal', 'text'=>'Plat Kendaraan '.$this->plat($request->no_plat).' sudah terdaftar']);
            }
            $member = Member::create([
                'no_plat'   => $this->plat($request->no_plat),
                'tipe_mobil'=> strtoupper($request->tipe_mobil),
                'name'      => ucwords($request->name),
                'phone'     => $request->phone
            ]);
            return response()->json(['text'=>'Member '.$member->name.' berhasil ditambah.']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    private function plat($text)
    {
        $string = strtoupper(trim($text));

        $pattern = '/^([A-Z]{1,3})(\s|-)*([1-9][0-9]{0,3})(\s|-)*([A-Z]{0,3}|[1-9][0-9]{1,2})$/i';
        if (preg_match($pattern, $string)) {
            return trim(strtoupper(preg_replace($pattern, '$1 $3 $5', $string)));
        }
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
        $member = Member::find($id);
        return response()->json(['status' => 'sukses', 'data' => $member]);
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
            'no_plat'           => 'required|string',
            'tipe_mobil'        => 'required|string',
            'name'              => 'required|string',
            'phone'             => 'required|string',
        ],[
            'no_plat.required'     => 'Isi Kolom Nomor Plat',
            'no_plat.unique'       => 'Plat Nomor '.$this->plat($request->no_plat).' sudah terdaftar',
            'tipe_mobil.required'  => 'Isi kolom Tipe Mobil',
            'name.required'        => 'Isi kolom nama pemilik',
            'phone.required'       => 'Isi kolom No WhatsApp'
        ]);

        if ($validator->passes()) {
            $member = Member::find($id);
            if ($member->no_plat === $this->plat($request->no_plat)) {
                $member->update([
                    'no_plat'   => $this->plat($request->no_plat),
                    'tipe_mobil'=> strtoupper($request->tipe_mobil),
                    'name'      => ucwords($request->name),
                    'phone'     => $request->phone
                ]);

                return response()->json(['text'=>'Member '.$member->name.' berhasil diubah.']);
            }else{
                $no_plat =  Member::where('no_plat', $this->plat($request->no_plat))->first();
                if ($no_plat) {
                    return response()->json(['status' => 'gagal', 'text'=>'Plat Kendaraan '.$this->plat($request->no_plat).' sudah terdaftar']);
                }else {
                    $member->update([
                        'no_plat'   => $this->plat($request->no_plat),
                        'tipe_mobil'=> strtoupper($request->tipe_mobil),
                        'name'      => ucwords($request->name),
                        'phone'     => $request->phone
                    ]);

                    return response()->json(['text'=>'Member '.$member->name.' berhasil diubah.']);
                }

            }

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
        $member = Member::find($id);
        if ($member) {
            $member->delete();
            return response()->json(['text'=>'Member '.$member->name.' berhasil dihapus.']);
        }

        return response()->json(['status' => 'gagal', 'text'=>'Data tidak ditemukan']);

    }
}
