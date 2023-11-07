<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;

use App\Http\Requests\ProductFirebaseRequest;
use App\Helpers\PaginationHelper;
use App\Factories\FirebaseFactory;

class ProductFirebaseController extends Controller
{
    public function __construct(FirebaseFactory $firebaseFactory){
        $this->firebaseFactory = $firebaseFactory;
        $factory = $this->firebaseFactory->create();
        $this->auth = $factory->createAuth();
        $this->database = $factory->createDatabase();
    }
    public function index(Request $request)
    {
        $pageSize = 10;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $pageSize;

        $ref = $this->database->getReference('product')->orderByKey()->getValue(); // Hapus limitToFirst

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
        $ref = $this->database->getReference('product/'.$id)->getValue();

        return response()->json($ref);
    }
    public function store(ProductFirebaseRequest $request)
    {
        $ref = $this->database->getReference('product/'.uniqid())
        ->set([
            'titile' => $request->input('titile'),
		'kategori' => $request->input('kategori'),
		'description' => $request->input('description'),
		'image' => $request->input('image'),
		'stok' => $request->input('stok'),
        ]);

        return response()->json([
            "status" => true,
            "message" => 'Data berhasil dimasukkan ke dalam database'
        ], 201);
    }
    public function update(ProductFirebaseRequest $request, $id)
    {
        $ref = $this->database->getReference('product/'.$id)
        ->update([
            'titile' => $request->input('titile'),
		'kategori' => $request->input('kategori'),
		'description' => $request->input('description'),
		'image' => $request->input('image'),
		'stok' => $request->input('stok'),
        ]);

        return response()->json([
            "status" => true,
            "message" => 'Data berhasil di update ke dalam database'
        ], 201);
    }
    public function destroy($id)
    {
        $ref = $this->database->getReference('product/'.$id)->remove();
        return response()->json([
            "status" => true,
            "message" => 'Data berhasil di hapus dari database'
        ], 201);
    }
    
}
