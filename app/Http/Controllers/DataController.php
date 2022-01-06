<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataController extends Controller
{
    public function __construct()
    {
        if (!request()->ajax()) {
            exit('Not Allowed Direct access >.<');
        }
    }
    public function warga()
    {
        return datatables()->of(Warga::all())->addIndexColumn()->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action'])->make(true);
    }
    public function rumah()
    {
        return datatables()->of(Rumah::all())->addIndexColumn()->editColumn('kepala_keluarga', function ($row) {
            return Warga::where('id', $row['kepala_keluarga'])->first()['name'];
        })->editColumn('penghuni', function ($row) {
            $data = json_decode($row['penghuni']);
            $html = '<ul style="list-style: none;">';
            foreach ($data as $penghuni) {
                $dPenghuni = Warga::where('id', $penghuni)->first()['name'];
                $html .= "<li>$dPenghuni</li>";
            }
            $html .= "</ul>";
            return $html;
        })->addColumn('alamat', function ($row) {
            return Warga::where('id', $row['kepala_keluarga'])->first()['alamat'];
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['penghuni', 'action', 'alamat'])->make(true);
    }
    public function getWarga($id)
    {
        return Warga::where('id', $id)->first();
    }
    public function getRumah($id)
    {
        $data = Rumah::where('id', $id)->first();
        $data['penghuni'] = json_decode($data['penghuni']);
        return $data;
    }
    public function wargaNotKK()
    {
        $data = [];
        $dataWarga = DB::table('wargas')
            ->leftJoin('rumahs', 'rumahs.kepala_keluarga', '=', 'wargas.id')
            ->select('wargas.id', 'wargas.name')
            ->whereNull('rumahs.id')
            ->get();
        foreach ($dataWarga as $object) {
            $dRumah = DB::table('rumahs')
                ->where('kepala_keluarga', '<>', $object->id)
                ->where('penghuni', 'LIKE', '%"' . $object->id . '"%')
                ->select('id')
                ->get()->toArray();
            if (empty($dRumah)) {
                array_push($data, (array) $object);
            }
        }
        return $data;
    }
}
