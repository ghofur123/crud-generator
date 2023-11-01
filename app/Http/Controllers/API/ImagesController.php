<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Models\Images;
use App\Http\Requests\ImagesRequest;
use App\Http\Resources\ImagesResource;
use Illuminate\Support\Facades\URL;

class ImagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Images = Images::paginate(15);
        return ImagesResource::collection($Images);
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
    public function store(ImagesRequest $request)
    {
    	// name form in blade = file
    	$file = $request->file('file');
    	$fileName = uniqid() . $file->getClientOriginalName();
        $Images = new Images;
        $Images->user_id = $request->input('user_id');
        $Images->name = $fileName;
        $Images->ext_name = $file->getClientOriginalExtension();
        $Images->type = $file->getMimeType();
        $Images->size = $file->getSize();
        $Images->path = $file->getRealPath();
        $Images->url = URL::asset('uploads/');
        $Images->save();
		$file->move(public_path('uploads'), $fileName);
        return response()->json($Images, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $Images = Images::findOrFail($id);
        return new ImagesResource($Images);
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
    public function update(ImagesRequest $request, $id)
    {
        // Mendapatkan data yang akan diupdate
        $Images = Images::find($id);

        // Menghapus gambar lama dari folder
        if (File::exists(public_path('uploads/' . $Images->name))) {
            File::delete(public_path('uploads/' . $Images->name));
        }

        // Mengganti gambar lama dengan gambar yang baru
        $file = $request->file('file');
        $fileName = uniqid() . $file->getClientOriginalName();

        $Images->name = $fileName;
        $Images->ext_name = $file->getClientOriginalExtension();
        $Images->type = $file->getMimeType();
        $Images->size = $file->getSize();
        $Images->path = $file->getRealPath();

        $file->move(public_path('uploads'), $fileName);

        $Images->save();

        return response()->json($Images, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Images = Images::findOrFail($id);
        $Images->delete();

        return response()->json(null, 204);
    }
}
