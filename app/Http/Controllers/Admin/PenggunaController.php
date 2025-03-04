<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class PenggunaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::orderBy('created_at', 'DESC')->with('role')->get();
        if (request()->ajax()) {
            return datatables()->of($user)
            ->addColumn('aksi', function ($user) {

                $button = "<div class='d-flex justify-content-center align-items-center'>
                <button class='edit btn btn-elevated-warning w-24 me-1 mb-2' id=".$user->id.">Edit</button>
                <button class='delete btn btn-elevated-danger w-24 me-1 mb-2' id=".$user->id.">Hapus</button>
                </div>";

                return $button;
            })
            ->editColumn('username', function ($user){
                $username = '<a href="#" class="fw-medium text-nowrap">'.$user->username.'</a>';
                return $username;
            })
            ->editColumn('name', function ($user){
                $name = '<a href="#" class="fw-medium text-nowrap">'.$user->name.'</a>';
                return $name;
            })
            ->addColumn('role', function ($user){
                $role = '<a href="#" class="fw-medium text-nowrap">'.$user->role->role.'</a>';
                return $role;
            })
            ->rawColumns(['aksi', 'username', 'name', 'role'])
            ->make(true);
        }
        return view('admin.pengguna.index');
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
            'username'          => 'required|string|unique:users',
            'name'              => 'required|string',
            'role'              => 'required|string',
            'password'          => 'required|string|min:8'
        ],[
            'username.required' => 'Isi kolom Username',
            'username.unique'   => 'Username '.$request->phone.' sudah terdaftar',
            'role.required'     => 'Pilih Role Pengguna',
            'password.required' => 'Isi Kolom Password',
            'password.min'      => 'Password harus 8 Karakter'
        ]);

        if ($validator->passes()) {
            $user = User::create([
                'username'  => $request->username,
                'name'      => ucwords($request->name),
                'password'  => Hash::make($request->password)
            ]);

            Role::create([
                'user_id'   => $user->id,
                'role'      => $request->role,
            ]);

            return response()->json(['text'=>'Pengguna '.$user->name.' berhasil ditambah.']);
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
        $user = User::where('id', $id)->with('role')->first();
        return response()->json(['status' => 'sukses', 'data' => $user]);
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
            'username'          => 'required|string|unique:users,username,'.$id,
            'name'              => 'required|string',
            'role'              => 'required|string',
            'password'          => 'nullable|string|min:8'
        ],[
            'username.required' => 'Isi kolom Username',
            'username.unique'   => 'Username '.$request->username.' sudah terdaftar',
            'role.required'     => 'Pilih Role Pengguna',
            'password.required' => 'Isi Kolom Password',
            'password.min'      => 'Password harus 8 Karakter'
        ]);

        if ($validator->passes()) {
            $user = User::where('id', $id)->with('role')->first();
            if ($request->password == null) {
                $user->update([
                    'username'  => $request->username,
                    'name'      => ucwords($request->name),
                ]);

                $user->role->update([
                    'user_id'   => $user->id,
                    'role'      => $request->role,
                ]);

                return response()->json(['text'=>'Pengguna '.$user->name.' berhasil diubah.']);
            }

            $user->update([
                'username'  => $request->username,
                'name'      => ucwords($request->name),
                'password'  => Hash::make($request->password)
            ]);

            $user->role->update([
                'user_id'   => $user->id,
                'role'      => $request->role,
            ]);

            return response()->json(['text'=>'Pengguna '.$user->name.' berhasil diubah.']);
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
        //
    }
}
