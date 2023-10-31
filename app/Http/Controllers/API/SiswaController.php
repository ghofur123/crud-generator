<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Siswa;
use App\Http\Requests\SiswaRequest;
use App\Http\Resources\SiswaResource;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Siswa = Siswa::paginate(15);
        return SiswaResource::collection($Siswa);
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
    public function store(SiswaRequest $request)
    {

        $Siswa = new Siswa;
        $Siswa->nama = $request->input('nama');
        $Siswa->nisn = $request->input('nisn');
        $Siswa->alamat = $request->input('alamat');
        $Siswa->save();

        return response()->json($Siswa, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Siswa = Siswa::findOrFail($id);
        return new SiswaResource($Siswa);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SiswaRequest $request, $id)
    {
        $Siswa = Siswa::findOrFail($id);
        $Siswa->nama = $request->input('nama');
        $Siswa->nisn = $request->input('nisn');
        $Siswa->alamat = $request->input('alamat');
        $Siswa->save();

        return response()->json($Siswa);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Siswa = Siswa::findOrFail($id);
        $Siswa->delete();

        return response()->json(null, 204);
    }
}
