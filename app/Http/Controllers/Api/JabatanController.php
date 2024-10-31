<?php

namespace App\Http\Controllers\Api;

use App\Models\Jabatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\JabatanResource;
use Illuminate\Support\Facades\Validator;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatans = Jabatan::latest()->paginate(5);
        return new JabatanResource(true, 'List Data Jabatans', $jabatans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100',
        ]);
        $jabatan = Jabatan::create([
            'nama_jabatan' => $request->nama_jabatan,
        ]);

        return new JabatanResource(true, 'Jabatan berhasil ditambahkan', $jabatan);
    }

    public function show($id)
    {
        $jabatan = Jabatan::find($id);

        if ($jabatan) {
            return new JabatanResource(true, 'Detail Data Jabatan', $jabatan);
        }

        return new JabatanResource(false, 'Data Jabatan Tidak Ditemukan', null);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|string|max:100',
        ]);

        $jabatan = Jabatan::find($id);

        if ($jabatan) {
            $jabatan->update([
                'nama_jabatan' => $request->nama_jabatan,
            ]);

            return new JabatanResource(true, 'Jabatan Berhasil Diupdate', $jabatan);
        }

        return new JabatanResource(false, 'Data Jabatan Tidak Ditemukan', null);
    }

    public function destroy($id)
    {
        $jabatan = Jabatan::find($id);

        if ($jabatan) {
            $jabatan->delete();
            return new JabatanResource(true, 'Jabatan Berhasil Dihapus', null);
        }

        return new JabatanResource(false, 'Data Jabatan Tidak Ditemukan', null);
    }

}
