<?php

namespace App\Http\Controllers\Api;

use App\Models\Karyawan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\KaryawanResource;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawans = Karyawan::latest()->paginate(5);
        return new KaryawanResource(true, 'list data karyawan', $karyawans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:karyawans,email',
            'nomor_telepon' => 'required|string|max:15',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string',
            'tanggal_masuk' => 'required|date',
            'departemen_id' => 'required|exists:departemens,id',
            'jabatan_id' => 'required|exists:jabatans,id',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $karyawan = Karyawan::create($request->all());

        return new KaryawanResource(true, 'Karyawan Berhasil Ditambahkan', $karyawan);
    }

    public function show($id)
    {
        $karyawan = Karyawan::find($id);

        if ($karyawan) {
            return new KaryawanResource(true, 'Detail Data Karyawan', $karyawan);
        }

        return new KaryawanResource(false, 'Data Karyawan Tidak Ditemukan', null);
    }

    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return new KaryawanResource(false, 'Data Karyawan Tidak Ditemukan', null);
        }

        $request->validate([
            'nama_lengkap' => 'sometimes|required|string|max:100',
            'email' => 'sometimes|required|email|unique:karyawans,email,' . $id,
            'nomor_telepon' => 'sometimes|required|string|max:15',
            'tanggal_lahir' => 'sometimes|required|date',
            'alamat' => 'sometimes|required|string',
            'tanggal_masuk' => 'sometimes|required|date',
            'departemen_id' => 'sometimes|required|exists:departemens,id',
            'jabatan_id' => 'sometimes|required|exists:jabatans,id',
            'status' => 'sometimes|required|in:aktif,nonaktif',
        ]);

        $karyawan->update($request->all());

        return new KaryawanResource(true, 'Karyawan Berhasil Diupdate', $karyawan);
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);

        if ($karyawan) {
            $karyawan->delete();
            return new KaryawanResource(true, 'Karyawan Berhasil Dihapus', null);
        }

        return new KaryawanResource(false, 'Data Karyawan Tidak Ditemukan', null);
    }
}
