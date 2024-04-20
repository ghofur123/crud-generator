<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
class SettingController extends Controller
{
    public function jsonData(){

        $baseUrl = URL::to('/');
        $data = [
            'menu' => [
                '1' => [
                    'name' => 'siswa',
                    'page' => 'menu-utama',
                    'submenu' => null,
                    'status' => 'active',
                    'default' => true,
                    'url' => $baseUrl . '/api/siswa',
                    'form' => [
                        'nama','nisn', 'nik'
                    ]
                ],
                '2' => [
                    'name' => 'profile',
                    'page' => 'menu-utama',
                    'submenu' => null,
                    'status' => 'active',
                    'default' => true,
                    'url' => $baseUrl . '/api/profile',
                    'form' => [
                        'name', 'image', 'visimisi'
                    ]
                ]
            ]
        ];
        
    return response()->json($data);
    }
}
