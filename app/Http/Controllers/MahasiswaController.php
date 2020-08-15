<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mahasiswa;
use App\Http\Facades\DB;

class MahasiswaController extends Controller
{
    public function index()
    {
        try {
            $mhs = Mahasiswa::leftJoin('prodis', function($join) { 
                $join->on('prodis.id', '=', 'mahasiswas.prodi_id')
                        ->on('prodis.id', '=', 
                        \DB::raw("(SELECT max(id) from prodis WHERE prodis.id = mahasiswas.prodi_id)")); 
                })
                ->leftJoin('matkuls', function($join) {
                    $join->on('matkuls.id', '=', 'mahasiswas.prodi_id')
                    ->on('matkuls.id', '=', 
                    \DB::raw("(SELECT max(id) from matkuls WHERE matkuls.id = mahasiswas.prodi_id)")); 
                })
                ->select(array('mahasiswas.*', 'prodis.name as prodi_id', 'matkuls.name as matkul_id'))
                ->get();
    
            return response()->json($mhs);
        }
        catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }

    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required',
            'avatar' => 'required',
            'prodi_id' => 'required',
            'matkul_id' => 'required'
        ]);

        $mhs = new Mahasiswa();
        $mhs->name = $request->name;
        $mhs->avatar = $request->avatar;
        $mhs->prodi_id = $request->prodi_id;
        $mhs->matkul_id = $request->matkul_id;
        $mhs->save();

        return response()->json($mhs, 201);
    }

    public function show($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        
        return response()->json($mhs);
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'name' => 'required',
            'avatar' => 'required',
            'prodi_id' => 'required',
            'matkul_id' => 'required'
        ]);

        $mhs = new Mahasiswa();
        $mhs->name = $request->name;
        $mhs->avatar = $request->avatar;
        $mhs->prodi_id = $request->prodi_id;
        $mhs->matkul_id = $request->matkul_id;
        $mhs->update();

        return response()->json($mhs, 200);
    }

    public function destroy($id)
    {
        $mhs = Mahasiswa::findOrFail($id);
        $mhs->delete();

        return response()->json(null, 204);
    }
}
