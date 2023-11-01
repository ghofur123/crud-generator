<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiswaExcel extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = [
        'nama',
'nisn',
'alamat',
    ];
}