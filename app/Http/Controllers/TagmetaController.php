<?php

namespace App\Http\Controllers;

use App\Models\Tagmeta;
use Illuminate\Http\Request;
use Validator;

class TagmetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tagmeta = Tagmeta::orderBy('created_at', 'ASC')->first();
        return view('tagmeta.index', compact('tagmeta'));
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
            'keywords'      => 'required|string',
            'title'         => 'required|string',
            'description'   => 'required|string',
        ],[
            'keywords.required'     => 'Isi Kolom Keywords',
            'title.required'        => 'Isi Kolom Title',
            'description.required'  => 'Isi Kolom Deskripsi'
        ]);

        if ($validator->passes()) {
            Tagmeta::create([
                'keywords'  => ucwords($request->keywords),
                'title'     => ucwords($request->title),
                'description' => $request->description
            ]);

            return response()->json(['text' => 'Data berhasil ditambahkan']);
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
        $tagmeta = Tagmeta::orderBy('created_at', 'ASC')->first();
        return response()->json(['data' => $tagmeta]);
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
            'keywords'      => 'required|string',
            'title'         => 'required|string',
            'description'   => 'required|string',
        ],[
            'keywords.required'     => 'Isi Kolom Keywords',
            'title.required'        => 'Isi Kolom Title',
            'description.required'  => 'Isi Kolom Deskripsi'
        ]);

        if ($validator->passes()) {
            $tagmeta = Tagmeta::find($id);
            $tagmeta->update([
                'keywords'  => ucwords($request->keywords),
                'title'     => ucwords($request->title),
                'description' => $request->description
            ]);

            return response()->json(['text' => 'Data berhasil diubah']);
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
