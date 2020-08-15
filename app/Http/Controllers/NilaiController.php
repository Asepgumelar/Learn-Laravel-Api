<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nilai;

class NilaiController extends Controller
{
    public function index()
    {
        $nilai = Nilai::leftJoin('mahasiswas', function($join) { 
            $join->on('mahasiswas.id', '=', 'nilais.mahasiswa_id')
                    ->on('mahasiswas.id', '=', 
                    \DB::raw("(SELECT max(id) from mahasiswas WHERE mahasiswas.id = nilais.mahasiswa_id)")); 
                })
                ->select(array('nilais.*', 'mahasiswas.name as mahasiswa_id'))
                ->get();

        return response()->json($nilai);
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'value' => 'required',
            'mahasiswa_id' => 'required'
        ]);

        $nilai = new Nilai();
        $nilai->value = $request->value;
        $nilai->mahasiswa_id = $request->mahasiswa_id;
        $nilai->save();

        return response()->json($nilai, 201);
    }

    public function show()
    {
        $nilai = Nilai::findOrFail($id);

        return responnse()->json($nilai);
    }

    public function update(Request $request, $id)
    {
        $this->validate(request(), [
            'value' => 'required',
            'mahasiswa_id' => 'required'
        ]);

        $nilai = Nilai::findOrFail($id);
        $nilai->value = $request->value;
        $nilai->mahasiswa_id = $request->mahasiswa_id;
        $nilai->update();

        return response()->json($nilai, 200);
    }

    public function destroy($id)
    {
        try {
            $nilai = Nilai::findOrFailId($id);
            $nilai->delete();

            return response()->json([
                'success' => true,
                'message' => 'Nilai deleted'
            ]);
        }

        catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
