<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{

    public function index()
    {
        $data = [
            'page' => 'Management Warga',
            'user' => Auth::user(),
        ];
        return view('warga.index', $data);
    }
}
