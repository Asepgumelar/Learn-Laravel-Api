<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Models\Matkul;
use App\Models\Prodi;

class MatkulController extends Controller
{
    public function index()
    {
        try {
            // $matkul = Matkul::leftJoin('prodis', function($join) { 
            //     $join->on('prodis.id', '=', 'matkuls.prodi_id')
            //             ->on('prodis.id', '=', 
            //             \DB::raw("(SELECT max(id) from prodis WHERE prodis.id = matkuls.prodi_id)")); 
            //     })
            //     ->select(array('matkuls.*', 'prodis.name as prodi_id', 'matkuls.name as matkul_id'))
            //     ->get();

            $matkul = Matkul::with('prodi')->get();
            
            if ($matkul->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'data empty'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $matkul
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' =>false,
                'message' => 'data empty'
            ]);
        }
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'prodi_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->error()->all()
                ], 422);
            }
    
            $id_prodi = Prodi::findOrFail($request->prodi_id);
            $matkul = new Matkul();
            $matkul->name = $request->name;

            if ($id_prodi) {
                $matkul->prodi_id = $id_prodi->id;
            }

            $matkul->save();

            \DB::commit();

            return response()->json([
                'success'   => true,
                'message'   => 'Matkul has been added',
                'data'      => $matkul
            ], 201);
        }
        catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {

            $matkul = Matkul::findOrFail($id);

            return response()->json($matkul);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Not Found'
            ]);
        }
    }

    public function update(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'prodi_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors()->all() ,
                    'data'      => null
                ], 422);
            }
    
            $id_prodi = Prodi::findOrFail($request->prodi_id);
            $matkul = Matkul::findOrFail($request->id);
            $matkul->name = $request->name;
            if ($id_prodi) {
                $matkul->prodi_id = $id_prodi->id;
            }

            $matkul->update();

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Matkul Has Been Added',
                'data' => $matkul
            ], 200);
        }
        catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage(),
                'data'      => null
            ], 500);
        }

    }

    public function destroy($id)
    {
        try {
            $matkul = Matkul::findOrFail($id);
            $matkul->delete();

            return response()->json([
                'success' => true,
                'message' => 'Matkul Has Been Deleted'
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete entry'
            ]);
        }
    }
}
