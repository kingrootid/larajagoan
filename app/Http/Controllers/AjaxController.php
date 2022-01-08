<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Iuran;
use App\Models\Kas;
use App\Models\Pengeluaran;
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
    public function iuran_warga(Request $request)
    {
        if ($request['status'] == "add") {
            $validateData = $this->validate($request, [
                'rumah_id' => 'required',
                'jumlah' => 'required',
                'periode' => 'required',
            ]);
            try {
                DB::beginTransaction();
                $rumah = DB::table('wargas')
                    ->Join('rumahs', 'rumahs.kepala_keluarga', '=', 'wargas.id')
                    ->where('rumahs.id', '=', $validateData['rumah_id'])
                    ->select('rumahs.id', 'wargas.name', 'wargas.alamat', 'rumahs.nomor')
                    ->first();
                $iuran = Iuran::create($validateData);
                $insertKas = [
                    'type' => 'Pemasukan',
                    'deskripsi' => 'Pembayaran Iuran Bulanan Periode ' . $validateData['periode'] . ' Rumah Keluarga Bpk/Ibu : ' . $rumah->name,
                    'saldo' => $validateData['jumlah'],
                    'periode' => $validateData['periode']
                ];
                $kas = Kas::create($insertKas);
                if ($kas && $iuran) {
                    DB::commit();
                    return ['error' => 0, 'message' => 'Berhasil Tambah Iuran Warga'];
                } else {
                    return ['error' => 1, 'message' => 'Gagal Tambah Iuran Warga'];
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                return ['error' => 1, 'message' => 'Gagal Tambah Iuran Warga', 'errorMessage' => $e];
            }
        } else if ($request['status'] == "edit") {
            $oldData = Iuran::where('id', $request['id'])->first();
            $validateData = $this->validate($request, [
                'rumah_id' => 'required',
                'jumlah' => 'required',
                'periode' => 'required',
            ]);
            try {
                DB::beginTransaction();
                $rumah = DB::table('wargas')
                    ->Join('rumahs', 'rumahs.kepala_keluarga', '=', 'wargas.id')
                    ->where('rumahs.id', '=', $validateData['rumah_id'])
                    ->select('rumahs.id', 'wargas.name', 'wargas.alamat', 'rumahs.nomor')
                    ->first();
                $getKas = Kas::where('type', 'Pemasukan')->where('deskripsi', 'LIKE', '%' . $oldData->periode . '%')->where('periode', $validateData['periode'])->where('saldo', $oldData->jumlah)->first();
                $iuran = Iuran::where('id', $request['id'])->update($validateData);
                $insertKas = [
                    'type' => 'Pemasukan',
                    'deskripsi' => 'Pembayaran Iuran Bulanan Periode ' . $validateData['periode'] . ' Rumah Keluarga Bpk/Ibu : ' . $rumah->name,
                    'saldo' => $validateData['jumlah'],
                    'periode' => $validateData['periode']
                ];
                $kas = Kas::where('id', $getKas->id)->update($insertKas);
                if ($kas && $iuran) {
                    DB::commit();
                    return ['error' => 0, 'message' => 'Berhasil Edit Iuran Warga'];
                } else {
                    return ['error' => 1, 'message' => 'Gagal Edit Iuran Warga'];
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                return ['error' => 1, 'message' => 'Gagal Edit Iuran Warga', 'errorMessage' => $e];
            }
        } else if ($request['status'] == "hapus") {
            $oldData = Iuran::where('id', $request['id'])->first();
            try {
                DB::beginTransaction();
                $getKas = Kas::where('type', 'Pemasukan')->where('deskripsi', 'LIKE', '%' . $oldData->periode . '%')->where('saldo', $oldData->jumlah)->first();
                $iuran = Iuran::where('id', $request['id'])->delete();
                $kas = Kas::where('id', $getKas->id)->delete();
                if ($kas && $iuran) {
                    DB::commit();
                    return ['error' => 0, 'message' => 'Berhasil Hapus Iuran Warga'];
                } else {
                    return ['error' => 1, 'message' => 'Gagal Hapus Iuran Warga'];
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                return ['error' => 1, 'message' => 'Gagal Hapus Iuran Warga', 'errorMessage' => $e];
            }
        } else {
            return ['error' => 1, 'message' => 'Action Undefined'];
        }
    }
    public function category(Request $request)
    {
        if ($request['status'] == "add") {
            $validateData = $this->validate($request, [
                'name' => 'required|unique:categories',
            ]);
            if (Category::create($validateData)) {
                return ['error' => 0, 'message' => 'Berhasil Tambah Category Baru'];
            } else {
                return ['error' => 1, 'message' => 'Gagal Tambah Category Baru'];
            }
        } else if ($request['status'] == "edit") {
            $validateData = $this->validate($request, [
                'name' => 'required'
            ]);
            if (Category::where('id', $request['id'])->update($validateData)) {
                return ['error' => 0, 'message' => 'Berhasil Edit Category'];
            } else {
                return ['error' => 1, 'message' => 'Gagal Edit Category'];
            }
        } else if ($request->status == "hapus") {
            if (Category::where('id', $request['id'])->delete()) {
                return ['error' => 0, 'message' => 'Berhasil Hapus Category'];
            } else {
                return ['error' => 1, 'message' => 'Gagal Hapus Category'];
            }
        } else {
            return ['error' => 1, 'message' => 'Action Undefined'];
        }
    }
    public function pengeluaran(Request $request)
    {
        if ($request['status'] == "add") {
            $validateData = $this->validate($request, [
                'category' => 'required',
                'deskripsi' => 'required',
                'jumlah' => 'required',
                'periode' => 'required'
            ]);
            try {
                DB::beginTransaction();
                $pengeluaran = Pengeluaran::create($validateData);
                $insertKas = [
                    'type' => 'Pengeluaran',
                    'deskripsi' => $validateData['deskripsi'],
                    'saldo' => $validateData['jumlah'],
                    'periode' => $validateData['periode']
                ];
                $kas = Kas::create($insertKas);
                if ($kas && $pengeluaran) {
                    DB::commit();
                    return ['error' => 0, 'message' => 'Berhasil Tambah pengeluaran'];
                } else {
                    return ['error' => 1, 'message' => 'Gagal Tambah pengeluaran'];
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                return ['error' => 1, 'message' => 'Gagal Tambah pengeluaran', 'errorMessage' => $e];
            }
        } else if ($request['status'] == "edit") {
            $getOld = Pengeluaran::where('id', $request['id'])->first();
            $validateData = $this->validate($request, [
                'category' => 'required',
                'deskripsi' => 'required',
                'jumlah' => 'required',
                'periode' => 'required'
            ]);
            try {
                DB::beginTransaction();
                $pengeluaran = Pengeluaran::where('id', $request['id'])->update($validateData);
                $getKas = Kas::where('type', 'Pengeluaran')->where('deskripsi', 'LIKE', '%' . $getOld->deskripsi . '%')->where('periode', $validateData['periode'])->where('saldo', $getOld->jumlah)->first();
                $UpdateKas = [
                    'type' => 'Pengeluaran',
                    'deskripsi' => $validateData['deskripsi'],
                    'saldo' => $validateData['jumlah'],
                    'periode' => $validateData['periode']
                ];
                $kas = Kas::where('id', $getKas->id)->update($UpdateKas);
                if ($kas && $pengeluaran) {
                    DB::commit();
                    return ['error' => 0, 'message' => 'Berhasil Edit Pengeluaran'];
                } else {
                    return ['error' => 1, 'message' => 'Gagal Edit Pengeluaran'];
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                return ['error' => 1, 'message' => 'Gagal Edit pengeluaran', 'errorMessage' => $e];
            }
        } else if ($request['status'] == "hapus") {
            $getOld = Pengeluaran::where('id', $request['id'])->first();
            try {
                DB::beginTransaction();
                $pengeluaran = Pengeluaran::where('id', $request['id'])->delete();
                $getKas = Kas::where('type', 'Pengeluaran')->where('deskripsi', 'LIKE', '%' . $getOld->deskripsi . '%')->where('saldo', $getOld->jumlah)->first();
                $kas = Kas::where('id', $getKas->id)->delete();
                if ($kas && $pengeluaran) {
                    DB::commit();
                    return ['error' => 0, 'message' => 'Berhasil Hapus Pengeluaran'];
                } else {
                    return ['error' => 1, 'message' => 'Gagal Hapus Pengeluaran'];
                    DB::rollback();
                }
            } catch (\Exception $e) {
                DB::rollback();
                return ['error' => 1, 'message' => 'Gagal Edit pengeluaran', 'errorMessage' => $e];
            }
        } else {
            return ['error' => 1, 'message' => 'Action Undefined'];
        }
    }
}
