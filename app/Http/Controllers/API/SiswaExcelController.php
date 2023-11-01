<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Imports\Siswa;
use App\Models\SiswaExcel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SiswaExcelController extends Controller
{
    public function import(Request $request)
    {
        // name form in blade
        $file = $request->file('file');
        $fileName = uniqid() . str_replace(' ', '', $file->getClientOriginalName());

        $file->move(public_path('excel', $fileName));

        Excel::import(new Siswa, public_path('excel/' . $fileName));

        sleep(5);

        unlink(public_path('excel/' . $fileName));
        return response([
            'success' => true,
            'message' => 'data berhasil di simpan'
        ]);
    }
    public function export()
    {

    }
}
