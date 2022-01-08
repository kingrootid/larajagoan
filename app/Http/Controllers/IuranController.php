<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Rumah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IuranController extends Controller
{
    public function index()
    {
        $rumah = DB::table('wargas')
            ->Join('rumahs', 'rumahs.kepala_keluarga', '=', 'wargas.id')
            ->select('rumahs.id', 'wargas.name', 'wargas.alamat', 'rumahs.nomor')
            ->get();
        $data = [
            'page' => 'Iuran Warga Management',
            'user' => Auth::user(),
            'rumah' => $rumah
        ];
        return view('iuran.warga', $data);
    }
    public function pengeluaran()
    {
        $data = [
            'page' => 'Pengeluaran Kas Management',
            'user' => Auth::user(),
            'category' => Category::all()
        ];
        return view('iuran.pengeluaran', $data);
    }
    public function history()
    {
        $data = [
            'page' => 'History Kas',
            'user' => Auth::user(),
        ];
        return view('iuran.history', $data);
    }
}
