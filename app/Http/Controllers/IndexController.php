<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        $saldo = array('pemasukan' => 0, 'pengeluaran' => 0);
        $kas = Kas::all()->toArray();
        foreach ($kas as $d) {
            if ($d['type'] == "Pengeluaran") {
                $saldo['pengeluaran'] = $saldo['pengeluaran'] + $d['saldo'];
            } else {
                $saldo['pemasukan'] = $saldo['pemasukan'] + $d['saldo'];
            }
        }
        $data = [
            'page' => 'Dashboard',
            'user' => Auth::user(),
            'kas' => $saldo
        ];
        return view('index', $data);
    }
}
