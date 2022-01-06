<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AjaxController extends Controller
{
    public function warga(Request $request)
    {
        if ($request['status'] == "add") {
            $validateData = $this->validate($request, [
                'name' => 'required|unique:wargas',
                'email' => 'required',
                'tanggal_lahir' => 'required',
                'alamat' => 'required',
                'jenis_kelamin' => 'required',
                'status_perkawinan' => 'required',
                'ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $fileName = 'KTP_' . $request->name . '.' . $request->ktp->getClientOriginalExtension();
            $validateData['ktp'] = $fileName;
            $request->ktp->move(public_path('files/ktp'), $fileName);
            if (Warga::create($validateData)) {
                return ['error' => 0, 'message' => 'Berhasil Tambah Warga Baru'];
            } else {
                return ['error' => 1, 'message' => 'Gagal Tambah Warga Baru'];
            }
        } else if ($request['status'] == "edit") {
            $validateData = $this->validate($request, [
                'name' => 'required',
                'email' => 'required',
                'tanggal_lahir' => 'required',
                'alamat' => 'required',
                'jenis_kelamin' => 'required',
                'status_perkawinan' => 'required',
            ]);
            $getOld = Warga::where('id', $request['id'])->first();
            if (!$request->ktp) {
                $validateData['ktp'] = $getOld['ktp'];
            } else {
                $validateData['ktp'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
                $fileName = 'KTP_' . $request->name . '.' . $request->ktp->getClientOriginalExtension();
                $validateData['ktp'] = $fileName;
                $request->ktp->move(public_path('files/ktp'), $fileName);
            }
            if (Warga::where('id', $getOld['id'])->update($validateData)) {
                return ['error' => 0, 'message' => 'Berhasil Edit Warga'];
            } else {
                return ['error' => 1, 'message' => 'Gagal Edit Warga'];
            }
        } else if ($request->status == "hapus") {
            if (Warga::where('id', $request->id)->delete()) {
                return ['error' => 0, 'message' => 'Berhasil Hapus Warga'];
            } else {
                return ['error' => 1, 'message' => 'Gagal Hapus Warga'];
            }
        } else {
            return ['error' => 1, 'message' => 'Action Undefined'];
        }
    }
    public function rumah(Request $request)
    {
        if ($request['status'] == "add") {
            $validateData = $this->validate($request, [
                'kepala_keluarga' => 'required|unique:rumahs',
                'nomor' => 'required',
                'penghuni' => 'required',
            ]);
            if (empty(in_array($validateData['kepala_keluarga'], $validateData['penghuni']))) {
                $validateData['penghuni'] = json_encode($validateData['penghuni']);
                if (Rumah::create($validateData)) {
                    return ['error' => 0, 'message' => 'Berhasil Tambah Rumah Baru'];
                } else {
                    return ['error' => 1, 'message' => 'Gagal Tambah Rumah Baru'];
                }
            }
            return ['error' => 1, 'message' => 'Tidak bisa menambahkan kepala keluarga didalam data penghuni'];
        } else if ($request['status'] == "edit") {
            $validateData = $this->validate($request, [
                'kepala_keluarga' => 'required',
                'nomor' => 'required',
                'penghuni' => 'required',
            ]);
            if (empty(in_array($validateData['kepala_keluarga'], $validateData['penghuni']))) {
                $validateData['penghuni'] = json_encode($validateData['penghuni']);
                // $searchKK = Rumah::where('kepala_keluarga', $validateData['kepala_keluarga'])->first();
                foreach (json_decode($validateData['penghuni']) as $checkPenghuni) {
                    $dRumah = DB::table('rumahs')
                        ->where('penghuni', 'LIKE', '%"' . $checkPenghuni . '"%')
                        ->where('id', '<>', $request['id'])
                        ->select('id')
                        ->get()->toArray();
                    if ($dRumah) {
                        return ['error' => 1, 'message' => 'Salah satu penghuni sudah masuk dalam salah satu rumah'];
                    }
                }
                if (Rumah::where('id', $request['id'])->update($validateData)) {
                    return ['error' => 0, 'message' => 'Berhasil Edit Data Rumah'];
                } else {
                    return ['error' => 1, 'message' => 'Gagal Edit Data Rumah'];
                }
            }
            return ['error' => 1, 'message' => 'Tidak bisa menambahkan kepala keluarga didalam data penghuni'];
        } else if ($request->status == "hapus") {
            if (Rumah::where('id', $request->id)->delete()) {
                return ['error' => 0, 'message' => 'Berhasil Hapus Data Rumah'];
            } else {
                return ['error' => 1, 'message' => 'Gagal Hapus Data Rumah'];
            }
        } else {
            return ['error' => 1, 'message' => 'Action Undefined'];
        }
    }
}
