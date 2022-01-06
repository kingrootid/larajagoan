<?php

namespace App\Http\Controllers;

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
        $data = [];
        $notKK = DB::select(DB::raw('SELECT wargas.id, wargas.name FROM wargas LEFT JOIN rumahs ON wargas.id = rumahs.id WHERE rumahs.id IS NULL OR wargas.id IN (rumahs.penghuni)'));
        print_r($notKK);
        // for ($i = 0; $i < count($notKK); $i++) {
        //     echo $notKK[0][$i]['id'];
        // }
        // dd($notKK);
        die();
        $data = [
            'page' => 'Management Rumah Warga',
            'user' => Auth::user(),
            'warga' => Warga::all()
        ];
        return view('warga.rumah', $data);
    }
}
