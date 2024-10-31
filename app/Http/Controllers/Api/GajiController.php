<?php

namespace App\Http\Controllers\Api;

use App\Models\Gaji;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\GajiResource;
use Illuminate\Support\Facades\Validator;

class GajiController extends Controller
{
    public function index()
    {
        $gajis = Gaji::latest()->paginate(5);
        return new GajiResource(true, 'List Data gaji', $gajis);
    }

    public function store(Request $request)
    {
        $request->validate([
            'karyawan_id' => 'required|exists:karyawans,id',
            'bulan' => 'required|string|max:10',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan' => 'required|numeric|min:0',
            'potongan' => 'required|numeric|min:0',
            'total_gaji' => 'required|numeric|min:0',
        ]);

        $gaji = Gaji::create($request->all());

        return new GajiResource(true, 'Gaji Berhasil Ditambahkan', $gaji);
    }

    public function show($id)
    {
        $gaji = Gaji::find($id);

        if ($gaji) {
            return new GajiResource(true, 'Detail Data Gaji', $gaji);
        }

        return new GajiResource(false, 'Data Gaji Tidak Ditemukan', null);
    }

    public function update(Request $request, $id)
    {
        $gaji = Gaji::find($id);

        if (!$gaji) {
            return new GajiResource(false, 'Data Gaji Tidak Ditemukan', null);
        }

        $request->validate([
            'karyawan_id' => 'sometimes|required|exists:karyawans,id',
            'bulan' => 'sometimes|required|string|max:10',
            'gaji_pokok' => 'sometimes|required|numeric|min:0',
            'tunjangan' => 'sometimes|required|numeric|min:0',
            'potongan' => 'sometimes|required|numeric|min:0',
            'total_gaji' => 'sometimes|required|numeric|min:0',
        ]);

        $gaji->update($request->all());

        return new GajiResource(true, 'Gaji Berhasil Diupdate', $gaji);
    }

    public function destroy($id)
    {
        $gaji = Gaji::find($id);

        if ($gaji) {
            $gaji->delete();
            return new GajiResource(true, 'Gaji Berhasil Dihapus', null);
        }

        return new GajiResource(false, 'Data Gaji Tidak Ditemukan', null);
    }
}
