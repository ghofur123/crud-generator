<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Http\Resources\SiswaResource;

class SiswaSetValueController extends Controller
{
    public function search(Request $request)
    {
        $searchTerm = $request->input('searchTerm');
        $siswa = Siswa::where('nama', 'like', "%$searchTerm%")
            ->orWhere('nisn', 'like', "%$searchTerm%")
            ->orWhere('alamat', 'like', "%$searchTerm%")
            ->paginate(15);
        return SiswaResource::collection($siswa);
    }
}
