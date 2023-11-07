<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Auth;
use Kreait\Firebase\ServiceAccount;
use Firebase\Auth\Token\Exception\InvalidToken;
use Kreait\Firebase\Exception\Auth\RevokedIdToken;
use Illuminate\Support\Collection;

class FirebaseFileController extends Controller
{
    protected $auth;
    protected $bucket;

    public function __construct(){
        $factory = (new Factory)
            ->withServiceAccount('firebase-credentials.json')
            ->withDatabaseUri('https://companyprofile-fb284-default-rtdb.firebaseio.com/');

        $this->auth = $factory->createAuth();
        $storage = $factory->createStorage();
        $this->bucket = $storage->getBucket();
    }

    public function index(Request $request)
    {
        $pageLimit = 10;
        $objects = $this->bucket->objects();

        $imageUrls = [];
        $imageNames = [];
        foreach ($objects as $object) {
            $imageUrls[] = $object->signedUrl(new \DateTime('tomorrow'));
            $imageNames[] = $object->name();
        }

        return response()->json(['image_url' => $imageUrls, 'image_name' => $imageNames],200);

    }
    private function generatePaginationLinks($currentPage, $pageSize, $totalImages)
    {
        $lastPage = ceil($totalImages / $pageSize);

        $links = [
            'first' => url()->current() . '?page=1',
            'last' => url()->current() . '?page=' . $lastPage,
            'prev' => $currentPage > 1 ? url()->current() . '?page=' . ($currentPage - 1) : null,
            'next' => $currentPage < $lastPage ? url()->current() . '?page=' . ($currentPage + 1) : null,
        ];

        return $links;
    }




    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $destination = 'images/' . time() . '_' . $image->getClientOriginalName();

            try {
                $object = $this->bucket->upload(
                    file_get_contents($image),
                    ['name' => $destination]
                );

                $url = $object->signedUrl(new \DateTime('tomorrow'));

                // Sekarang Anda dapat menyimpan URL ke database atau melakukan apa yang Anda inginkan dengan data ini
                return response()->json(['url' => $url]);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal mengunggah gambar: ' . $e->getMessage()], 500);
            }
        }

        return response()->json(['message' => 'Tidak ada file gambar yang diunggah.'], 400);
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $object = $this->bucket->object("images/".$id);

            if (!$object->exists()) {
                return response()->json(['message' => 'Gambar tidak ditemukan.'], 404);
            }

            $imageUrl = $object->signedUrl(new \DateTime('tomorrow'));

            return response()->json(['url' => $imageUrl]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengambil gambar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar JPEG, PNG, JPG, GIF maksimal 2MB
        ]);

        try {
            $object = $this->bucket->object($id);

            if (!$object->exists()) {
                return response()->json(['message' => 'Gambar tidak ditemukan.'], 404);
            }

            $image = $request->file('image');
            $destination = 'images/' . time() . '_' . $image->getClientOriginalName();

            $object->upload(
                file_get_contents($image),
                ['name' => $destination]
            );

            $url = $object->signedUrl(new \DateTime('tomorrow'));

            return response()->json(['url' => $url]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal mengupdate gambar: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $object = $this->bucket->object("images/".$id);

            if (!$object->exists()) {
                return response()->json(['message' => 'Gambar tidak ditemukan.'], 404);
            }

            $object->delete();

            return response()->json(['message' => 'Gambar berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus gambar: ' . $e->getMessage()], 500);
        }
    }
}
