<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

use App\Http\Requests\ProfileFirebaseRequest;
use App\Helpers\PaginationHelper;


class ProfileFirebaseController extends Controller
{
    public function __construct(){
        $factory = (new Factory)
        ->withServiceAccount('firebase-credentials.json')
        ->withDatabaseUri('https://companyprofile-fb284-default-rtdb.firebaseio.com/');

        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }


    public function index(Request $request)
    {
        $pageSize = 10;
        $page = $request->input('page', 1);;
        $offset = ($page - 1) * $pageSize;

        $ref = $this->database->getReference('profile')->orderByKey()->getValue(); // Hapus limitToFirst

        $totalData = count($ref);

        $slicedRef = array_slice($ref, $offset, $pageSize);

        $response = [
            'data' => $slicedRef,
            'totalData' => $totalData,
            'page' => $page,
            'pageSize' => $pageSize,
            'links' => PaginationHelper::generateLinks($page, $pageSize, $totalData, url()->current()),
        ];

        return response()->json($response);
    }



    public function show($id)
    {
        $ref = $this->database->getReference('profile/'.$id)->getValue();
        return response()->json($ref);
    }
    public function store(ProfileFirebaseRequest $request)
    {
        $ref = $this->database->getReference('profile/'.uniqid())
        ->set([
            'name' => $request->input('name'),
		'alamat' => $request->input('alamat'),
        ]);

        return response()->json([
            "status" => true,
            "message" => 'Data berhasil dimasukkan ke dalam database'
        ], 201);
    }
    public function update(ProfileFirebaseRequest $request, $id)
    {
        $ref = $this->database->getReference('profile/'.$id)
        ->update([
            'name' => $request->input('name'),
		'alamat' => $request->input('alamat'),
        ]);

        return response()->json([
            "status" => true,
            "message" => 'Data berhasil di update ke dalam database'
        ], 201);
    }
    public function destroy($id)
    {
        $ref = $this->database->getReference('profile/'.$id)->remove();
        return response()->json([
            "status" => true,
            "message" => 'Data berhasil di hapus dari database'
        ], 201);
    }
    
}
