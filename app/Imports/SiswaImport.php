<?php

namespace App\Imports;

use App\Models\SiswaExcel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SiswaImport implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new SiswaExcel([
            'nama' => $row[1],
'nisn' => $row[2],
'alamat' => $row[3],
        ]);
    }
}
