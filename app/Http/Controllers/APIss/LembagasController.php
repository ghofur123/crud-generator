<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Lembaga;
use App\Http\Requests\LembagaRequest;
use App\Http\Resources\LembagaResource;

class LembagasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lembagas = Lembaga::paginate(15);
        return LembagaResource::collection($lembagas);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  LembagaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LembagaRequest $request)
    {
        $lembaga = new Lembaga;
		$lembaga->npsn = $request->input('npsn');
		$lembaga->nama_lembaga = $request->input('nama_lembaga');
		$lembaga->alamat = $request->input('alamat');
        $lembaga->save();

        return response()->json($lembaga, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lembaga = Lembaga::findOrFail($id);
        return new LembagaResource($lembaga);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  LembagaRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LembagaRequest $request, $id)
    {
        $lembaga = Lembaga::findOrFail($id);
		$lembaga->npsn = $request->input('npsn');
		$lembaga->nama_lembaga = $request->input('nama_lembaga');
		$lembaga->alamat = $request->input('alamat');
        $lembaga->save();

        return response()->json($lembaga);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lembaga = Lembaga::findOrFail($id);
        $lembaga->delete();

        return response()->json(null, 204);
    }
}
