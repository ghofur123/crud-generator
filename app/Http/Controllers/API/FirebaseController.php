<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

use App\Http\Requests\SiswaRequest;


class FirebaseController extends Controller
{
    public function __construct(){
        $factory = (new Factory)
        ->withServiceAccount('firebase-credentials.json')
        ->withDatabaseUri('https://companyprofile-fb284-default-rtdb.firebaseio.com/');

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }
    public function index()
    {
        $ref = $this->database->getReference('siswa')->getValue();

        return response()->json($ref);
    }
    public function show()
    {

    }
    public function store(SiswaRequest $request)
    {
        $ref = $this->database->getReference('siswa/'.uniqid())
        ->set([
            'nama' => $request->input('nama'),
            'nisn' => $request->input('nisn'),
            'alamat' => $request->input('alamat'),
        ]);

        return response()->json([
            "status" => true,
            "message" => 'Data berhasil dimasukkan ke dalam database'
        ], 201);
    }
    public function update(SiswaRequest $request, $id)
    {
        $ref = $this->database->getReference('siswa/'.$id)
        ->update([
            'nama' => $request->input('nama'),
            'nisn' => $request->input('nisn'),
            'alamat' => $request->input('alamat'),
        ]);

        return response()->json([
            "status" => true,
            "message" => 'Data berhasil di update ke dalam database'
        ], 201);
    }
    public function destroy($id)
    {
        $ref = $this->database->getReference('siswa/'.$id)->remove();
        return response()->json([
            "status" => true,
            "message" => 'Data berhasil di hapus dari database'
        ], 201);
    }
    
}
