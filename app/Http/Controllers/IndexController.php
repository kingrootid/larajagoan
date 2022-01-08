<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index()
    {
        // $saldo = DB::table('kas')->select(["sum(CASE WHEN type = 'Pemasukan' THEN saldo ELSE 0 END) as pemasukan", "sum(CASE WHEN type = 'Pengeluaran' THEN saldo ELSE 0 END) as pengeluaran"])->first();
        $data = [
            'page' => 'Dashboard',
            'user' => Auth::user(),
            // 'saldo' => $saldo
        ];
        return view('index', $data);
    }
}
