<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = [
            'app_name' => config('app.name'),
        ];

        return response()->json($response);
    }
}
