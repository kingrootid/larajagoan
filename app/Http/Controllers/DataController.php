<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Iuran;
use App\Models\Kas;
use App\Models\Pengeluaran;
use App\Models\Rumah;
use App\Models\User;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataController extends Controller
{
    public function __construct()
    {
        // if (!request()->ajax()) {
        //     exit('Not Allowed Direct access >.<');
        // }
    }
    public function warga()
    {
        return datatables()->of(Warga::all())->addIndexColumn()->editColumn('ktp', function ($row) {
            $image_url = asset('files') . '/ktp/' . $row['ktp'];
            return "<img class='img-thumbnail' src='$image_url'>";
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-info' href='javascript:;' onclick='detail(" . $row['id'] . ")'><i class='fa fa-search''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action', 'ktp'])->make(true);
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
    public function iuran_warga()
    {
        return datatables()->of(Iuran::all())->addIndexColumn()->editColumn('rumah_id', function ($row) {
            $rumah = Rumah::where('id', $row['rumah_id'])->first();
            $kk = Warga::where('id', $rumah['kepala_keluarga'])->first();
            return $kk['name'];
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action', 'rumah_id'])->make(true);
    }
    public function getiuran_warga($id)
    {
        $data = Iuran::where('id', $id)->first();
        return $data;
    }
    public function category()
    {
        return datatables()->of(Category::all())->addIndexColumn()->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action', 'rumah_id'])->make(true);
    }
    public function getCategory($id)
    {
        $data = Category::where('id', $id)->first();
        return $data;
    }
    public function pengeluaran()
    {
        return datatables()->of(Pengeluaran::all())->addIndexColumn()->editColumn('category', function ($row) {
            $data = Category::where('id', $row['category'])->first();
            return (empty($data)) ? 'Data sudah dihapus' : $data->name;
        })->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action', 'rumah_id'])->make(true);
    }
    public function getPengeluaran($id)
    {
        $data = Pengeluaran::where('id', $id)->first();
        return $data;
    }
    public function history(Request $request)
    {
        $now = date('m/Y');
        if (!$request) {
            $data = Kas::where('periode', $now)->get();
        } else {
            $periode = (empty($request['periode']) ? $now : $request['periode']);
            $data = Kas::where('periode', $periode)->get();
        }
        return datatables()->of($data)->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action', 'rumah_id'])->make(true);
    }
    public function admin()
    {
        return datatables()->of(User::all())->addIndexColumn()->addColumn('action', function ($row) {
            $actionBtn = "<a class='btn btn-icon waves-effect btn-warning' href='javascript:;' onclick='edit(" . $row['id'] . ")'><i class='fa fa-edit''></i></a> ";
            $actionBtn .= "<a class='btn btn-icon waves-effect btn-danger' href='javascript:;' onclick='hapus(" . $row['id'] . ")'><i class='fa fa-trash''></i></a>";
            return $actionBtn;
        })->rawColumns(['action'])->make(true);
    }
    public function getAdmin($id)
    {
        $data = User::where('id', $id)->first();
        return $data;
    }
}
