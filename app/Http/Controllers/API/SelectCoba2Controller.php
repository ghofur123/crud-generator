<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelectCoba2Controller extends Controller
{
    public function index()
    {
        $data = array(
            'option' => [
                'name', 'asasd', 'asdasd', 'asdasdas'
            ],
            'value' => [
                'name', 'asasd', 'asdasd', 'asdasdas'
            ]
        );
        return response($data);
    }
}
