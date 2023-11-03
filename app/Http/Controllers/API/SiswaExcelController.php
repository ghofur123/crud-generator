<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Exports\SiswaExport;
use App\Imports\SiswaImport;
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

        $destinationPath = public_path('excel');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $fileName);

        Excel::import(new SiswaImport, public_path('excel/' . $fileName));

        sleep(5);

        unlink(public_path('excel/' . $fileName));
        return response([
            'success' => true,
            'message' => 'data berhasil di simpan'
        ],201);
    }
    public function export()
    {
        return Excel::download(new SiswaExport, 'Siswa.xlsx');
    }
}
