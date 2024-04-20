<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

class SettingController extends Controller
{
    public function jsonData()
    {
        // $data = Cache::remember('setting_data', 3600, function () {
        $baseUrl = url('/');

        $data =  [
            'menu' => [
                [
                    'name' => 'siswa',
                    'page' => 'menu-utama',
                    'submenu' => null,
                    'status' => 'active',
                    'default' => true,
                    'url' => $baseUrl . '/api/siswa',
                    'form' => ['nama', 'nisn', 'alamat'],
                    'type' => [
                        // text / textarea / file
                        'select_nama',
                        'select_api',
                        'select_action_to'
                    ],
                    'select_nama' => [
                        'type' => 'select',
                        'value' => ['a', 'b', 'c', 'd'],
                        'option' => ['A', 'B', 'C', 'D']
                    ],
                    'select_api' => [
                        'type' => 'select_api',
                        'url' => $baseUrl . '/api/select-coba'
                    ],
                    'select_action_to' => [
                        'type' => 'select_action_to',
                        // click,keyup,change
                        'on' => 'change',
                        'url' => $baseUrl . '/api/select-coba-2',

                        'name_action_to' => 'select_api'
                    ]
                ],
                [
                    'name' => 'profile',
                    'page' => 'menu-utama',
                    'submenu' => null,
                    'status' => 'active',
                    'default' => true,
                    'url' => $baseUrl . '/api/profile',
                    'form' => ['name', 'image', 'visimisi'],
                    'type' => ['text', 'file', 'text']
                ]
            ],
            'description' => [
                'brand' => 'Crud Generator',
                'simple-brand' => 'CGT',
                'title' => 'simple crud generator'
            ]
        ];
        // });

        return response()->json($data);
    }
}
