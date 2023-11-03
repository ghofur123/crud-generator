<?php
 
namespace App\Exports;
 
use App\Models\SiswaExcel;
use Maatwebsite\Excel\Concerns\FromCollection;
 
class SiswaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return SiswaExcel::all();
    }
}