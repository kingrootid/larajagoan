<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

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
    public function getWarga($id)
    {
        return Warga::where('id', $id)->first();
    }
}
