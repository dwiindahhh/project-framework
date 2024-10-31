<?php

namespace App\Http\Controllers\Api;

use App\Models\Departemen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\DepartemenResource;
use Illuminate\Support\Facades\Validator;

class DepartemenController extends Controller
{
    public function index()
    {
        $departemens = Departemen::latest()->paginate(5);
        return new DepartemenResource(true, 'list data departemen', $departemens);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        $departemen = Departemen::create([
            'nama_departemen' => $request->nama_departemen,
        ]);

        return new DepartemenResource(true, 'Departemen Berhasil Ditambahkan', $departemen);
    }

    public function show($id)
    {
        $departemen = Departemen::find($id);

        if ($departemen) {
            return new DepartemenResource(true, 'Detail Data Departemen', $departemen);
        }

        return new DepartemenResource(false, 'Data Departemen Tidak Ditemukan', null);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_departemen' => 'required|string|max:100',
        ]);

        $departemen = Departemen::find($id);

        if ($departemen) {
            $departemen->update([
                'nama_departemen' => $request->nama_departemen,
            ]);

            return new DepartemenResource(true, 'Departemen Berhasil Diupdate', $departemen);
        }

        return new DepartemenResource(false, 'Data Departemen Tidak Ditemukan', null);
    }

    public function destroy($id)
    {
        $departemen = Departemen::find($id);

        if ($departemen) {
            $departemen->delete();
            return new DepartemenResource(true, 'Departemen Berhasil Dihapus', null);
        }

        return new DepartemenResource(false, 'Data Departemen Tidak Ditemukan', null);
    }
}
