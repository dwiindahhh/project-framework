<?php

namespace App\Http\Controllers\Api;

use App\Models\Absensi;
use App\Http\Controllers\Controller;
use App\Http\Resources\AbsensiResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AbsensiController extends Controller
{
    public function index()
    {
        $Absensi = Absensi::paginate(5);
        return new AbsensiResource(true, 'List Data Absensi', $Absensi);
    }

    public function show($id)
    {
        $Absensi = Absensi::find($id);
        if ($Absensi) {
            return new AbsensiResource(true, 'Data Absensi ditemukan', $Absensi);
        }
        return new AbsensiResource(false, 'Absensi tidak ditemukan', null);
    }

    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'karyawan_id' => 'required|exists:karyawans,id',
        'tanggal' => 'required|date',
        'waktu_masuk' => 'required|date_format:H:i',
        'status_absensi' => 'required|in:hadir,izin,sakit,alpha',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Buat data absensi baru (waktu_keluar bisa null untuk sementara)
    $absensi = Absensi::create([
        'karyawan_id' => $request->karyawan_id,
        'tanggal' => $request->tanggal,
        'waktu_masuk' => $request->waktu_masuk,
        'waktu_keluar' => null, // Default: null karena belum absen keluar
        'status_absensi' => $request->status_absensi,
    ]);

    return new AbsensiResource(true, 'Absensi masuk berhasil', $absensi);
}


public function update(Request $request, $id)
{
    $validator = Validator::make($request->all(), [
        'waktu_keluar' => 'required|date_format:H:i',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Cari data absensi berdasarkan ID atau kombinasi karyawan dan tanggal
    $absensi = Absensi::where('id', $id)->first();

    if (!$absensi) {
        return response()->json(['message' => 'Data absensi tidak ditemukan'], 404);
    }

    // Update waktu_keluar
    $absensi->update([
        'waktu_keluar' => $request->waktu_keluar,
    ]);

    return new AbsensiResource(true, 'Absensi keluar berhasil', $absensi);
}


    public function destroy($id)
    {
        $Absensi = Absensi::find($id);
        if (!$Absensi) {
            return new AbsensiResource(false, 'Absensi tidak ditemukan', null);
        }

        $Absensi->delete();
        return new AbsensiResource(true, 'Absensi berhasil dihapus', null);
    }
}