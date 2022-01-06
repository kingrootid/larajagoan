<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function rumah()
    {
        $data = [
            'page' => 'Management Rumah Warga',
            'user' => Auth::user(),
            'allWarga' => Warga::all()
        ];
        return view('warga.rumah', $data);
    }
}
