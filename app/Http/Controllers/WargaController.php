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
        $data = [];
        $dataWarga = DB::table('wargas')
            ->leftJoin('rumahs', 'rumahs.id', '=', 'wargas.id')
            ->select('wargas.id', 'wargas.name')
            ->whereNull('rumahs.id')
            ->get();
        foreach ($dataWarga as $object) {
            $dRumah = DB::table('rumahs')
                ->where('penghuni', 'LIKE', '%"' . $object->id . '"%')
                ->select('id')
                ->get()->toArray();
            if (empty($dRumah)) {
                array_push($data, (array) $object);
            }
        }
        $data = [
            'page' => 'Management Rumah Warga',
            'user' => Auth::user(),
            'warga' => $data,
            'allWarga' => Warga::all()
        ];
        return view('warga.rumah', $data);
    }
}
